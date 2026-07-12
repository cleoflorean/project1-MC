<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komplain;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;

class KomplainController extends Controller
{
    // ==========================================
    // POV: PEMBELI - FITUR KOMPLAIN
    // ==========================================

    // 1. Menampilkan form komplain
    public function createKomplain($idPembayaran)
    {
        $pembayaran = Pembayaran::findOrFail($idPembayaran);
        return view('Pembeli.komplain-form', compact('pembayaran')); 
    }

    // 2. Menyimpan data komplain
    public function storeKomplain(Request $request)
    {
        // Validasi form
        $request->validate([
            'idPembayaran'    => 'required',
            'no_whatsapp'     => 'required|numeric', 
            'alasan_komplain' => 'required|string|max:1000',
            'bukti_pendukung' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Upload foto
        $path = null;
        if ($request->hasFile('bukti_pendukung')) {
            $path = $request->file('bukti_pendukung')->store('bukti_komplain', 'public');
        }

        // Simpan ke tabel komplain
        Komplain::create([
            'user_id'         => Auth::id(),
            'idPembayaran'    => $request->idPembayaran,
            'no_whatsapp'     => $request->no_whatsapp,
            'alasan_komplain' => $request->alasan_komplain,
            'bukti_pendukung' => $path,
            'status'          => 'Menunggu'
        ]);

        // Ubah status di tabel pembayaran
        $pembayaran = Pembayaran::findOrFail($request->idPembayaran);
        $pembayaran->update([
            'StatusPesanan' => 'Sedang Komplain'
        ]);

        // Kembali ke halaman riwayat
        return redirect()->route('pembeli.riwayat')->with('success', 'Komplain berhasil diajukan, Admin akan segera memproses.');
    }
}