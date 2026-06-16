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

        Permintaan::create($request->all());

        // Setelah sukses, kembali ke dashboard dengan pesan sukses
        return redirect()->back()->with('success', 'Permintaan pengadaan berhasil disimpan!');
    }

    // 2. Menampilkan semua data di halaman "Permintaan Saya"
    public function index()
    {
        $permintaans = Permintaan::latest()->get(); // Ambil dari yang terbaru
        return view('Pembeli/permintaan', compact('permintaans'));
    }

    // 3. Menampilkan detail item saat baris tabel di-klik
    public function show($id)
    {
        $permintaan = Permintaan::findOrFail($id);
        return view('permintaan.show', compact('permintaan'));
    }
}