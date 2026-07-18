<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\Profile; 
use App\Models\Rekening;
use App\Models\Pengiriman; // <-- WAJIB DITAMBAHKAN AGAR BISA AKSES STATUS PESANAN

class AdminController extends Controller
{
    /**
     * 1. Menampilkan Halaman Dashboard Admin
     */
    public function index()
    {
        // 1. Ambil data Transaksi
        $semuaTransaksi = Pembayaran::with(['penawaran.permintaan.user', 'penawaran.petani', 'pengiriman'])
                                    ->latest('idPembayaran')
                                    ->take(5)
                                    ->get();
                                    
        // 2. Ambil semua data Akun
        $semuaAkun = User::latest()
                        ->take(5)
                        ->get();

        // 3. Hitung Statistik Utama
        // Hitung dana admin: Pembayaran Lunas, tapi pengiriman belum selesai
        $totalDanaAdmin = Pembayaran::where('StatusPembayaran', 'Lunas')
            ->whereDoesntHave('pengiriman', function ($query) {
                $query->whereIn('StatusPesanan', ['Pesanan Selesai', 'Selesai']);
            })
            ->sum('TotalBayar');
                                 
        $menungguVerifikasi = Pembayaran::where('StatusPembayaran', 'Menunggu Verifikasi Admin')->count();
        
        // Hitung transaksi sukses: Pengiriman sudah selesai
        $totalTransaksiSukses = Pembayaran::whereHas('pengiriman', function ($query) {
            $query->whereIn('StatusPesanan', ['Pesanan Selesai', 'Selesai']);
        })->sum('TotalBayar');
        
        $jumlahPetani = User::where('role', 'petani')->count();

        // 4. Kirim semua data ke view
        return view('admin.index', compact(
            'semuaTransaksi', 
            'semuaAkun',
            'totalDanaAdmin', 
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
        
        $profile = Profile::firstOrNew(['user_id' => $user->id]);
        $rekening = Rekening::firstOrNew(['user_id' => $user->id]);
        
        return view('admin.profil', compact('user', 'profile', 'rekening'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'NamaLengkap' => 'required|string|max:100',
            'NamaBank'    => 'required|string|max:50',
            'NoRekening'  => 'required|numeric',
            'NamaPemilik' => 'required|string|max:100',
            'password'    => 'required|current_password', 
        ], [
            'password.required' => 'Password harus diisi untuk mengonfirmasi keamanan.',
            'password.current_password' => 'Password yang Anda masukkan salah!',
        ]);

        $user = Auth::user();

        Profile::updateOrCreate(
            ['user_id' => $user->id],
            ['NamaLengkap' => $request->NamaLengkap]
        );

        Rekening::updateOrCreate(
            ['user_id' => $user->id],
            [
                'NamaBank'   => $request->NamaBank,
                'NoRekening' => $request->NoRekening,
                'AtasNama'   => $request->NamaPemilik, 
            ]
        );

        return redirect()->route('admin.profil')->with('success', 'Data Profil & Rekening Bersama berhasil diperbarui!');
    }

    /**
     * 2. Menampilkan Halaman Konfirmasi Pembayaran
     */
    public function konfirmasi()
    {
        $semuaTransaksi = Pembayaran::with(['penawaran.permintaan.user', 'penawaran.petani', 'pengiriman'])
                                    ->latest('idPembayaran')
                                    ->get();
                                    
        return view('admin.konfirmasi', compact('semuaTransaksi'));
    }

    /**
     * 3. Menampilkan Halaman Data Pengguna
     */
    public function pengguna()
    {
        $semuaAkun = User::latest()->get();
        return view('admin.pengguna', compact('semuaAkun'));
    }

    /**
     * 4. Menampilkan Detail Spesifik 1 Pengguna
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
        
        // 1. Update status uang (di tabel pembayarans)
        $pembayaran->update([
            'StatusPembayaran' => 'Lunas'
        ]);

        // 2. Buat/Update status barang (di tabel pengirimans)
        Pengiriman::updateOrCreate(
            ['idTawar' => $pembayaran->idTawar],
            ['StatusPesanan' => 'Petani Menyiapkan Barang']
        );

        return back()->with('success', 'Bukti pembayaran SAH! Petani sekarang akan menyiapkan dan mengirim komoditas.');
    }

    /**
     * 6. AKSI REFUND (Jika transaksi batal)
     */
    public function refundKePembeli($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        
        $pembayaran->update([
            'StatusPembayaran' => 'Ditolak'
        ]);

        Pengiriman::updateOrCreate(
            ['idTawar' => $pembayaran->idTawar],
            ['StatusPesanan' => 'Dibatalkan']
        );

        return back()->with('success', 'Transaksi dibatalkan. Dana berhasil dikembalikan ke pembeli.');
    }

    /**
     * 7. AKSI CAIRKAN DANA KE PETANI
     */
    public function cairkanKePetani($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        
        Pengiriman::updateOrCreate(
            ['idTawar' => $pembayaran->idTawar],
            ['StatusPesanan' => 'Pesanan Selesai', 'WaktuSelesai' => now()]
        );

        return back()->with('success', 'Dana berhasil dicairkan ke Petani dan Pesanan ditandai Selesai.');
    }

    /**
     * 8. AKSI TOLAK PEMBAYARAN OLEH ADMIN
     */
    public function tolakPembayaran($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        
        $pembayaran->update([
            'StatusPembayaran' => 'Ditolak'
        ]);

        Pengiriman::updateOrCreate(
            ['idTawar' => $pembayaran->idTawar],
            ['StatusPesanan' => 'Dibatalkan']
        );

        return back()->with('error', 'Bukti pembayaran ditolak! Transaksi dibatalkan.');
    }
}