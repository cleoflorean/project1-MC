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
    ]);
    // Ambil email & password saja untuk proses Auth::attempt
    $loginData = $request->only('email', 'password');
    
    // --- KODE DETEKTIF SEMENTARA ---
    // Kita cari user berdasarkan email yang Anda ketik saat login
    $userLama = \App\Models\User::where('email', $request->email)->first();
    
    // if ($userLama) {
    //     // dd() akan menghentikan aplikasi dan menampilkan panjang karakter & isi password di database
    //     dd([
    //         'Panjang Karakter Password di DB' => strlen($userLama->password),
    //         'Isi Password Terenkripsi' => $userLama->password
    //     ]);
    // }
    // // --------------- sampe sini

    // 2. Cek email dan password di database
    if (Auth::attempt($loginData)) {
        // 3. Amankan session jika login sukses
        $request->session()->regenerate();
        // 4. Pengalihan halaman otomatis berdasarkan role yang tercatat di database
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