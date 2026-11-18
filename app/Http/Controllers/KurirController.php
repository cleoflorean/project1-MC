<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengiriman;
use App\Models\PengirimanTracking;
use App\Models\DropPoint;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class KurirController extends Controller
{
    /**
     * Dashboard Kurir: menampilkan daftar tugas pengiriman kurir yang sedang login
     */
    public function dashboard(Request $request)
    {
        $kurirId = Auth::id();

        // Daftar pengiriman yang ditugaskan ke kurir ini
        $pengirimanSaya = Pengiriman::with([
                'penawaran.permintaan.user.profile',
                'penawaran.petani.profile',
                'tracking.dropPoint',
                'pembayaran'
            ])
            ->where('id_kurir', $kurirId)
            ->latest('updated_at')
            ->get();

        // Daftar paket siap kirim yang belum diambil kurir mana pun
        $paketTersedia = Pengiriman::with([
                'penawaran.permintaan.user.profile',
                'penawaran.petani.profile',
                'tracking'
            ])
            ->whereNull('id_kurir')
            ->whereIn('StatusPesanan', ['Dikirim', 'Menyiapkan Barang'])
            ->latest('updated_at')
            ->get();

        // Ringkasan Statistik
        $totalTugas = $pengirimanSaya->count();
        $sedangDiantar = $pengirimanSaya->filter(function($item) {
            return in_array($item->StatusPesanan, ['Dikirim', 'Dalam Pengiriman', 'Transit']);
        })->count();
        $selesai = $pengirimanSaya->filter(function($item) {
            return in_array($item->StatusPesanan, ['Menunggu Pesanan Diterima', 'Pesanan Selesai', 'Selesai']);
        })->count();

        return view('kurir.dashboard', compact(
            'pengirimanSaya',
            'paketTersedia',
            'totalTugas',
            'sedangDiantar',
            'selesai'
        ));
    }

    /**
     * Detail Pengiriman & Form Check-in Drop Point
     */
    public function detailPengiriman($id)
    {
        $pengiriman = Pengiriman::with([
                'penawaran.permintaan.user.profile',
                'penawaran.petani.profile',
                'penawaran.permintaan.komoditas',
                'pembayaran',
                'kurir.profile',
                'tracking.dropPoint'
            ])
            ->findOrFail($id);

        $dropPoints = DropPoint::orderBy('kota')->orderBy('nama_titik')->get();

        return view('kurir.detail', compact('pengiriman', 'dropPoints'));
    }

    /**
     * Kurir Mengambil Paket dari Petani
     */
    public function ambilPaket(Request $request, $id)
    {
        $request->validate([
            'foto_bukti' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'catatan'    => 'nullable|string|max:255',
        ]);

        $pengiriman = Pengiriman::findOrFail($id);

        // Upload bukti jika ada
        $pathFoto = null;
        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $filename = time() . '_ambil_' . $file->getClientOriginalName();
            $pathFoto = $file->storeAs('kurir_bukti', $filename, 'public');
        }

        // Generate nomor resi jika belum ada
        if (empty($pengiriman->no_resi)) {
            $pengiriman->no_resi = 'TH-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        }

        $pengiriman->id_kurir = Auth::id();
        $pengiriman->StatusPesanan = 'Dikirim';
        $pengiriman->WaktuKirim = $pengiriman->WaktuKirim ?: now();
        if ($pathFoto && empty($pengiriman->foto_resi_awal)) {
            $pengiriman->foto_resi_awal = $pathFoto;
        }
        $pengiriman->save();

        // Tambah tracking log
        PengirimanTracking::create([
            'idPengiriman' => $pengiriman->idPengiriman,
            'status_log'   => 'Paket diambil oleh Kurir Internal dari Petani',
            'catatan'      => $request->catatan ?: 'Paket telah diperiksa dalam kondisi baik dan siap diantar.',
            'foto_bukti'   => $pathFoto,
            'waktu_scan'   => now(),
        ]);

        return redirect()->back()->with('success', 'Paket berhasil diambil! Nomor Resi: ' . $pengiriman->no_resi);
    }

    /**
     * Kurir Check-in di Drop Point transit
     */
    public function checkinDropPoint(Request $request, $id)
    {
        $request->validate([
            'drop_point_id' => 'required|exists:drop_points,id',
            'foto_bukti'    => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'catatan'       => 'nullable|string|max:255',
        ]);

        $pengiriman = Pengiriman::findOrFail($id);
        $dropPoint = DropPoint::findOrFail($request->drop_point_id);

        $pathFoto = null;
        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $filename = time() . '_dp_' . $file->getClientOriginalName();
            $pathFoto = $file->storeAs('kurir_bukti', $filename, 'public');
        }

        // Catat tracking di drop point
        PengirimanTracking::create([
            'idPengiriman'  => $pengiriman->idPengiriman,
            'drop_point_id' => $dropPoint->id,
            'status_log'    => 'Paket tiba di ' . $dropPoint->nama_titik . ' (' . $dropPoint->kota . ')',
            'catatan'       => $request->catatan ?: 'Paket sedang dalam proses transit/penyortiran di gudang drop point.',
            'foto_bukti'    => $pathFoto,
            'waktu_scan'    => now(),
        ]);

        $pengiriman->update([
            'StatusPesanan' => 'Dikirim'
        ]);

        return redirect()->back()->with('success', 'Berhasil check-in di ' . $dropPoint->nama_titik . '!');
    }

    /**
     * Kurir Menyelesaikan Pengantaran ke Alamat Pembeli
     */
    public function selesaikanPengantaran(Request $request, $id)
    {
        $request->validate([
            'foto_bukti' => 'required|image|mimes:jpg,jpeg,png|max:3072',
            'catatan'    => 'nullable|string|max:255',
        ]);

        $pengiriman = Pengiriman::findOrFail($id);

        $pathFoto = null;
        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $filename = time() . '_selesai_' . $file->getClientOriginalName();
            $pathFoto = $file->storeAs('kurir_bukti', $filename, 'public');
        }

        // Catat tracking pengantaran selesai
        PengirimanTracking::create([
            'idPengiriman' => $pengiriman->idPengiriman,
            'status_log'   => 'Paket telah sampai di alamat tujuan dan diterima',
            'catatan'      => $request->catatan ?: 'Barang telah diserahkan langsung ke tangan penerima.',
            'foto_bukti'   => $pathFoto,
            'waktu_scan'   => now(),
        ]);

        $pengiriman->update([
            'StatusPesanan' => 'Menunggu Pesanan Diterima',
            'WaktuSelesai'  => now()
        ]);

        return redirect()->back()->with('success', 'Pengantaran selesai! Menunggu konfirmasi pesanan diterima oleh pembeli.');
    }

    /**
     * Halaman Publik / Lacak Nomor Resi
     */
    public function lacakResi(Request $request)
    {
        $noResi = $request->input('resi');
        $pengiriman = null;

        if ($noResi) {
            $pengiriman = Pengiriman::with([
                'penawaran.permintaan.user.profile',
                'penawaran.petani.profile',
                'penawaran.permintaan.komoditas',
                'kurir.profile',
                'tracking.dropPoint'
            ])
            ->where('no_resi', trim($noResi))
            ->first();
        }

        return view('lacak_resi', compact('pengiriman', 'noResi'));
    }
}
