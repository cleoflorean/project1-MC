<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Penawaran;
use App\Models\Ulasan;
use App\Models\User; // <-- TAMBAHKAN INI UNTUK MEMANGGIL DATA ADMIN
use Illuminate\Support\Facades\Storage;
use App\Models\AdminProfile;

class PembayaranController extends Controller
{
    public function store(Request $request, $idTawar)
    {
        $penawaran = Penawaran::findOrFail($idTawar);

        $cekPembayaran = Pembayaran::where('idTawar', $idTawar)->first();
        if ($cekPembayaran) {
            return redirect()->route('pembayaran.show', $idTawar);
        }

        $totalBayar = $penawaran->HargaTawar * $penawaran->JumlahTawar;

        $pembayaran = Pembayaran::create([
            'idTawar'          => $idTawar,
            'TotalBayar'       => $totalBayar,
            'StatusPembayaran' => 'Belum Bayar', 
            'StatusPesanan'    => 'Menunggu Pembayaran'
        ]);

        $penawaran->update(['Status' => 'Setuju']);

        return redirect()->route('pembayaran.show', $idTawar)
                         ->with('success', 'Tagihan berhasil dibuat. Silakan selesaikan pembayaran.');
    }

    public function show($idTawar)
{
    $pembayaran = Pembayaran::with(['penawaran.petani.petaniProfile'])
                            ->where('idTawar', $idTawar)
                            ->firstOrFail();

    // UBAH BAGIAN INI: 
    // Karena sistem kamu 1 Admin, kita cukup panggil baris pertama dari tabel admin_profiles
    $admin = AdminProfile::first();

    return view('Pembeli.pembayaran', compact('pembayaran', 'admin')); 
}

    public function uploadBukti(Request $request, $idPembayaran)
    {
        $request->validate([
            'BuktiTransfer' => 'required|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $pembayaran = Pembayaran::findOrFail($idPembayaran);

        if ($request->hasFile('BuktiTransfer')) {
            $file = $request->file('BuktiTransfer');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bukti_transfer', $filename, 'public');

            $pembayaran->update([
                'BuktiTransfer'    => $path,
                'StatusPembayaran' => 'Menunggu Verifikasi Admin', 
                'StatusPesanan'    => 'Menunggu Verifikasi Admin',
                'WaktuBayar'       => now() 
            ]);

            return redirect()->route('pembeli.riwayat')
                             ->with('success', 'Bukti transfer berhasil diunggah! Saat ini sedang menunggu verifikasi.');
        }

        return back()->with('error', 'Gagal mengunggah bukti transfer.');
    }

    public function riwayatTransaksi(Request $request)
    {
        $riwayat = Pembayaran::with(['penawaran.permintaan', 'penawaran.petani.petaniProfile', 'ulasan'])
            ->whereHas('penawaran.permintaan', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->latest('idPembayaran')
            ->get();

        return view('Pembeli.riwayat', compact('riwayat'));
    }

    public function detailTransaksi($id)
    {
        $pesanan = Pembayaran::with(['penawaran.permintaan', 'penawaran.petani.petaniProfile'])
                                ->findOrFail($id);

        return view('Pembeli.detail', compact('pesanan'));
    }

    public function pesananSelesai(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        
        $pembayaran->update([
            'StatusPesanan' => 'Selesai',
            'WaktuSelesai'  => now()
        ]);

        return back()->with('success', 'Pesanan telah diterima! Silakan berikan penilaian Anda.');
    }

    public function simpanUlasan(Request $request, $id)
    {
        $request->validate([
            'Rating' => 'required|integer',
            'MediaUlasan' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:10240' // Max 10MB
        ]);

        $path = null;
        if ($request->hasFile('MediaUlasan')) {
            $file = $request->file('MediaUlasan');
            $filename = time() . '_ulasan_' . $file->getClientOriginalName();
            $path = $file->storeAs('media_ulasan', $filename, 'public');
        }

        Ulasan::create([
            'idPembayaran' => $id,
            'Rating'       => $request->Rating,
            'Ulasan'       => $request->Ulasan ?? '',
            'MediaUlasan'  => $path
        ]);

        return back()->with('success', 'Terima kasih! Penilaian beserta media Anda berhasil dikirim.');
    }
}