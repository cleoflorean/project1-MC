<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permintaan;
use App\Models\Penawaran;

class PermintaanController extends Controller
{
    /**
     * Dashboard Pembeli (Untuk menampilkan 5 tawaran terbaru dari petani)
     */
    public function dashboard(Request $request)
    {
        // Ambil semua ID permintaan milik pembeli ini
        $idPermintaans = $request->user()->permintaans()->pluck('idPermintaan');
        
        $penawarans = Penawaran::with(['petani', 'permintaan']) // Hapus .petaniProfile-nya sementara
            ->whereIn('idMinta', $idPermintaans)
            ->latest()
            ->take(5)
            ->get(); // Sumpah, ini pasti gak bakal error lagi!

        return view('Pembeli.pembeli', compact('penawarans'));
    }

    /**
     * Menampilkan daftar semua permintaan milik pembeli
     */
    public function index(Request $request)
    {
        $permintaans = $request->user()->permintaans()->latest()->get(); 
        return view('Pembeli.permintaan', compact('permintaans')); 
    }

    /**
     * Simpan Data Permintaan Baru
     */
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

    // =================================================================
    // FITUR: MELIHAT PENAWARAN MASUK & MENGUBAH STATUS
    // =================================================================

    /**
     * Menampilkan halaman daftar penawaran masuk dari sebuah permintaan
     */
    public function lihatPenawaran(Request $request, $idMinta) 
    {
        // Ambil data permintaan, pastikan ini milik user yang sedang login
        $permintaan = Permintaan::where('idPermintaan', $idMinta)
            ->where('user_id', $request->user()->id) 
            ->firstOrFail();

        // Ambil semua penawaran yang masuk untuk permintaan ini
        $penawarans = Penawaran::where('idMinta', $idMinta)->get();

        return view('Pembeli.penawaran_list', compact('permintaan', 'penawarans'));
    }

    /**
     * Mengubah status setuju/tolak pada penawaran
     */
    public function updateStatusPenawaran(Request $request, $idTawar) 
    {
        $request->validate([
            'status' => 'required|in:Setuju,Tidak Setuju'
        ]);

        $penawaran = Penawaran::findOrFail($idTawar);
        $penawaran->Status = $request->status;
        $penawaran->save();

        // Logika cerdas: Jika satu penawaran disetujui, tolak penawaran lainnya
        if ($request->status === 'Setuju') {
            Permintaan::where('idPermintaan', $penawaran->idMinta)->update(['Status' => 'Selesai']);
            
            Penawaran::where('idMinta', $penawaran->idMinta)
                ->where('idTawar', '!=', $idTawar)
                ->update(['Status' => 'Tidak Setuju']);
        }

        return back()->with('success', 'Status penawaran berhasil diubah.');
    }
}