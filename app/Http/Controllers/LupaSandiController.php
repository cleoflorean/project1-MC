<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LupaSandi;

class LupaSandiController extends Controller
{
    // POV: Guest - Menampilkan form lupa sandi
    public function showLupaSandi()
    {
        return view('Pembeli.lupa-sandi');
    }

    // POV: Guest - Memproses form lupa sandi
    public function storeLupaSandi(Request $request)
    {
        $request->validate([
            'username_atau_email' => 'required|string',
        ]);

        $user = User::where('email', $request->username_atau_email)
                    ->orWhere('username', $request->username_atau_email)->first();

        if (!$user) {
            return back()->with('error', 'Akun tidak ditemukan. Periksa kembali data Anda.')->withInput();
        }

        // Ambil No WA otomatis dari profil database
        $noWa = null;
        if ($user->role === 'pembeli') {
            $noWa = $user->pembeliProfile ? $user->pembeliProfile->NoTlp : null;
        } elseif ($user->role === 'petani') {
            $noWa = $user->petaniProfile ? $user->petaniProfile->NoTlp : null;
        }

        if (!$noWa) {
            return back()->with('error', 'Akun ditemukan, silakan hubungi Admin langsung karena Anda belum mengatur nomor telepon di profil.');
        }

        LupaSandi::create([
            'user_id' => $user->id,
            'no_whatsapp' => $noWa,
            'status' => 'Menunggu'
        ]);

        return back()->with('success', 'Permintaan terkirim! Admin akan mengirimkan password baru ke nomor WhatsApp terdaftar Anda.');
    }
}