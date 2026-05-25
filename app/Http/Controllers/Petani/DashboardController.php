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
        $jumlahJenisPanen = 5;
        $permintaanBaru = 12;
        $dalamPengiriman = 3;
        $pendapatanBulanIni = 15750000;
        $persentaseKenaikan = 10;

        // Jangka panan
        $jangkaPanen = collect([
            (object)[
                'komoditas' => 'Cabai Merah',
                'lokasi' => 'Sari Jadi',
                'sisa_hari' => 5
            ],
            (object)[
                'komoditas' => 'Tomat',
                'lokasi' => 'Ciamis',
                'sisa_hari' => 5
            ],
        ]);

        //Pengajuan tawar
        $pengajuanTawar = collect([
            (object)[
                'komoditas'=> 'Cabai',
                'harga_per_kg' => 32000,
                'status' => 'aktif',
                'pasar' => (object)[
                    'nama' => 'Pasar Induk'
                ]           
            ]

        ]);

        // Pengriman
        $panenDalamPengiriman = collect([
            (object)[
                'id' => 1,
                'status' => 'dikirim',
                //Relasi permintaan
                'permintaan' => (object)[
                    'komoditas' => 'Tomat',
                //Relasi pasar
                    'pasar' => (object)[
                        'nama' => 'Distributor Ciamis'
                    ]
                ]
            ],

            (object)[
                'id' => 2,
                'status' => 'dalam_perjalanan',

                'permintaan' => (object)[
                    'komoditas' => 'Cabai Merah',

                    'pasar' => (object)[
                        'nama' => 'Pasar Induk Medan'
                    ]
                ]
            ]

        ]);

        //Pendapatan 7 hari
        $pendapatan7Hari = [
            ['tanggal' => 'Sen', 'jumalah' => 2000000],
            ['tanggal' => 'Sel', 'jumlah' => 1500000],
            ['tanggal' => 'Rab', 'jumlah' => 3000000],
            ['tanggal' => 'Kam', 'jumlah' => 2500000],
            ['tanggal' => 'Jum', 'jumlah' => 1800000],
            ['tanggal' => 'Sab', 'jumlah' => 2200000],
            ['tanggal' => 'Min', 'jumlah' => 2700000],
        ];

        //Riwayat transaksi
        $riwayatTransaksi = collect([
            (object)[
                'id' => 1,
                'komoditas' => 'Cabai Rawit',
                'jumlah_kg' => 500,
                'jarak_km' => 12,
                'deadline' => now(),
                'harga_per_kg' => 28000,
            ]
        ]);

        // Riwayat transaksi
        $riwayatTransaksi = collect([
            (object)[
                'total_harga' => 2500000,
                'status' => 'selesai',
                'created_at' => now(),
                'permintaan' => (object)[
                    'komoditas' => 'Cabai',
                    'pasar' => (object)[
                        'nama' => 'Pasar Induk'
                    ]
                ]
            ]
        ]);

        $permintaanTerdekat = [
            (object)[
                'id' => 1,
                'komoditas' => 'Cabai Merah',
                'jumlah_butuh' => 200,
                'jarak_km' => 5,
                'harga_per_kg' => 12000,
                'harga_tawar' => 25000,
                'deadline' => '2026-05-22'
            ],

            (object)[
                'id' => 2,
                'komoditas' => 'Tomat',
                'jumlah_butuh' => 150,
                'jarak_km' => 8,
                'harga_per_kg' => 8000,
                'harga_tawar' => 12000,
                'deadline' => '2026-06-16'
            ]
        ];

        $dashboard = [
            'menuju_panen' => '5 Hari',
            'pengajuan_tawar' => 5,
            'dalam_pengiriman' => 2,
            'pendapatan_bulan' => 'Rp15.750.000',
        ];

        return view('petani.dashboard', compact(
            'panen',
            'jumlahJenisPanen',
            'permintaanBaru',
            'dalamPengiriman',
            'pendapatanBulanIni',
            'persentaseKenaikan',
            'jangkaPanen',
            'pengajuanTawar',
            'panenDalamPengiriman',
            'pendapatan7Hari',
            'riwayatTransaksi',
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
