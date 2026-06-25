<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Permintaan;
use Illuminate\Http\Request;

class PermintaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Ambil data permintaan, SEKALIGUS bawa data relasi user dan pembeliProfile (Eager Loading)
        $query = Permintaan::with('user.pembeliProfile')->where('Status', 'Aktif');

        // Perbaikan fitur pencarian agar mencari ke dalam tabel relasi
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('NamaTanaman', 'Like', '%' . $search . '%')
                  ->orWhereHas('user', function ($qUser) use ($search) {
                      $qUser->where('username', 'Like', '%' . $search . '%')
                            ->orWhereHas('pembeliProfile', function ($qProfile) use ($search) {
                                $qProfile->where('nama_toko', 'Like', '%' . $search . '%')
                                         ->orWhere('alamat', 'Like', '%' . $search . '%');
                            });
                  });
            });
        }

        $permintaan = $query->get();

        // PERBAIKAN: Ambil daftar komoditas unik dari tabel Permintaan (karena tabel Panen sudah dihapus)
        $komoditas = Permintaan::where('Status', 'Aktif')->pluck('Komoditas')->unique()->filter();

        return view('petani.permintaan', compact('permintaan', 'search', 'komoditas'));
    }
}