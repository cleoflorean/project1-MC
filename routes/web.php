<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RegisterController;

// Import Controller Pembeli
use App\Http\Controllers\PermintaanController as PembeliPermintaanController;

// Import Controller Petani
use App\Http\Controllers\Petani\DashboardController;
use App\Http\Controllers\Petani\TawarController;
use App\Http\Controllers\Petani\PanenController;
use App\Http\Controllers\Petani\PermintaanController as PetaniPermintaanController;
use App\Http\Controllers\Petani\PetaniProfileController;

// =========================================================================
// HALAMAN PUBLIK (Akses tanpa login)
// =========================================================================

Route::get('/', function () {
    return view('Pembeli.beranda');
})->name('beranda');

// Autentikasi Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

// Rute Register
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// =========================================================================
// HALAMAN PRIVATE (Wajib Login)
// =========================================================================
Route::middleware(['auth'])->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ---------------------------------------------------------------------
    // Area Pembeli
    // ---------------------------------------------------------------------
    // Dashboard Pembeli
    Route::get('/dashboard-pembeli', [PembeliPermintaanController::class, 'dashboard'])->name('pembeli');
    
    // Permintaan Pembeli
    Route::get('/permintaan', [PembeliPermintaanController::class, 'index'])->name('permintaan.index');
    Route::post('/permintaan/store', [PembeliPermintaanController::class, 'store'])->name('permintaan.store');

    // Penawaran Masuk ke Pembeli
    Route::get('/permintaan/{id}/penawaran', [PembeliPermintaanController::class, 'lihatPenawaran'])->name('permintaan.penawaran');
    Route::patch('/pembeli/penawaran/{id}/update-status', [PembeliPermintaanController::class, 'updateStatusPenawaran'])->name('pembeli.penawaran.update-status');

    // FITUR PROFIL PEMBELI (SUDAH DIPISAH TOTAL)
    // 1. Halaman khusus LIHAT data profil (Dipanggil oleh Navbar app22)
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

    // 2. Halaman HTML TERPISAH khusus memuat FORM EDIT profil 
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    
    // 3. Proses Aksi Simpan Perubahan Profil (Menggunakan PUT)
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
    
    // 4. Proses Ganti Password Pembeli
    Route::post('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');


    // ---------------------------------------------------------------------
    // Area Petani
    // ---------------------------------------------------------------------
    Route::prefix('dashboard-petani')->group(function () {
        
        // Halaman Utama Petani
        Route::get('/', [DashboardController::class, 'index'])->name('petani.dashboard');

        // Pengiriman Petani
        Route::get('/pengiriman/detail/{id}', function ($id) {
            return 'Detail Pengiriman ' . $id;
        })->name('pengiriman.detail');

        // Profil Petani
        Route::get('/profil', [PetaniProfileController::class, 'index'])->name('petani.profil');
        Route::post('/profil/update', [PetaniProfileController::class, 'update'])->name('petani.profil.update');
        
        // Notifikasi Petani
        Route::view('/notifikasi', 'Petani.dashboard')->name('petani.notifikasi');

        // Fitur Penawaran Petani
        Route::prefix('penawaran')->group(function () {
            Route::get('/tawar', [TawarController::class, 'create'])->name('tawar.create');
            Route::post('/tawar', [TawarController::class, 'store'])->name('tawar.store');
            Route::get('/', [TawarController::class, 'index'])->name('tawar.index');
            Route::delete('/{id}', [TawarController::class, 'destroy'])->name('tawar.destroy');
        });

        // Fitur Permintaan Pasar (Petani)
        Route::get('/permintaan', [PetaniPermintaanController::class, 'index'])->name('petani.permintaan.index');
        Route::get('/pasar', [PetaniPermintaanController::class, 'index'])->name('pasar.index');
    });

});