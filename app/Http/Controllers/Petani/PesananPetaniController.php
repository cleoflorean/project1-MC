<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;

class PesananPetaniController extends Controller
{
    /**
     * 1. Menampilkan halaman daftar pesanan masuk (DIFILTER KHUSUS PETANI YG LOGIN)
     */
    public function index()
    {
        $idPetaniLogin = auth()->id();

        // Mengambil pesanan yang HANYA milik petani yang sedang login
        $pesanans = Pembayaran::with(['penawaran.permintaan.user', 'ulasan'])
            ->whereHas('penawaran', function($query) use ($idPetaniLogin) {
                $query->where('idPetani', $idPetaniLogin);
            })
            ->latest()
            ->get();
        
        return view('Petani.pesananmasuk', compact('pesanans'));
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
        
        // FIX: WaktuKirim dihapus agar tidak memicu error "Unknown column"
        $pesanan->update([
            'StatusPesanan' => 'Dikirim'
        ]);

        return redirect()->back()->with('success', 'Berhasil! Status pesanan telah diperbarui menjadi Sedang Dikirim.');
    }

    /**
     * 3. Menampilkan Halaman Rincian/Detail Pesanan (Diproteksi)
     */
    public function detailPesanan($id)
    {
        // Proteksi: Pastikan detail yang dibuka adalah miliknya
        $pesanan = Pembayaran::with(['penawaran.permintaan.user.pembeliProfile', 'ulasan'])
            ->whereHas('penawaran', function($query) {
                $query->where('idPetani', auth()->id());
            })
            ->findOrFail($id);
        
        return view('Petani.pesanan-detail', compact('pesanan'));
    }
}