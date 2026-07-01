<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\PembeliProfile;
use App\Models\User;

class ProfilController extends Controller
{
    // Halaman Tampil Profil
    public function index() {
        $user = Auth::user();
        $profil = PembeliProfile::where('user_id', $user->id)->first();
        return view('Pembeli.profilpembeli', compact('user', 'profil'));
    }

    // Halaman Form Edit Profil (Terpisah)
    public function edit() {
        $user = Auth::user();
        $profil = PembeliProfile::where('user_id', $user->id)->first();
        return view('Pembeli.editprofil', compact('user', 'profil')); 
    }

    // Aksi Simpan Perubahan Data Profil (Gabungan Logika Upload & Hapus Foto)
    public function update(Request $request) {
        // Validasi input
        $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Alamat'      => 'required|string',
            'NoTlp'       => 'required|string|max:20',
            'Bio'         => 'nullable|string',
            'FotoProfile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Ambil data profil berdasarkan user_id, atau buat instance baru jika belum ada
        $profil = PembeliProfile::firstOrNew(['user_id' => Auth::id()]);

        // 1. Cek apakah user mengklik tombol hapus foto dari frontend
        if ($request->hapus_foto == '1') {
            // Hapus file fisik dari folder public/uploads/profile jika file tersebut ada
            if ($profil->FotoProfile && file_exists(public_path($profil->FotoProfile))) {
                unlink(public_path($profil->FotoProfile));
            }
            // Set kolom di database menjadi null
            $profil->FotoProfile = null;
        }

        // 2. Logika upload foto baru (jika user memilih foto)
        if ($request->hasFile('FotoProfile')) {
            // Opsional: Hapus foto lama agar storage server tidak penuh
            if ($profil->FotoProfile && file_exists(public_path($profil->FotoProfile))) {
                unlink(public_path($profil->FotoProfile));
            }

            $file = $request->file('FotoProfile');
            $filename = time() . '_pembeli_' . Auth::id() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            
            // Simpan path foto baru
            $profil->FotoProfile = 'uploads/profile/' . $filename;
        }

        // 3. Update field teks lainnya
        $profil->NamaLengkap = $request->NamaLengkap;
        $profil->Alamat      = $request->Alamat;
        $profil->NoTlp       = $request->NoTlp;
        $profil->Bio         = $request->Bio;

        // Simpan semua perubahan ke database
        $profil->save();

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui!');
    }

    // Aksi Ganti Password (BARU & AMAN)
    public function updatePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password lama Anda salah!']);
        }

        // Update password di tabel users
        User::where('id', $user->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profil')->with('success', 'Password berhasil diganti!');
    }
}