<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PetaniProfile;
use App\Models\PembeliProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister() {
        return view('pembeli/register');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'username'    => 'required|unique:users,username',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:8|confirmed',
            'role'        => 'required|in:petani,pembeli',
            'NamaLengkap' => 'required|string|max:255',
            'NoTlp'       => 'required|string|max:20',
            'Alamat'      => 'required|string'
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role']
        ]);

        // Data yang diisi saat register (Sama untuk Petani & Pembeli)
        $profileData = [
            'user_id'     => $user->id,
            'NamaLengkap' => $validated['NamaLengkap'],
            'NoTlp'       => $validated['NoTlp'],
            'Alamat'      => $validated['Alamat'],
            'Bio'         => null, 
            'FotoProfile' => null  
        ];

        if ($user->role === 'petani') {
            PetaniProfile::create($profileData);
        } else {
            PembeliProfile::create($profileData);
        }

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }
}