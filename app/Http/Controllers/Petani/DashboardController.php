<?php

namespace App\Http\Controllers\Petani;
use App\Http\Controllers\Controller;
use App\Models\Panen;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data panen dari database
        $panen = Panen::all();

        // Dummy data
        $jumlahJenisPanen = 2;
        $permintaanBaru = 12;
        $dalamPengiriman = 2;

        //Pengajuan tawar
        $pengajuanTawar = collect([
            (object)[
                'komoditas' => 'Cabai',
                'harga_per_kg' => 32000,
                'status' => 'aktif',
                'pasar' => (object)[
                    'nama' => 'Pasar Induk'
                ],
                'Gambar' => 'images/cabai.jpg'
            ]
        ]);

        // // Pengriman
        // $panenDalamPengiriman = collect([
        //     (object)[
        //         'id' => 1,
        //         'status' => 'dikirim',
        //         //Relasi permintaan
        //         'permintaan' => (object)[
        //             'komoditas' => 'Tomat',
        //         //Relasi pasar
        //             'pasar' => (object)[
        //                 'nama' => 'Distributor Ciamis'
        //             ]
        //         ]
        //     ],

        //     (object)[
        //         'id' => 2,
        //         'status' => 'dalam_perjalanan',

        //         'permintaan' => (object)[
        //             'komoditas' => 'Cabai Merah',

        //             'pasar' => (object)[
        //                 'nama' => 'Pasar Induk Medan'
        //             ]
        //         ]
        //     ]

        // ]);

        $permintaanTerdekat = [
            (object)[
                'id' => 1,
                'komoditas' => 'Cabai Merah',
                'jumlah_butuh' => 200,
                'jarak_km' => 5,
                'harga_per_kg' => 12000,
                'harga_tawar' => 25000,
                'deadline' => '2026-05-22',
                'Gambar' => 'images/cabai.jpg',
            ],

            (object)[
                'id' => 2,
                'komoditas' => 'Tomat',
                'jumlah_butuh' => 150,
                'jarak_km' => 8,
                'harga_per_kg' => 8000,
                'harga_tawar' => 12000,
                'deadline' => '2026-06-16',
                'Gambar' => 'images/tomat.jpg',
            ]
        ];

        $dashboard = [
            'menuju_panen' => '5 Hari',
            'pengajuan_tawar' => 5,
            'dalam_pengiriman' => 2,
        ];

        return view('petani.dashboard', compact(
            'panen',
            'jumlahJenisPanen',
            'permintaanBaru',
            'dalamPengiriman',
            'pengajuanTawar',   
            // 'panenDalamPengiriman',
            'permintaanTerdekat',
            'dashboard'
            ));



        // Simulasi data dashboard
        // Nantinya data ini bisa diambil dari database

        // $dashboard = [
        //     'menuju_panen' => '5 Hari',
        //     'pengajuan_tawar' => 5,
        //     'dalam_pengiriman' => 2,
        //     'pendapatan_bulan' => 'Rp15.750.000',
        // ];

        // // Permintaan pasar sesuai komoditas petani
        // $permintaan = [
        //     [
        //         'komoditas' => 'Cabai Merah',
        //         'jumlah' => '2 Ton',
        //         'harga' => 'Rp32.000/kg',
        //         'lokasi' => 'Pasar Induk Medan',
        //         'jarak' => '12 km',
        //     ],
        //     [
        //         'komoditas' => 'Tomat',
        //         'jumlah' => '700 Kg',
        //         'harga' => 'Rp8.500/kg',
        //         'lokasi' => 'Distributor Binjai',
        //         'jarak' => '15 km',
        //     ]
        // ];

        // // Riwayat transaksi sederhana
        // $transaksi = [
        //     [
        //         'komoditas' => 'Cabai Merah',
        //         'jumlah' => '500 Kg',
        //         'total' => 'Rp15.750.000',
        //         'status' => 'Selesai'
        //     ],
        //     [
        //         'komoditas' => 'Kentang',
        //         'jumlah' => '1 Ton',
        //         'total' => 'Rp14.000.000',
        //         'status' => 'Proses'
        //     ]
        // ];

        // return view('petani.dashboard', compact(
        //     'dashboard',
        //     'permintaan',
        //     'transaksi'
        // ));
    }
}
