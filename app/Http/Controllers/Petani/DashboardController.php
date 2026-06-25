<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permintaan;
use App\Models\Penawaran;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil ID Petani yang sedang login
        $petaniId = auth()->id();

        // 2. Hitung statistik untuk kartu-kartu di Dashboard
        $totalPenawaran = Penawaran::where('user_id', $petaniId)->count();
        $dalamPengiriman = Penawaran::where('user_id', $petaniId)->where('Status', 'Dikirim')->count();

        $dashboard = [
            'pengajuan_tawar'  => $totalPenawaran,
            'dalam_pengiriman' => $dalamPengiriman,
            'menuju_panen'     => '-', // Dikosongkan karena tidak memakai data panen
        ];

        // 3. Ambil data Permintaan Pasar (Daftar pembeli yang butuh komoditas)
        // Mengambil 5 permintaan terbaru yang masih Aktif
        $permintaanTerdekat = Permintaan::with('user.pembeliProfile')
                                        ->where('Status', 'Aktif')
                                        ->latest()
                                        ->take(5)
                                        ->get();

        // 4. Riwayat Penawaran Petani (Tawaran yang sudah diajukan petani ini)
        // Mengambil 5 penawaran terbaru milik petani yang sedang login
        $pengajuanTawar = Penawaran::with('permintaan.user.pembeliProfile')
                                   ->where('user_id', $petaniId)
                                   ->latest()
                                   ->take(5)
                                   ->get();

        // 5. Kirim semua data asli ke halaman view (petani.dashboard)
        return view('petani.dashboard', compact(
            'dashboard',
            'permintaanTerdekat',
            'pengajuanTawar'
        ));
    }
}