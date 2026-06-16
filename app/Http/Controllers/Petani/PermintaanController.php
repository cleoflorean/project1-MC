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

        $permintaan = collect([
        (object)[
            'idPermintaan' => 1,
            'NamaPembeli' => 'PT Segar Alam Nusantara',
            'LokasiPembeli' => 'Bandung, Jawa Barat',
            'NamaTanaman' => 'Tomat Beef',
            'JumlahDibutuhkan' => 500,
            'HargaMaksimal' => 15000,
            'BatasTanggal' => '2026-07-15',
            'Status' => 'Mendesak',
        ],
        (object)[
            'idPermintaan' => 2,
            'NamaPembeli' => 'Koperasi Tani Makmur',
            'LokasiPembeli' => 'Cianjur, Jawa Barat',
            'NamaTanaman' => 'Cabai Rawit Merah',
            'JumlahDibutuhkan' => 1200,
            'HargaMaksimal' => 45000,
            'BatasTanggal' => '2026-06-30',
            'Status' => 'Rutin',
        ]
    ]);

    if ($search) {
        $permintaan = $permintaan->filter(function ($item) use ($search) {
            return false !== stripos($item->NamaTanaman, $search) || 
                   false !== stripos($item->NamaPembeli, $search);
        });
    }

        $query = Permintaan::where('Status', 'Aktif');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('NamaTanaman', 'Like', '%' . $search . '%')
                    ->orWhere('NamaPembeli', 'Like', '%' . $search . '%');
            });
        }

        $permintaan = $permintaan->merge($query->get());

        $komoditas = Panen::where('Komoditas')->get();

        return view('petani.permintaan', compact('permintaan', 'search', 'komoditas'));
    }
}
