<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PanenController extends Controller
{
    public function index()
    {
        $panen = collect([
            (object)[
                'idPanen' => 1,
                'NamaTanaman' => 'Bayam',
                'Komoditas' => 'Sayur',
                'JumlahPanen' => 50,
                'HargaPerKg' => 5000,
                'TglPanen' => '2024-05-10',
                'LokasiPanen' => 'Desa Sukamaju',
                'Status' => 'Siap Dijual',
                'Deskripsi' => 'Bayam segar hasil panen haru ini',
                'Gambar' => 'images/bayam.jpg'
            ],

            (object)[
                'idPanen' => 2,
                'NamaTanaman' => 'Bawang Bombay',
                'Komoditas' => 'Bumbu',
                'JumlahPanen' => 60,
                'HargaPerKg' => 12.000,
                'TglPanen' => '2024-05-12',
                'LokasiPanen' => 'Desa Sukamaju',
                'Status' => 'Siap Dijual',
                'Deskripsi' => 'Bawang bombay segar dari kabun',
                'Gambar' => 'images/bawangbombay.jpg',
            ],
        ]);

        return view('petani.panen', compact('panen'));
    }
}
