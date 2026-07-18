<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Penawaran;
use Illuminate\Http\Request;

class TawarController extends Controller
{
    // 1. Menampilkan Halaman Form Tawar (Menangkap parameter dari URL Pasar)
    public function create(Request $request)
    {
        // Sesuaikan query dengan parameter URL dari halaman pasar (nama_tanaman & kategori)
        $idMinta     = $request->query('idMinta');
        $namaTanaman = $request->query('NamaTanaman');
        $kategori    = $request->query('Kategori'); // Menggunakan istilah kategori sesuai form baru

        // Kembalikan ke view petani.form_tawar (Pastikan folder & nama file view sudah sesuai)
        return view('petani.form_tawar', compact('namaTanaman', 'idMinta', 'kategori'));
    }

    // 2. Memproses Data Saat Tombol "Kirim Penawaran" Diklik
    public function store(Request $request) {
    // 1. Validasi input yang dikirim dari form
    $request->validate([
        'idMinta'     => 'required',
        'JumlahTawar' => 'required|numeric',
        'HargaTawar'  => 'required|numeric',
        'Catatan'     => 'nullable|string',
        'Gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // 2. Buat objek penawaran baru
    $penawaran = new Penawaran();
    $penawaran->idMinta     = $request->idMinta;
    $penawaran->idPetani    = auth()->id();
    $penawaran->JumlahTawar = $request->JumlahTawar;
    $penawaran->HargaTawar  = $request->HargaTawar;
    $penawaran->Catatan     = $request->Catatan;
    $penawaran->Status      = 'Pending';

    // === HAPUS ATAU JANGAN SIMPAN BARIS DI BAWAH INI ===
    // $penawaran->NamaTanaman = $request->NamaTanaman; <-- INI YANG BIKIN ERROR
    // $penawaran->Komoditas   = $request->Komoditas;   <-- INI JUGA HAPUS AGAR AMAN
    // ===================================================

    // 3. Logika Upload Gambar (Kodememu yang sudah ada)
    if ($request->hasFile('Gambar')) {
        $file = $request->file('Gambar');
        $namaGambar = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/penawaran'), $namaGambar);
        
        $penawaran->Gambar = 'uploads/penawaran/' . $namaGambar;
    }

    // 4. Simpan ke database
    $penawaran->save();

    return redirect()->route('tawar.index')->with('success', 'Penawaran panen berhasil dikirim!');
}
    public function index() {
        // Menggunakan where agar hanya mengambil data milik petani yang sedang login
        $pengajuanTawar = Penawaran::with('permintaan.user.profile')
                        ->where('idPetani', auth()->id())
                        ->get();
        
        return view('petani.tawar', compact('pengajuanTawar'));
    }

    public function destroy($id)
    {
        $penawaran = Penawaran::findOrFail($id);
        $penawaran->delete();

        return redirect()->route('tawar.index')->with('success', 'Penawaran berhasil dihapus!');
    }
}