<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\Profile; // <-- PERBAIKAN 1: Panggil model universal
use App\Models\User;
use App\Models\Rekening;

class ProfilController extends Controller
{
    // Halaman Tampil Profil
    public function index() {
        $user = Auth::user();
        $profil = Profile::where('user_id', $user->id)->first(); // <-- PERBAIKAN 2
        return view('pembeli.profilpembeli', compact('user', 'profil'));
    }

    // Halaman Form Edit Profil (Terpisah)
    public function edit() {
        $user = Auth::user();
        $profil = Profile::where('user_id', $user->id)->first(); // <-- PERBAIKAN 2
        return view('pembeli.editprofil', compact('user', 'profil')); 
    }

    // Aksi Simpan Perubahan Data Profil
    public function update(Request $request) {
        // Validasi input (Nama input form tetap FotoProfile, tidak apa-apa)
        $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Alamat'      => 'required|string',
            'NoWhatsApp'       => 'required|string|max:20',
            'Bio'         => 'nullable|string',
            'FotoProfile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profil = Profile::firstOrNew(['user_id' => Auth::id()]); // <-- PERBAIKAN 2

        // 1. Cek apakah user mengklik tombol hapus foto
        if ($request->hapus_foto == '1') {
            // PERBAIKAN 3: Ganti FotoProfile jadi FotoProfil (sesuai database)
            if ($profil->FotoProfil && file_exists(public_path($profil->FotoProfil))) {
                unlink(public_path($profil->FotoProfil));
            }
            $profil->FotoProfil = null; 
        }

        // 2. Logika upload foto baru
        if ($request->hasFile('FotoProfile')) {
            if ($profil->FotoProfil && file_exists(public_path($profil->FotoProfil))) {
                unlink(public_path($profil->FotoProfil));
            }

            $file = $request->file('FotoProfile');
            $filename = time() . '_pembeli_' . Auth::id() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            
            // Simpan path foto baru (tanpa 'e')
            $profil->FotoProfil = 'uploads/profile/' . $filename;
        }

        // 3. Update field teks lainnya
        $profil->NamaLengkap = $request->NamaLengkap;
        $profil->Alamat      = $request->Alamat;
        $profil->Bio         = $request->Bio;
        $profil->NoWhatsApp  = $request->NoWhatsApp; // <-- PERBAIKAN 4: Sesuaikan ke NoWhatsApp

        // Simpan semua perubahan ke database
        $profil->save();

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui!');
    }

    // Aksi Ganti Password (Sudah Benar)
    public function updatePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password lama Anda salah!']);
        }

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profil')->with('success', 'Password berhasil diganti!');
    }

    // Aksi Update Rekening
    public function updateRekening(Request $request) {
        $request->validate([
            'NamaBank' => 'required|string|max:100',
            'NamaPemilik' => 'required|string|max:255',
            'NoRekening' => 'required|string|max:50',
            'password' => 'required|string', 
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Password salah! Perubahan rekening gagal disimpan.');
        }

        Rekening::updateOrCreate(
            ['user_id' => $user->id],
            [
                'NamaBank' => $request->NamaBank,
                'AtasNama' => $request->NamaPemilik,
                'NoRekening' => $request->NoRekening,
            ]
        );

        return redirect()->back()->with('success', 'Informasi Rekening Pembayaran berhasil diperbarui!');
    }
}