<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;

class KurirSeeder extends Seeder
{
    public function run(): void
    {
        $kurir = User::firstOrCreate(
            ['email' => 'kurir@taniharvest.com'],
            [
                'username' => 'Kurir Express',
                'password' => Hash::make('12345678'),
                'role'     => 'kurir',
            ]
        );

        Profile::firstOrCreate(
            ['user_id' => $kurir->id],
            [
                'NamaLengkap' => 'Kurir Express Tani Harvest',
                'NoWhatsApp'  => '082123456789',
                'Alamat'      => 'Gudang Logistik Tani Harvest, Bandung',
                'Bio'         => 'Armada logistik internal resmi Tani Harvest (Mobil Pick-up D 8821 TH)',
            ]
        );
    }
}
