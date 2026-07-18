<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Permintaan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PermintaanController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->toDateString();

        // 1. Ambil semua Permintaan Pasar yang MASIH AKTIF (Batas tanggal belum terlewat)
        $permintaanAktif = Permintaan::with('user.profile')
                                    ->where('Status', 'Aktif')
                                    ->whereDate('BatasTanggal', '>=', $today)
                                    ->orderBy('BatasTanggal', 'asc')
                                    ->get();

        // 2. Ambil semua Permintaan Pasar yang SUDAH KADALUARSA (Batas tanggal sudah lewat)
        $permintaanKadaluarsa = Permintaan::with('user.profile')
                                        ->where('Status', 'Aktif')
                                        ->whereDate('BatasTanggal', '<', $today)
                                        ->orderBy('BatasTanggal', 'desc')
                                        ->get();

        $komoditas = Permintaan::where('Status', 'Aktif')->pluck('Komoditas')->unique()->filter();

        // Kirim kedua tipe data ke satu halaman view yang sama
        return view('petani.permintaan', compact('permintaanAktif', 'permintaanKadaluarsa', 'komoditas'));
    }
}