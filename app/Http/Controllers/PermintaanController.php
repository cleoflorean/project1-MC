<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permintaan;
use App\Models\Penawaran;

class PermintaanController extends Controller
{
    // Dashboard Pembeli (Untuk nampilin tawaran petani)
    public function dashboard(Request $request)
    {
        $idPermintaans = $request->user()->permintaans()->pluck('idPermintaan');
        $penawarans = Penawaran::whereIn('idMinta', $idPermintaans)->latest()->get();

        return view('Pembeli/pembeli', compact('penawarans'));
    }

    // Permintaan Saya
    public function index(Request $request)
    {
        // Ambil data yang bener dari database
        $permintaans = $request->user()->permintaans()->latest()->get(); 
        return view('Pembeli/permintaan', compact('permintaans'));
    }

    // Simpan Data
    public function store(Request $request)
    {
        $request->validate([
            'NamaTanaman'   => 'required|string',
            'komoditas'     => 'required|string',
            'volume'        => 'required|numeric',
            'batas_harga'   => 'required|numeric',
            'batas_akhir'   => 'required|date',
        ]);

        $request->user()->permintaans()->create([
            'NamaTanaman'      => $request->NamaTanaman,
            'Komoditas'        => $request->komoditas,
            'JumlahDibutuhkan' => $request->volume,
            'HargaMaksimal'    => $request->batas_harga,
            'BatasTanggal'     => $request->batas_akhir,
            'Status'           => 'Aktif',
        ]);

        return redirect()->back()->with('success', 'Permintaan berhasil disimpan!');
    }
}