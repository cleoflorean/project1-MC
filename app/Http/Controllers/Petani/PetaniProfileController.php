<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\PetaniProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetaniProfileController extends Controller
{
    public function index()
    {
        // 1. Ambil data user yang sedang login
        $user = \Illuminate\Support\Facades\Auth::user();

        // 2. Ambil data profil
        $profil = \App\Models\PetaniProfile::where('idPetani', $user->id)->first();
        
        return view('petani.profilpetani', compact('profil', 'user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'NamaKebun'   => 'nullable|string|max:255',
            'Alamat'      => 'required|string',
            'NoTlp'       => 'required|string|max:20',
            'Bio'         => 'nullable|string',
            // FotoProfile sebaiknya divalidasi terpisah jika ada file upload
        ]);

        // REVISI: Tambahkan 'id' di bagian data yang disimpan
        PetaniProfile::updateOrCreate(
            ['idPetani' => Auth::id()], // Kunci pencarian berdasarkan PK
            [                           // Data yang disimpan
                'id'          => Auth::id(), // WAJIB: Mengisi Foreign Key ke tabel users
                'NamaLengkap' => $request->NamaLengkap,
                'NamaKebun'   => $request->NamaKebun,
                'Alamat'      => $request->Alamat,
                'NoTlp'       => $request->NoTlp,
                'Bio'         => $request->Bio,
            ]
        );

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}