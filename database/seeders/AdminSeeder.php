<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
        AdminSeeder::class,
        ]);

        User::create([
            'username' => 'Admin Utama',
            'email' => 'adminbesar@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin', // Pastikan kolom role kamu bernama 'role'
        ]);
    }
}