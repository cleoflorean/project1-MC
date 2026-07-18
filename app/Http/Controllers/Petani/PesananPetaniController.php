<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Pengiriman; // WAJIB DITAMBAHKAN AGAR BISA UPDATE STATUS

class PesananPetaniController extends Controller
{
    /**
     * 1. Menampilkan halaman daftar pesanan masuk (DIFILTER KHUSUS PETANI YG LOGIN)
     */
    public function index()
    {
        $idPetaniLogin = auth()->id();

        // PERBAIKAN 1 & 2: Tambah 'pengiriman' dan ubah nama variabel jadi $dataPesanan
        $dataPesanan = Pembayaran::with(['penawaran.permintaan.user', 'ulasan', 'pengiriman'])
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
        
        // PERBAIKAN 3: Update StatusPesanan ke tabel pengirimans, bukan pembayarans
        Pengiriman::updateOrCreate(
            ['idTawar' => $pesanan->idTawar],
            ['StatusPesanan' => 'Dikirim']
        );

        return redirect()->back()->with('success', 'Berhasil! Status pesanan telah diperbarui menjadi Sedang Dikirim.');
    }

    /**
     * 3. Menampilkan Halaman Rincian/Detail Pesanan (Diproteksi)
     */
    public function detailPesanan($id)
    {
        // PERBAIKAN: Jangan lupa tambahkan 'pengiriman' di sini juga
        $pesanan = Pembayaran::with(['penawaran.permintaan.user.profile', 'ulasan', 'pengiriman'])
            ->whereHas('penawaran', function($query) {
                $query->where('idPetani', auth()->id());
            })
            ->findOrFail($id);
        
        return view('petani.pesanan-detail', compact('pesanan'));
    }
}