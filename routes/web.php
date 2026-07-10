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

// Import Controller Admin (Sistem Pengawas / Escrow)
use App\Http\Controllers\AdminController;

// =========================================================================
// HALAMAN PUBLIK (Akses tanpa login)
// =========================================================================

Route::get('/', function () {
    return view('Pembeli.beranda');
})->name('beranda');

// Autentikasi (Login & Register)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);


// =========================================================================
// HALAMAN PRIVATE (Wajib Login)
// =========================================================================
Route::middleware(['auth'])->group(function () {
    
    // Logout (Berlaku untuk Pembeli, Petani, dan Admin)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // =====================================================================
    // AREA PEMBELI
    // =====================================================================
    
    // 1. Dashboard Pembeli
    Route::get('/dashboard-pembeli', [PembeliPermintaanController::class, 'dashboard'])->name('pembeli');
    
    // 2. Permintaan Pasar (Oleh Pembeli)
    Route::get('/permintaan', [PembeliPermintaanController::class, 'index'])->name('permintaan.index');
    Route::post('/permintaan/store', [PembeliPermintaanController::class, 'store'])->name('permintaan.store');

    // 3. Penawaran Masuk (Dari Petani ke Pembeli)
    Route::get('/permintaan/{id}/penawaran', [PembeliPermintaanController::class, 'lihatPenawaran'])->name('permintaan.penawaran');
    Route::patch('/pembeli/penawaran/{id}/update-status', [PembeliPermintaanController::class, 'updateStatusPenawaran'])->name('pembeli.penawaran.update-status');

    // 4. Profil Pembeli
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::post('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');

    // 5. Transaksi & Pembayaran
    Route::get('/pembayaran/{idTawar}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/upload/{id}', [PembayaranController::class, 'uploadBukti'])->name('pembayaran.upload');

    // 6. Riwayat Transaksi & Ulasan Pembeli
    Route::get('/riwayat-transaksi', [PembayaranController::class, 'riwayatTransaksi'])->name('pembeli.riwayat');
    Route::get('/riwayat-transaksi/{id}/detail', [PembayaranController::class, 'detailTransaksi'])->name('detail');
    Route::post('/riwayat-transaksi/{id}/selesai', [PembayaranController::class, 'pesananSelesai'])->name('pembeli.pesanan.selesai');
    Route::post('/riwayat-transaksi/{id}/ulasan', [App\Http\Controllers\PembayaranController::class, 'simpanUlasan'])->name('pembeli.ulasan');

    // =====================================================================
    // AREA PETANI
    // =====================================================================
    Route::prefix('dashboard-petani')->group(function () {
        
        // 1. Dashboard & Notifikasi Petani
        Route::get('/', [DashboardController::class, 'index'])->name('petani.dashboard');
        Route::view('/notifikasi', 'Petani.dashboard')->name('petani.notifikasi');

        // 2. Profil Petani
        Route::get('/profil', [PetaniProfileController::class, 'index'])->name('petani.profil');
        Route::post('/profil/update', [PetaniProfileController::class, 'update'])->name('petani.profil.update');
        Route::post('/profil/rekening', [PetaniProfileController::class, 'updateRekening'])->name('petani.profil.rekening');
        Route::get('/profil/ulasan', [App\Http\Controllers\Petani\PetaniProfileController::class, 'ulasan'])->name('petani.ulasan');
        Route::get('/profil/edit', [App\Http\Controllers\Petani\PetaniProfileController::class, 'edit'])->name('petani.profil.edit');
        Route::post('/profil/password', [App\Http\Controllers\Petani\PetaniProfileController::class, 'updatePassword'])->name('petani.password.update');

        // 3. Permintaan Pasar (Melihat Permintaan Pembeli)
        Route::get('/permintaan', [PetaniPermintaanController::class, 'index'])->name('petani.permintaan.index');
        Route::get('/pasar', [PetaniPermintaanController::class, 'index'])->name('pasar.index');

        // 4. Penawaran (Mengajukan Harga ke Pembeli)
        Route::prefix('penawaran')->group(function () {
            Route::get('/', [TawarController::class, 'index'])->name('tawar.index');
            Route::get('/tawar', [TawarController::class, 'create'])->name('tawar.create');
            Route::post('/tawar', [TawarController::class, 'store'])->name('tawar.store');
            Route::delete('/{id}', [TawarController::class, 'destroy'])->name('tawar.destroy');
        });

        // 5. Manajemen Pesanan Masuk (Memproses Pesanan Pembeli)
        Route::get('/pesanan-masuk', [PesananPetaniController::class, 'index'])->name('petani.pesanan');
        Route::get('/pesanan-masuk/{id}/detail', [PesananPetaniController::class, 'detailPesanan'])->name('petani.pesanan.detail');
        Route::post('/pesanan-masuk/{id}/terima', [PesananPetaniController::class, 'terimaPembayaran'])->name('petani.pesanan.terima');
        Route::post('/pesanan-masuk/{id}/kirim', [PesananPetaniController::class, 'kirimBarang'])->name('petani.pesanan.kirim');

        // 6. Pengiriman Petani
        Route::get('/pengiriman/detail/{id}', function ($id) {
            return 'Detail Pengiriman ' . $id;
        })->name('pengiriman.detail');
    });

    // =====================================================================
    // AREA ADMIN (Pihak Ketiga / Pengawas Marketplace / Sistem Escrow)
    // =====================================================================
    Route::prefix('admin-dashboard')->group(function () {
        
        // 1. Halaman Utama Dashboard Admin
        // PERBAIKAN: Namanya sudah diubah menjadi 'admin.index'
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        
        // 2. Halaman Data Pengguna
        // PERBAIKAN: URL dirapikan menjadi '/pengguna' (tanpa '/admin' berulang)
        Route::get('/pengguna', [AdminController::class, 'pengguna'])->name('admin.pengguna');

        // 3. Halaman Detail Pengguna
        Route::get('/pengguna/{id}/detail', [AdminController::class, 'detailPengguna'])->name('admin.pengguna.detail');

        // 4. Halaman Konfirmasi Pembayaran
        Route::get('/konfirmasi', [AdminController::class, 'konfirmasi'])->name('admin.konfirmasi');

        // 5. Aksi Admin Verifikasi Pembayaran Manual Pembeli
        Route::post('/transaksi/{id}/verifikasi', [AdminController::class, 'verifikasiPembayaran'])->name('admin.transaksi.verifikasi');
        
        // 6. Aksi Refund Dana Kembali ke Pembeli
        Route::post('/transaksi/{id}/refund', [AdminController::class, 'refundKePembeli'])->name('admin.transaksi.refund');
        
        // 7. Aksi Paksa Cairkan Dana ke Petani
        Route::post('/transaksi/{id}/cairkan', [AdminController::class, 'cairkanKePetani'])->name('admin.transaksi.cairkan');
    });

});