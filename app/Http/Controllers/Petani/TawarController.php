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
        return view('Petani.form_tawar', compact('namaTanaman', 'idMinta', 'kategori'));
    }

    // 2. Memproses Data Saat Tombol "Kirim Penawaran" Diklik
    public function store(Request $request)
    {
        // Proses Validasi Data Inputan Petani
        $request->validate([
            'idMinta'     => 'required|integer',
            'NamaTanaman' => 'required|string',
            'Komoditas'   => 'required|string', // Menyesuaikan input name="Komoditas"
            'JumlahTawar' => 'required|integer|min:1',
            'HargaTawar'  => 'required|numeric|min:1',
            'Catatan'     => 'required|string',
            'Gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Typo pnhg & spasi diperbaiki
        ]);

        // Instansiasi Model Tawar untuk simpan ke database
        $penawaran = new Penawaran();
        $penawaran->idMinta     = $request->idMinta;
        $penawaran->NamaTanaman = $request->NamaTanaman; // Wajib disimpan jika di tabel tawar ada kolom ini
        $penawaran->Komoditas   = $request->Komoditas;    // Wajib disimpan jika di tabel tawar ada kolom ini
        $penawaran->JumlahTawar = $request->JumlahTawar;
        $penawaran->HargaTawar  = $request->HargaTawar;
        $penawaran->Catatan     = $request->Catatan;
        $penawaran->Status      = 'Pending'; // Otomatis diset pending di awal

        // Logika upload Gambar jika petani memasukkan foto
        if ($request->hasFile('Gambar')) {
            $file = $request->file('Gambar');
            $namaGambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/penawaran'), $namaGambar);
            
            $penawaran->Gambar = 'uploads/penawaran/' . $namaGambar;
        }

        $penawaran->save();

        // Alihkan halaman ke index penawaran (Atau sesuaikan ke rute halaman riwayat yang kamu inginkan)
        return redirect()->route('tawar.index')->with('success', 'Penawaran panen berhasil dikirim!');
    }

    public function index() {
        $pengajuanTawar = Penawaran::with('permintaan')->get();
        return view('Petani.tawar', compact('pengajuanTawar'));
    }

    public function destroy($id)
    {
        $penawaran = Penawaran::findOrFail($id);
        $penawaran->delete();

        return redirect()->route('tawar.index')->with('success', 'Penawaran berhasil dihapus!');
    }
}