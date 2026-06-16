<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PembeliProfile; // Pastikan model ini di-import

class ProfilController extends Controller
{
    /**
     * Menampilkan profil pembeli yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Mengambil data user yang saat ini sedang login
        $user = Auth::user();
        
        // 2. Menggunakan firstOrCreate untuk memastikan profil ada.
        // Jika profil untuk user_id ini belum ada di tabel pembeli_profiles,
        // Laravel akan otomatis membuatkan baris baru dengan nilai default.
        // Ini mencegah error 1364 (field 'nama_toko' doesn't have a default value).
        $profil = PembeliProfile::firstOrCreate(
            ['user_id' => $user->id], // Kriteria pencarian
            [
                'nama_toko'  => 'Belum diatur',
                'alamat'     => 'Belum diatur',
                'no_telepon' => 'Belum diatur'
            ]
        );

        // 3. Mengirim data user dan profil ke file view 'profilpembeli.blade.php'
        return view('Pembeli/profilpembeli', compact('user', 'profil'));
    }
}