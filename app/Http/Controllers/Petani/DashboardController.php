<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permintaan;
use App\Models\Penawaran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil ID Petani yang sedang login
        $petaniId = auth()->id();

        // 2. Hitung statistik untuk kartu-kartu di Dashboard
        $totalPenawaran = Penawaran::where('idPetani', $petaniId)->count();
        $dalamPengiriman = Penawaran::where('idPetani', $petaniId)->where('Status', 'Dikirim')->count();

        $dashboard = [
            'pengajuan_tawar'  => $totalPenawaran,
            'dalam_pengiriman' => $dalamPengiriman,
            'menuju_panen'     => '-', 
        ];

        // 3. Ambil data Permintaan Pasar Terbaru (Hanya yang Aktif & Belum Kadaluarsa)
        $permintaanTerdekat = Permintaan::with('user.pembeliProfile')
                                        ->where('Status', 'Aktif')
                                        ->whereDate('BatasTanggal', '>=', Carbon::now()->toDateString())
                                        ->latest()
                                        ->take(5)
                                        ->get();

        // 4. Riwayat Penawaran Petani (Tawaran yang sudah diajukan petani ini)
        $pengajuanTawar = Penawaran::with('permintaan.user.pembeliProfile')
                                   ->where('idPetani', $petaniId)
                                   ->latest()
                                   ->take(5)
                                   ->get();

        return view('petani.dashboard', compact(
            'dashboard',
            'permintaanTerdekat',
            'pengajuanTawar'
        ));
    }
}