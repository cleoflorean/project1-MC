<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RegisterController;

// Import Controller Pembeli
use App\Http\Controllers\PermintaanController as PembeliPermintaanController;
use App\Http\Controllers\PembayaranController;

// Import Controller Petani
use App\Http\Controllers\Petani\DashboardController;
use App\Http\Controllers\Petani\TawarController;
use App\Http\Controllers\Petani\PanenController;
use App\Http\Controllers\Petani\PermintaanController as PetaniPermintaanController;
use App\Http\Controllers\Petani\PetaniProfileController;
use App\Http\Controllers\Petani\PesananPetaniController;

// Import Controller Admin & Laporan
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LupaSandiController;
use App\Http\Controllers\KomplainController;
use App\Http\Controllers\LaporanController;

// =========================================================================
// HALAMAN PUBLIK (Akses tanpa login)
// =========================================================================

Route::get('/', function () {
    return view('pembeli.beranda');
})->name('beranda');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/lupa-sandi', [LupaSandiController::class, 'showLupaSandi'])->name('lupa-sandi');
Route::post('/lupa-sandi', [LupaSandiController::class, 'storeLupaSandi'])->name('lupa-sandi.kirim');


// =========================================================================
// HALAMAN PRIVATE (Wajib Login)
// =========================================================================
Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // =====================================================================
    // AREA PEMBELI
    // =====================================================================
    Route::get('/dashboard-pembeli', [PembeliPermintaanController::class, 'dashboard'])->name('pembeli');
    
    Route::prefix('pembeli')->group(function () {
        Route::get('/permintaan', [PembeliPermintaanController::class, 'index'])->name('permintaan.index');
        Route::post('/permintaan/store', [PembeliPermintaanController::class, 'store'])->name('permintaan.store');
        Route::delete('/permintaan/{id}', [PembeliPermintaanController::class, 'destroy'])->name('permintaan.destroy');

        Route::get('/permintaan/{id}/penawaran', [PembeliPermintaanController::class, 'lihatPenawaran'])->name('permintaan.penawaran');
        Route::patch('/penawaran/{id}/update-status', [PembeliPermintaanController::class, 'updateStatusPenawaran'])->name('pembeli.penawaran.update-status');
        Route::get('/pembeli/penawaran/{id}/foto', [PembeliPermintaanController::class, 'lihatFoto'])->name('pembeli.penawaran.foto');
        // Route untuk Info Petani
        Route::get('/pembeli/petani/{id}/info', [PembeliPermintaanController::class, 'showPetani'])->name('pembeli.petani.show');
      
        Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
        Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
        Route::post('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');

        Route::get('/pembayaran/{idTawar}', [PembayaranController::class, 'show'])->name('pembayaran.show');
        Route::post('/pembayaran/upload/{id}', [PembayaranController::class, 'uploadBukti'])->name('pembayaran.upload');

        Route::get('/riwayat-transaksi', [PembayaranController::class, 'riwayatTransaksi'])->name('pembeli.riwayat');
        Route::get('/riwayat-transaksi/{id}/detail', [PembayaranController::class, 'detailTransaksi'])->name('detail');
        Route::post('/riwayat-transaksi/{id}/selesai', [PembayaranController::class, 'pesananSelesai'])->name('pembeli.pesanan.selesai');
        Route::post('/riwayat-transaksi/{id}/ulasan', [PembayaranController::class, 'simpanUlasan'])->name('pembeli.ulasan');

        Route::get('/riwayat-transaksi/{idPembayaran}/komplain', [KomplainController::class, 'createKomplain'])->name('pembeli.komplain.create');
        Route::post('/riwayat-transaksi/komplain', [KomplainController::class, 'storeKomplain'])->name('pembeli.komplain.store');
    });

    // =====================================================================
    // AREA PETANI
    // =====================================================================
    Route::prefix('dashboard-petani')->group(function () {
        
        Route::get('/', [DashboardController::class, 'index'])->name('petani.dashboard');
        Route::view('/notifikasi', 'Petani.dashboard')->name('petani.notifikasi');

        Route::get('/profil', [PetaniProfileController::class, 'index'])->name('petani.profil');
        Route::post('/profil/update', [PetaniProfileController::class, 'update'])->name('petani.profil.update');
        Route::post('/profil/rekening', [PetaniProfileController::class, 'updateRekening'])->name('petani.profil.rekening');
        Route::get('/profil/ulasan', [PetaniProfileController::class, 'ulasan'])->name('petani.ulasan');
        Route::get('/profil/edit', [PetaniProfileController::class, 'edit'])->name('petani.profil.edit');
        Route::post('/profil/password', [PetaniProfileController::class, 'updatePassword'])->name('petani.password.update');

        Route::get('/permintaan', [PetaniPermintaanController::class, 'index'])->name('petani.permintaan.index');
        Route::get('/pasar', [PetaniPermintaanController::class, 'index'])->name('pasar.index');

        Route::prefix('penawaran')->group(function () {
            Route::get('/', [TawarController::class, 'index'])->name('tawar.index');
            Route::get('/tawar', [TawarController::class, 'create'])->name('tawar.create');
            Route::post('/tawar', [TawarController::class, 'store'])->name('tawar.store');
            Route::delete('/{id}', [TawarController::class, 'destroy'])->name('tawar.destroy');
        });

        Route::get('/pesanan-masuk', [PesananPetaniController::class, 'index'])->name('petani.pesanan');
        Route::get('/pesanan-masuk/{id}/detail', [PesananPetaniController::class, 'detailPesanan'])->name('petani.pesanan.detail');
        Route::post('/pesanan-masuk/{id}/terima', [PesananPetaniController::class, 'terimaPembayaran'])->name('petani.pesanan.terima');
        Route::post('/pesanan-masuk/{id}/kirim', [PesananPetaniController::class, 'kirimBarang'])->name('petani.pesanan.kirim');

        Route::get('/pengiriman/detail/{id}', function ($id) {
            return 'Detail Pengiriman ' . $id;
        })->name('pengiriman.detail');
    });

    // =====================================================================
    // AREA ADMIN (Pihak Ketiga / Pengawas Marketplace / Sistem Escrow)
    // =====================================================================
    Route::prefix('admin-dashboard')->group(function () {

        // 1. Halaman Utama Dashboard Admin
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        
        // 1.5. Halaman Profil & Rekening Admin (RUTE BARU)
        Route::get('/profil', [AdminController::class, 'profil'])->name('admin.profil');
        Route::put('/profil/update', [AdminController::class, 'updateProfil'])->name('admin.profil.update');
        
        // 2. Halaman Data Pengguna
        Route::get('/pengguna', [AdminController::class, 'pengguna'])->name('admin.pengguna');

        // 3. Halaman Detail Pengguna & Reset Sandi Darurat
        Route::get('/pengguna/{id}/detail', [AdminController::class, 'detailPengguna'])->name('admin.pengguna.detail');
        Route::post('/pengguna/{id}/reset-password', [AdminController::class, 'resetPassword'])->name('admin.pengguna.reset'); // Asumsi method ini ada

        // 4. Halaman Konfirmasi Pembayaran
        Route::get('/konfirmasi', [AdminController::class, 'konfirmasi'])->name('admin.konfirmasi');
        Route::post('/admin/transaksi/{id}/tolak', [App\Http\Controllers\AdminController::class, 'tolakPembayaran'])->name('admin.transaksi.tolak');
        
        // 5. Aksi Admin Resolusi Transaksi (Verifikasi, Refund, Cairkan)
        Route::post('/transaksi/{id}/verifikasi', [AdminController::class, 'verifikasiPembayaran'])->name('admin.transaksi.verifikasi');
        Route::post('/transaksi/{id}/refund', [AdminController::class, 'refundKePembeli'])->name('admin.transaksi.refund');
        Route::post('/transaksi/{id}/cairkan', [AdminController::class, 'cairkanKePetani'])->name('admin.transaksi.cairkan');
    
        // 6. PUSAT RESOLUSI & LAPORAN
        Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
        
        // 7. Aksi Tombol di dalam Halaman Laporan
        Route::post('/lupa-sandi/proses/{id}', [LaporanController::class, 'prosesLupaSandi'])->name('admin.lupasandi.proses');
        Route::post('/komplain-barang/update/{id}', [LaporanController::class, 'updateStatusKomplain'])->name('admin.komplain.update');
        Route::post('/komplain-barang/tindak/{id}', [LaporanController::class, 'tindakTegasKomplain'])->name('admin.komplain.tindak');
    });
});