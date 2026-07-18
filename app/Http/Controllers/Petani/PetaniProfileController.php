<?php
namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Rekening;
use App\Models\Ulasan; 
use App\Models\Pembayaran; 
use App\Models\Penawaran;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PetaniProfileController extends Controller
{
    // 1. HALAMAN UTAMA PROFIL PETANI
   public function index() {
        $user = Auth::user();
        $profil = Profile::where('user_id', $user->id)->first();
        
        // FIX: Ulasan sekarang terhubung langsung ke penawaran (idTawar)
        $rataRataRating = Ulasan::whereHas('penawaran', function ($query) use ($user) {
            $query->where('idPetani', $user->id); 
        })->avg('Rating');
        $rataRataRating = $rataRataRating ? round($rataRataRating, 1) : 0;

        $totalUlasan = Ulasan::whereHas('penawaran', function ($query) use ($user) {
            $query->where('idPetani', $user->id);
        })->count();

        // FIX: StatusPesanan sekarang ada di tabel pengirimans, bukan pembayarans
        $totalKontrak = Pengiriman::whereIn('StatusPesanan', ['Pesanan Selesai', 'Selesai'])
            ->whereHas('penawaran', function ($query) use ($user) {
                $query->where('idPetani', $user->id);
            })->count();

        return view('petani.profilpetani', compact('profil', 'user', 'rataRataRating', 'totalUlasan', 'totalKontrak'));
    }

    public function ulasan() {
        $user = Auth::user();
        // FIX: Rantai relasi disesuaikan
        $daftarUlasan = Ulasan::with('penawaran.permintaan.user')
            ->whereHas('penawaran', function ($query) use ($user) {
                $query->where('idPetani', $user->id); 
            })->latest()->get();

        return view('petani.daftar-ulasan', compact('daftarUlasan'));
    }

    public function edit() {
        $user = Auth::user();
        $profil = Profile::where('user_id', $user->id)->first();
        return view('petani.editpetani', compact('user', 'profil'));
    }

    public function update(Request $request) {
        // 1. Validasi Input (Pastikan Bio divalidasi)
        $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Alamat'      => 'required|string',
            'NoWhatsApp'       => 'required|string|max:20',
            'Bio'         => 'nullable|string',
            'FotoProfile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Panggil model Profile Universal
        $profil = \App\Models\Profile::firstOrNew(['user_id' => \Illuminate\Support\Facades\Auth::id()]);

        // 3. Logika Hapus Foto (Jika tombol hapus diklik)
        if ($request->hapus_foto == '1') {
            if ($profil->FotoProfil && file_exists(public_path($profil->FotoProfil))) {
                unlink(public_path($profil->FotoProfil));
            }
            $profil->FotoProfil = null; // Ingat: Tanpa huruf 'e' di akhir untuk database
        }

        // 4. Logika Upload Foto Baru
        if ($request->hasFile('FotoProfile')) {
            // Hapus foto lama agar server tidak penuh
            if ($profil->FotoProfil && file_exists(public_path($profil->FotoProfil))) {
                unlink(public_path($profil->FotoProfil));
            }
            
            $file = $request->file('FotoProfile');
            $filename = time() . '_petani_' . \Illuminate\Support\Facades\Auth::id() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            
            // Simpan path ke database
            $profil->FotoProfil = 'uploads/profile/' . $filename; 
        }

        // 5. Simpan Data Teks
        $profil->NamaLengkap = $request->NamaLengkap;
        $profil->Alamat      = $request->Alamat;
        $profil->NoWhatsApp  = $request->NoWhatsApp; 
        $profil->Bio         = $request->Bio; 

        // 6. Eksekusi Simpan ke Database
        $profil->save();

        return redirect()->route('petani.profil')->with('success', 'Profil petani berhasil diperbarui!');
    }

    public function updateRekening(Request $request) 
    {
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

        // FIX: Simpan ke tabel rekening
        Rekening::updateOrCreate(
            ['user_id' => $user->id],
            [
                'NamaBank' => $request->NamaBank,
                'AtasNama' => $request->NamaPemilik, // Di migration namanya AtasNama
                'NoRekening' => $request->NoRekening,
            ]
        );

        return redirect()->back()->with('success', 'Informasi Rekening Pembayaran berhasil diperbarui!');
    }
    // 6. PROSES UPDATE PASSWORD
    public function updatePassword(Request $request)
    {
        // Validasi inputan form
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' akan otomatis mengecek input 'password_confirmation'
        ], [
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'password.min' => 'Kata sandi minimal harus 8 karakter.'
        ]);

        $user = Auth::user();

        // Cek apakah password lama yang dimasukkan benar
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Kata sandi saat ini yang Anda masukkan salah.');
        }

        // Jika benar, update ke password baru
        /** @var \App\Models\User $user */
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('petani.profil')->with('success', 'Keamanan akun: Kata sandi berhasil diperbarui!');
    }
}