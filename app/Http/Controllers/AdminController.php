<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * 1. Menampilkan Halaman Dashboard Admin
     */
    public function index()
    {
        // 1. Ambil data Transaksi (Dibutuhkan di index.blade.php)
        $semuaTransaksi = Pembayaran::with(['penawaran.permintaan.user', 'penawaran.petani'])
                                    ->latest('idPembayaran')
                                    ->get();
                                    
        // 2. Ambil semua data Akun (Dibutuhkan di index.blade.php)
        $semuaAkun = User::latest()->get();

        // 3. Hitung Statistik Utama
        $totalEscrow = Pembayaran::where('StatusPembayaran', 'Lunas')
                                 ->where('StatusPesanan', '!=', 'Pesanan Selesai')
                                 ->sum('TotalBayar');
                                 
        $menungguVerifikasi = Pembayaran::where('StatusPembayaran', 'Menunggu Verifikasi Admin')->count();
        
        $totalTransaksiSukses = Pembayaran::where('StatusPesanan', 'Pesanan Selesai')->sum('TotalBayar');
        
        $jumlahPetani = User::where('role', 'petani')->count();

        // 4. Kirim semua data ke view
        return view('Admin.index', compact(
            'semuaTransaksi', 
            'semuaAkun',
            'totalEscrow', 
            'menungguVerifikasi', 
            'totalTransaksiSukses', 
            'jumlahPetani'
        ));
    }

    /**
     * 2. Menampilkan Halaman Konfirmasi Pembayaran (Menu Konfirmasi)
     */
    public function konfirmasi()
    {
        // Ambil semua data transaksi untuk dikonfirmasi
        $semuaTransaksi = Pembayaran::with(['penawaran.permintaan.user', 'penawaran.petani'])
                                    ->latest('idPembayaran')
                                    ->get();
                                    
        return view('Admin.konfirmasi', compact('semuaTransaksi'));
    }

    /**
     * 3. Menampilkan Halaman Data Pengguna (Menu Data Pengguna)
     */
    public function pengguna()
    {
        // Ambil semua akun pengguna
        $semuaAkun = User::latest()->get();
        
        return view('Admin.pengguna', compact('semuaAkun'));
    }

    /**
     * 4. Menampilkan Detail Spesifik 1 Pengguna (Saat tombol Detail diklik)
     */
    public function detailPengguna($id)
    {
        $user = User::findOrFail($id);
        
        // Return ke view detail pengguna
        return view('Admin.detail_pengguna', compact('user'));
    }

    /**
     * 5. AKSI VERIFIKASI PEMBAYARAN OLEH ADMIN
     */
    public function verifikasiPembayaran($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        
        $pembayaran->update([
            'StatusPembayaran' => 'Lunas',
            'StatusPesanan'    => 'Petani Menyiapkan Barang'
        ]);

        return back()->with('success', 'Bukti pembayaran SAH! Petani sekarang akan menyiapkan dan mengirim komoditas.');
    }

    /**
     * 6. AKSI REFUND (Jika transaksi batal)
     */
    public function refundKePembeli($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        
        $pembayaran->update([
            'StatusPembayaran' => 'Ditolak', // Atau 'Di-Refund'
            'StatusPesanan'    => 'Dibatalkan'
        ]);

        return back()->with('success', 'Transaksi dibatalkan. Dana berhasil dikembalikan ke pembeli.');
    }

    /**
     * 7. AKSI CAIRKAN DANA KE PETANI (Jika pembeli lupa klik selesai)
     */
    public function cairkanKePetani($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        
        $pembayaran->update([
            'StatusPesanan' => 'Pesanan Selesai'
        ]);

        return back()->with('success', 'Dana berhasil dicairkan ke Petani dan Pesanan ditandai Selesai.');
    }
}