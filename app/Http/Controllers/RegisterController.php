<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister() {
        return view('pembeli/register'); // Boleh tetap di view ini
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'username'    => 'required|unique:users,username',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:8|confirmed',
            'role'        => 'required|in:petani,pembeli',
            'NamaLengkap' => 'required|string|max:255',
            'NoWhatsApp'       => 'required|string|max:20',
            'Alamat'      => 'required|string'
        ]);

        // 1. Simpan Data Autentikasi ke tabel `users`
        $user = User::create([
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role']
        ]);

        // 2. Simpan Data Biodata ke tabel `profiles` (Tanpa if-else!)
        Profile::create([
            'user_id'     => $user->id,
            'NamaLengkap' => $validated['NamaLengkap'],
            'NoWhatsApp'  => $validated['NoWhatsApp'], // Sesuaikan nama ke kolom database
            'Alamat'      => $validated['Alamat'],
            // Kolom Bio dan FotoProfil tidak perlu ditulis jika default-nya kosong (nullable)
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }
}