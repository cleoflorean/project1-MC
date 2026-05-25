<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Petani\DashboardController;
use App\Http\Controllers\Petani\TawarController;

// Dashboard petani
Route::get('/', [DashboardController::class, 'index']);

// Route dummy
// Panen
Route::view('/panen', 'petani.dashboard')
    ->name('panen.index');

// Pasar
Route::view('/pasar', 'petani.dashboard')
    ->name('pasar.index');
// Pengiriman
Route::get('/pengiriman/detail/{id}', function ($id) {
    return 'Detail Pengiriman ' . $id;
})->name('pengiriman.detail');

// Tawarkan Panen
Route::view('/tawar', 'petani.dashboard')
    ->name('tawar.index');

// Profil
Route::view('/profil', 'petani.dashboard')
    ->name('profil.index');

// Notifikasi
Route::view('/notifikasi', 'petani.dashboard')
    ->name('notifikasi.index');




Route::get('/tawar/{id}', function ($id) {
    return 'Halaman tawar ' . $id;
})->name('tawar.form');