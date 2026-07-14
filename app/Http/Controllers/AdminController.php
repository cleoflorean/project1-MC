<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\AdminProfile; // <-- TAMBAHAN BARU

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
        return view('admin.index', compact(
            'semuaTransaksi', 
            'semuaAkun',
            'totalEscrow', 
            'menungguVerifikasi', 
            'totalTransaksiSukses', 
            'jumlahPetani'
        ));
    }

    /**
     * FITUR BARU: Menampilkan Halaman Profil & Rekening Admin
     */
    public function profil()
    {
        $user = Auth::user();
        $profile = $user->adminProfile ?? new AdminProfile();
        
        return view('admin.profil', compact('user', 'profile'));
    }

    /**
     * FITUR BARU: Proses Update Profil & Rekening Admin
     */
    public function updateProfil(Request $request)
    {
        $request->validate([
            'NamaLengkap' => 'required|string|max:100',
            'NamaBank'    => 'required|string|max:50',
            'NoRekening'  => 'required|numeric',
            'NamaPemilik' => 'required|string|max:100',
        ]);

        $user = Auth::user();

        AdminProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'NamaLengkap' => $request->NamaLengkap,
                'NamaBank'    => $request->NamaBank,
                'NoRekening'  => $request->NoRekening,
                'NamaPemilik' => $request->NamaPemilik,
            ]
        );

        return redirect()->route('admin.profil')->with('success', 'Data Profil & Rekening Bersama berhasil diperbarui!');
    }

    /**
     * 2. Menampilkan Halaman Konfirmasi Pembayaran (Menu Konfirmasi)
     */
    public function konfirmasi()
    {
        $semuaTransaksi = Pembayaran::with(['penawaran.permintaan.user', 'penawaran.petani'])
                                    ->latest('idPembayaran')
                                    ->get();
                                    
        return view('admin.konfirmasi', compact('semuaTransaksi'));
    }

    /**
     * 3. Menampilkan Halaman Data Pengguna (Menu Data Pengguna)
     */
    public function pengguna()
    {
        $semuaAkun = User::latest()->get();
        
        return view('admin.pengguna', compact('semuaAkun'));
    }

    /**
     * 4. Menampilkan Detail Spesifik 1 Pengguna (Saat tombol Detail diklik)
     */
    public function detailPengguna($id)
    {
        $user = User::findOrFail($id);
        
        return view('admin.detail_pengguna', compact('user'));
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
            'StatusPembayaran' => 'Ditolak',
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