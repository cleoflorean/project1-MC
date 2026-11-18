<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DropPoint;

class DropPointSeeder extends Seeder
{
    public function run(): void
    {
        $points = [
            [
                'nama_titik'        => 'Gudang Hub Utama Bandung',
                'alamat'            => 'Jl. Soekarno Hatta No. 450, Batununggal',
                'kota'              => 'Bandung',
                'penanggung_jawab'  => 'Asep Sunandar',
                'telepon'           => '081234567801',
            ],
            [
                'nama_titik'        => 'Drop Point Lembang (Sentra Hortikultura)',
                'alamat'            => 'Jl. Raya Lembang No. 128, Lembang',
                'kota'              => 'Bandung Barat',
                'penanggung_jawab'  => 'Dadang Kosasih',
                'telepon'           => '081234567802',
            ],
            [
                'nama_titik'        => 'Drop Point Soreang (Sentra Sayur & Padi)',
                'alamat'            => 'Jl. Raya Soreang - Banjaran No. 88',
                'kota'              => 'Kabupaten Bandung',
                'penanggung_jawab'  => 'Cecep Rustandi',
                'telepon'           => '081234567803',
            ],
            [
                'nama_titik'        => 'Drop Point Cimahi & Padalarang',
                'alamat'            => 'Jl. Amir Machmud No. 312',
                'kota'              => 'Cimahi',
                'penanggung_jawab'  => 'Budi Hartono',
                'telepon'           => '081234567804',
            ],
        ];

        foreach ($points as $item) {
            DropPoint::firstOrCreate(
                ['nama_titik' => $item['nama_titik']],
                $item
            );
        }
    }
}
