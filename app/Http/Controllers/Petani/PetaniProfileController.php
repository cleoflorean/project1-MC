<?php
namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\PetaniProfile;
use App\Models\Ulasan; 
use App\Models\Pembayaran; 
use App\Models\Penawaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PetaniProfileController extends Controller
{
    // 1. HALAMAN UTAMA PROFIL PETANI
    public function index() {
        $user = Auth::user();
        $profil = PetaniProfile::where('user_id', $user->id)->first();
        
        // Hitung rata-rata rating
        $rataRataRating = Ulasan::whereHas('pembayaran.penawaran', function ($query) use ($user) {
            $query->where('idPetani', $user->id); 
        })->avg('Rating');
        $rataRataRating = $rataRataRating ? round($rataRataRating, 1) : 0;

        // Hitung total ulasan masuk
        $totalUlasan = Ulasan::whereHas('pembayaran.penawaran', function ($query) use ($user) {
            $query->where('idPetani', $user->id);
        })->count();

        // Hitung total kontrak sukses
        $totalKontrak = Pembayaran::whereIn('StatusPesanan', ['Pesanan Selesai', 'Selesai'])
            ->whereHas('penawaran', function ($query) use ($user) {
                $query->where('idPetani', $user->id);
            })->count();


        return view('petani.profilpetani', compact('profil', 'user', 'rataRataRating', 'totalUlasan', 'totalKontrak'));
    }

    // 2. HALAMAN BARU: DAFTAR ULASAN LENGKAP
    public function ulasan() {
        $user = Auth::user();
        
        $daftarUlasan = Ulasan::with('pembayaran.penawaran.permintaan.user')
            ->whereHas('pembayaran.penawaran', function ($query) use ($user) {
                $query->where('idPetani', $user->id); 
            })->latest()->get();

        return view('petani.daftar-ulasan', compact('daftarUlasan'));
    }

    // 3. HALAMAN FORM EDIT PROFIL (Fungsi yang baru ditambahkan)
    public function edit() {
        $user = Auth::user();
        $profil = PetaniProfile::where('user_id', $user->id)->first();
        
        // Mengarahkan ke file resources/views/Petani/editpetani.blade.php
        return view('petani.editpetani', compact('user', 'profil'));
    }

    // 4. PROSES SIMPAN EDIT PROFIL
    public function update(Request $request) {
        $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Alamat'      => 'required|string',
            'NoTlp'       => 'required|string|max:20',
            'Bio'         => 'nullable|string',
            'FotoProfile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $dataUpdate = $request->only(['NamaLengkap', 'Alamat', 'NoTlp', 'Bio']);

        if ($request->hasFile('FotoProfile')) {
            $file = $request->file('FotoProfile');
            $filename = time() . '_petani_' . Auth::id() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            $dataUpdate['FotoProfile'] = 'uploads/profile/' . $filename;
        }

        PetaniProfile::updateOrCreate(['user_id' => Auth::id()], $dataUpdate);

        return redirect()->route('petani.profil')->with('success', 'Profil petani berhasil diperbarui!');
    }

    // 5. PROSES SIMPAN REKENING
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

        PetaniProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'NamaBank' => $request->NamaBank,
                'NamaPemilik' => $request->NamaPemilik,
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