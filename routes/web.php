<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Petani\DashboardController;
use App\Http\Controllers\Petani\TawarController;
use App\Http\Controllers\Petani\PanenController;
use App\Http\controllers\Petani\PermintaanController;

// Dashboard petani
Route::get('/', [DashboardController::class, 'index']);

// Route dummy
// Pengiriman
Route::get('/pengiriman/detail/{id}', function ($id) {
    return 'Detail Pengiriman ' . $id;
})->name('pengiriman.detail');

// Profil
Route::view('/profil', 'petani.dashboard')
    ->name('profil.index');

// Notifikasi
Route::view('/notifikasi', 'petani.dashboard')
    ->name('notifikasi.index');

Route::prefix('penawaran')->group(function () {
    // tawar form
    Route::get('/tawar', [TawarController::class, 'create'])->name('tawar.create');
    
    //simpan data penawaran
    Route::post('/tawar', [TawarController::class, 'store'])->name('tawar.store');
    
    
    Route::get('/', [TawarController::class, 'index'])->name('tawar.index');
});

Route::get('/permintaan', [PermintaanController::class, 'index'])->name('permintaan.index');