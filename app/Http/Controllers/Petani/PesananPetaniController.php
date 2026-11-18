<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Pengiriman;
use App\Models\PengirimanTracking;
use App\Models\User;
use Illuminate\Support\Str;

class PesananPetaniController extends Controller
{
    /**
     * 1. Menampilkan halaman daftar pesanan masuk (DIFILTER KHUSUS PETANI YG LOGIN)
     */
    public function index()
    {
        $idPetaniLogin = auth()->id();

        $dataPesanan = Pembayaran::with(['penawaran.permintaan.user', 'ulasan', 'pengiriman.kurir', 'pengiriman.tracking'])
            ->whereHas('penawaran', function($query) use ($idPetaniLogin) {
                $query->where('idPetani', $idPetaniLogin);
            })
            ->latest()
            ->get();
        
        return view('petani.pesananmasuk', compact('dataPesanan'));
    }

    /**
     * 2. Aksi Kirim Barang 
     * (Hanya bisa diakses jika statusnya sudah diizinkan oleh Admin)
     */
    public function kirimBarang($id)
    {
        // Proteksi: Pastikan pesanan ini benar-benar milik si Petani
        $pesanan = Pembayaran::whereHas('penawaran', function($query) {
            $query->where('idPetani', auth()->id());
        })->findOrFail($id);
        
        // Ambil kurir internal jika ada
        $kurir = User::where('role', 'kurir')->first();

        // Cari atau buat Pengiriman
        $pengiriman = Pengiriman::where('idTawar', $pesanan->idTawar)->first();

        $noResi = $pengiriman->no_resi ?? ('TH-' . date('Ymd') . '-' . strtoupper(Str::random(6)));

        if (!$pengiriman) {
            $pengiriman = Pengiriman::create([
                'idTawar'       => $pesanan->idTawar,
                'id_kurir'      => $kurir ? $kurir->id : null,
                'no_resi'       => $noResi,
                'StatusPesanan' => 'Dikirim',
                'WaktuKirim'    => now(),
            ]);
        } else {
            $pengiriman->update([
                'id_kurir'      => $pengiriman->id_kurir ?: ($kurir ? $kurir->id : null),
                'no_resi'       => $pengiriman->no_resi ?: $noResi,
                'StatusPesanan' => 'Dikirim',
                'WaktuKirim'    => $pengiriman->WaktuKirim ?: now(),
            ]);
        }

        // Catat tracking awal jika belum ada
        if ($pengiriman->tracking()->count() === 0) {
            PengirimanTracking::create([
                'idPengiriman'  => $pengiriman->idPengiriman,
                'status_log'    => 'Pesanan siap dikirim dari kebun Petani',
                'catatan'       => 'Barang telah dikemas rapi. Menunggu kurir internal melakukan penjemputan.',
                'waktu_scan'    => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil! Nomor Resi ' . $pengiriman->no_resi . ' diterbitkan. Status pesanan: Menunggu Kurir / Dalam Pengiriman.');
    }

    /**
     * 3. Menampilkan Halaman Rincian/Detail Pesanan (Diproteksi)
     */
    public function detailPesanan($id)
    {
        $pesanan = Pembayaran::with(['penawaran.permintaan.user.profile', 'ulasan', 'pengiriman.kurir', 'pengiriman.tracking.dropPoint'])
            ->whereHas('penawaran', function($query) {
                $query->where('idPetani', auth()->id());
            })
            ->findOrFail($id);
        
        return view('petani.pesanan-detail', compact('pesanan'));
    }
}
