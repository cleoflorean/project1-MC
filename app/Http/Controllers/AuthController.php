<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        return view('pembeli/login');
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Login sukses
        // Di dalam AuthController.php bagian authenticate()
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek role dari database, lalu arahkan menggunakan nama route yang benar
        if (Auth::user()->role === 'petani') {
            return redirect()->route('petani.dashboard');
        } elseif (Auth::user()->role === 'pembeli') {
            return redirect()->route('pembeli'); // Diarahkan ke dashboard pembeli, atau ganti 'beranda' jika ingin ke halaman landing awal
        }
    }

        return back()->withErrors(['email' => 'Email atau Password salah.']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}