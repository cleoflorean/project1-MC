<?php

namespace App\Http\Controllers;

use App\Models\Kurir;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showKurir()
    {
        return view('kurir.register');
    }

    public function showRegister()
    {
        return view('pembeli.register');
    }

    public function store(Request $request)
    {
        $isKurir = $request->input('role') === 'kurir';

        $rules = [
            'username'    => 'required|string|max:255|unique:users,username',
            'email'       => 'required|email|max:255|unique:users,email',
            'password'    => 'required|string|min:8|confirmed',
            'role'        => 'required|in:petani,pembeli,kurir',
            'NamaLengkap' => 'required|string|max:255',
            'NoWhatsApp'  => 'required|string|max:20',
            'Alamat'      => 'required|string',
        ];

        if ($isKurir) {
            $rules = array_merge($rules, [
                'foto_sim'        => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'foto_ktp'        => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'foto_skck'       => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'NIK'             => 'required|string|max:20',
                'jenis_kelamin'   => 'required|in:L,P',
                'tanggal_lahir'   => 'required|date',
                'jenis_kendaraan' => 'required|string|max:50',
            ]);
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($request, $validated, $isKurir) {
            // 1. Simpan data autentikasi ke tabel users
            $user = User::create([
                'username' => $validated['username'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => $validated['role'],
            ]);

            // 2. Simpan biodata ke tabel sesuai role
            $biodata = [
                'user_id'     => $user->id,
                'NamaLengkap' => $validated['NamaLengkap'],
                'NoWhatsApp'  => $validated['NoWhatsApp'],
                'Alamat'      => $validated['Alamat'],
            ];

            if ($isKurir) {
                $kurirData = array_merge($biodata, [
                    'foto_sim'        => $request->file('foto_sim')->store('kurir_docs', 'public'),
                    'foto_ktp'        => $request->file('foto_ktp')->store('kurir_docs', 'public'),
                    'foto_skck'       => $request->file('foto_skck')->store('kurir_docs', 'public'),
                    'NIK'             => $validated['NIK'],
                    'jenis_kelamin'   => $validated['jenis_kelamin'],
                    'tanggal_lahir'   => $validated['tanggal_lahir'],
                    'jenis_kendaraan' => $validated['jenis_kendaraan'],
                ]);

                Kurir::create($kurirData);
            } else {
                Profile::create($biodata);
            }
        });

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }
}