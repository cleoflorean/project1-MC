<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permintaan;

class PermintaanController extends Controller
{
    // 1. Menyimpan data dari form dashboard ke database
    public function store(Request $request)
    {
        $request->validate([
            'komoditas' => 'required',
            'volume' => 'required|numeric',
            'batas_harga' => 'required|numeric',
            'batas_akhir' => 'required|date',
        ]);

        // PERUBAHAN: Menggunakan relasi agar user_id otomatis terisi
        $request->user()->permintaans()->create([
            'komoditas' => $request->komoditas,
            'volume' => $request->volume,
            'batas_harga' => $request->batas_harga,
            'batas_akhir' => $request->batas_akhir,
        ]);

        return redirect()->back()->with('success', 'Permintaan pengadaan berhasil disimpan!');
    }

    // 2. Menampilkan semua data di halaman "Permintaan Saya"
    public function index(Request $request)
    {
        // PERUBAHAN: Hanya memanggil data milik user yang sedang login
        $permintaans = $request->user()->permintaans()->latest()->get(); 
        
        return view('Pembeli/permintaan', compact('permintaans'));
    }

    // 3. Menampilkan detail item saat baris tabel di-klik
    public function show(Request $request, $id)
    {
        // PERUBAHAN: Mencari data ID, tapi dikunci hanya di dalam data milik user tersebut
        // Jika user mencoba membuka ID milik orang lain, Laravel akan otomatis menampilkan error 404 (Not Found)
        $permintaan = $request->user()->permintaans()->findOrFail($id);
        
        return view('permintaan.show', compact('permintaan'));
    }
}