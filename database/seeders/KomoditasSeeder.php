<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KomoditasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $komoditas = [
            // Tanaman Pangan
            ['namatanaman' => 'Padi', 'komoditas' => 'Tanaman Pangan'],
            ['namatanaman' => 'Jagung', 'komoditas' => 'Tanaman Pangan'],
            ['namatanaman' => 'Kedelai', 'komoditas' => 'Tanaman Pangan'],
            ['namatanaman' => 'Kacang Tanah', 'komoditas' => 'Tanaman Pangan'],
            ['namatanaman' => 'Ubi Jalar', 'komoditas' => 'Tanaman Pangan'],
            ['namatanaman' => 'Singkong', 'komoditas' => 'Tanaman Pangan'],
            
            // Hortikultura
            ['namatanaman' => 'Cabai Rawit', 'komoditas' => 'Hortikultura'],
            ['namatanaman' => 'Cabai Merah', 'komoditas' => 'Hortikultura'],
            ['namatanaman' => 'Bawang Merah', 'komoditas' => 'Hortikultura'],
            ['namatanaman' => 'Bawang Putih', 'komoditas' => 'Hortikultura'],
            ['namatanaman' => 'Tomat', 'komoditas' => 'Hortikultura'],
            ['namatanaman' => 'Kentang', 'komoditas' => 'Hortikultura'],
            ['namatanaman' => 'Wortel', 'komoditas' => 'Hortikultura'],
            ['namatanaman' => 'Kubis', 'komoditas' => 'Hortikultura'],
            ['namatanaman' => 'Sawi', 'komoditas' => 'Hortikultura'],
            ['namatanaman' => 'Bayam', 'komoditas' => 'Hortikultura'],
            ['namatanaman' => 'Kangkung', 'komoditas' => 'Hortikultura'],
            ['namatanaman' => 'Jeruk', 'komoditas' => 'Hortikultura'],
            ['namatanaman' => 'Mangga', 'komoditas' => 'Hortikultura'],
            ['namatanaman' => 'Pisang', 'komoditas' => 'Hortikultura'],
            ['namatanaman' => 'Pepaya', 'komoditas' => 'Hortikultura'],
            ['namatanaman' => 'Semangka', 'komoditas' => 'Hortikultura'],
            ['namatanaman' => 'Melon', 'komoditas' => 'Hortikultura'],
            
            // Perkebunan
            ['namatanaman' => 'Kelapa Sawit', 'komoditas' => 'Perkebunan'],
            ['namatanaman' => 'Karet', 'komoditas' => 'Perkebunan'],
            ['namatanaman' => 'Kopi', 'komoditas' => 'Perkebunan'],
            ['namatanaman' => 'Kakao', 'komoditas' => 'Perkebunan'],
            ['namatanaman' => 'Tebu', 'komoditas' => 'Perkebunan'],
            ['namatanaman' => 'Teh', 'komoditas' => 'Perkebunan'],
            ['namatanaman' => 'Cengkeh', 'komoditas' => 'Perkebunan'],
            ['namatanaman' => 'Lada', 'komoditas' => 'Perkebunan'],
            ['namatanaman' => 'Pala', 'komoditas' => 'Perkebunan'],
            ['namatanaman' => 'Tembakau', 'komoditas' => 'Perkebunan'],
        ];

        foreach ($komoditas as $item) {
            DB::table('komoditas')->insert([
                'namatanaman' => $item['namatanaman'],
                'komoditas' => $item['komoditas'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
