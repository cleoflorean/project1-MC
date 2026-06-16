<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('Pembeli/login');
    }

    public function authenticate(Request $request)
{
    // 1. Validasi input dari form login
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
        'role' => ['required', 'in:pembeli,petani'],
    ]);

    // Ambil email & password saja untuk proses Auth::attempt
    $loginData = $request->only('email', 'password');

    // 2. Cek email dan password di database
    if (Auth::attempt($loginData)) {
        
        // 3. JIKA password benar, cek apakah ROLE sesuai dengan yang dipilih di form
        if (Auth::user()->role !== $request->role) {
            Auth::logout(); // Paksa logout jika role tidak cocok
            return back()->withErrors([
                'email' => 'Role yang Anda pilih salah untuk akun ini.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        // 4. Pengalihan halaman berdasarkan role jika sukses
        if (Auth::user()->role === 'petani') {
            return redirect()->intended('/dashboard-petani');
        }

        return redirect()->intended('/dashboard-pembeli'); // Mengarah ke rute pembeli
    }

    // Jika email atau password salah
    return back()->withErrors([
        'email' => 'Kredensial tidak sesuai dengan data kami.',
    ])->onlyInput('email');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}