<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PembeliProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('Pembeli/register'); // Menampilkan view resources/views/Pembeli/register.blade.php
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Form (Termasuk konfirmasi password)
        $request->validate([
            'username'              => 'required|string|max:255|unique:users,username',
            'email'                 => 'required|string|email|max:255|unique:users,email',
            'password'              => 'required|string|min:6|confirmed', 
            'role'                  => 'required|in:pembeli,petani',
            'nama_toko'             => 'required|string|max:255',
            'alamat'                => 'required|string',
            'no_telepon'            => 'required|string|max:20',
        ]);

        // 2. Transaksi Database
        DB::beginTransaction();

        try {
            // Simpan akun ke tabel users
            $user = User::create([
                'username' => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => $request->role,
            ]);

            // Simpan detail ke tabel pembeli_profiles
            PembeliProfile::create([
                'user_id'    => $user->id,
                'nama_toko'  => $request->nama_toko,
                'alamat'     => $request->alamat,
                'no_telepon' => $request->no_telepon,
            ]);

            DB::commit();

            // 3. Otomatis login setelah daftar
            Auth::login($user);

            // 4. Pengalihan halaman sesuai role masing-masing
            if ($user->role === 'petani') {
                return redirect()->route('petani.dashboard')->with('success', 'Pendaftaran Berhasil!');
            }

            return redirect()->route('pembeli')->with('success', 'Pendaftaran Berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }
}