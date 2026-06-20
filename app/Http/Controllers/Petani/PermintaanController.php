<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Permintaan;
use App\Models\Panen;
use Illuminate\Http\Request;

class PermintaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Ambil data dari database
        $query = Permintaan::where('Status', 'Aktif');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('NamaTanaman', 'Like', '%' . $search . '%')
                  ->orWhere('NamaPembeli', 'Like', '%' . $search . '%');
            });
        }

        $permintaan = $query->get();

        // Ambil daftar komoditas dari tabel panen
        $komoditas = Panen::pluck('Komoditas')->unique()->filter();

        return view('petani.permintaan', compact('permintaan', 'search', 'komoditas'));
    }
}