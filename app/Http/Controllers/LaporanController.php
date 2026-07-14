<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LupaSandi;
use App\Models\Komplain;
use Illuminate\Support\Facades\Hash;

class LaporanController extends Controller
{
    // Menampilkan Halaman Pusat Resolusi & Laporan
    public function index() 
    {
        $dataLupaSandi = LupaSandi::with('user')->latest()->get();
        // Tambah relasi petani untuk fitur komplain
        $dataKomplain = Komplain::with(['user', 'pembayaran.penawaran.petani'])->latest()->get(); 
        
        return view('admin.laporan', compact('dataLupaSandi', 'dataKomplain'));
    }

    // Eksekusi Reset Password & Kirim Link WA
    public function prosesLupaSandi($id) 
    {
        $lupa = LupaSandi::with('user')->where('idLupaSandi', $id)->firstOrFail();
        $passBaru = 'Tani' . rand(1000, 9999); 

        $lupa->user->update(['password' => Hash::make($passBaru)]);
        $lupa->update(['status' => 'Selesai', 'password_sementara' => $passBaru]); 

        // Format link WhatsApp otomatis
        $no_wa = preg_replace('/^0/', '62', $lupa->no_whatsapp);
        $txt = rawurlencode("Halo {$lupa->user->username},\n\nPermintaan reset kata sandi Anda telah kami proses.\nSandi baru Anda adalah: *{$passBaru}*\n\nHarap segera login dan ganti password Anda demi keamanan.");
        
        return back()->with([
            'success' => "Password berhasil di-reset menjadi {$passBaru}. Membuka WhatsApp...",
            'bukaWA' => "https://wa.me/{$no_wa}?text={$txt}" 
        ]);
    }

    // FUNGSI BARU: STRATEGI TINDAK TEGAS (BLOKIR PETANI & REFUND)
    public function tindakTegasKomplain($id)
    {
        // Ambil data komplain beserta relasi ke pembayaran dan petani
        $komplain = Komplain::with('pembayaran.penawaran.petani')->where('idKomplain', $id)->firstOrFail();
        $pembayaran = $komplain->pembayaran;
        
        // Ambil data petani dari relasi penawaran
        $petani = $pembayaran->penawaran->petani; 

        // 1. KEMBALIKAN DANA KE PEMBELI (Di-Refund)
        $pembayaran->update([
            'StatusPembayaran' => 'Ditolak', 
            'StatusPesanan'    => 'Dibatalkan' 
        ]);

        // 2. BLOKIR AKUN PETANI
        if ($petani) {
            // Asumsi di tabel 'users' ada kolom 'status'. Ubah jika beda.
            $petani->update([
                'status' => 'Diblokir' 
            ]);
        }

        // 3. TUTUP KOMPLAIN
        $komplain->update([
            'status' => 'Selesai (Dana Dikembalikan)',
            'catatan_admin' => 'Petani terbukti melanggar. Pesanan dibatalkan, dana dikembalikan, dan akun petani diblokir.'
        ]);

        return back()->with('success', 'Tindakan tegas berhasil! Dana dikembalikan ke pembeli dan akun petani telah diblokir.');
    }

    // Mengupdate status komplain biasa
    public function updateStatusKomplain(Request $request, $id) 
    {
        $komplain = Komplain::where('idKomplain', $id)->firstOrFail();
        
        $komplain->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin
        ]);

        return back()->with('success', 'Status komplain berhasil diperbarui!');
    }
}