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

// ==========================================
// HALAMAN PUBLIK (Akses tanpa login)
// ==========================================

Route::get('/', function () {
    return view('Pembeli/beranda'); // Diperbaiki menjadi 'Pembeli' (P Kapital)
})->name('beranda');

// Autentikasi Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

// Rute Register
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// ==========================================
// HALAMAN PRIVATE (Wajib Login)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --------------------------------------
    // Area Pembeli
    // --------------------------------------
    Route::get('/dashboard-pembeli', function () {
        return view('Pembeli/pembeli'); // Diperbaiki mengarah ke folder Pembeli/pembeli.blade.php
    })->name('pembeli');

    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

    // Fitur Permintaan (Pembeli)
    Route::get('/permintaan', [PembeliPermintaanController::class, 'index'])->name('permintaan.index');
    Route::post('/permintaan/store', [PembeliPermintaanController::class, 'store'])->name('permintaan.store');
    Route::get('/permintaan/{id}', [PembeliPermintaanController::class, 'show'])->name('permintaan.show');

    // --------------------------------------
    // Area Petani
    // --------------------------------------
    Route::prefix('dashboard-petani')->group(function () {
        
        // Halaman Utama Petani
        Route::get('/', [DashboardController::class, 'index'])->name('petani.dashboard');

        // Pengiriman
        Route::get('/pengiriman/detail/{id}', function ($id) {
            return 'Detail Pengiriman ' . $id;
        })->name('pengiriman.detail');

        // Profil & Notifikasi Petani
        Route::view('/profil', 'petani.dashboard')->name('petani.profil');
        Route::view('/notifikasi', 'petani.dashboard')->name('petani.notifikasi');

        // Fitur Penawaran Petani
        Route::prefix('penawaran')->group(function () {
            Route::get('/tawar', [TawarController::class, 'create'])->name('tawar.create');
            Route::post('/tawar', [TawarController::class, 'store'])->name('tawar.store');
            Route::get('/', [TawarController::class, 'index'])->name('tawar.index');
        });

        // Fitur Permintaan (Petani)
        Route::get('/permintaan', [PetaniPermintaanController::class, 'index'])->name('petani.permintaan.index');
    });

});