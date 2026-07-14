<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permintaan;
use App\Models\Penawaran;
use App\Models\Pembayaran;

class PermintaanController extends Controller
{
    public function dashboard(Request $request)
    {
        $idPermintaans = $request->user()->permintaans()->pluck('idPermintaan');
        $penawarans = Penawaran::with(['petani', 'permintaan']) 
            ->whereIn('idMinta', $idPermintaans)->latest()->take(5)->get(); 

        return view('pembeli.pembeli', compact('penawarans'));
    }

    public function index(Request $request)
    {
        // Panggil relasi penawarans agar kita bisa cek apakah ada yang disetujui[cite: 1]
        $permintaans = $request->user()->permintaans()->with('penawarans')->latest()->get(); 
        return view('pembeli.permintaan', compact('permintaans')); 
    }

    public function destroy($id)
    {
        $permintaan = Permintaan::with('penawarans')->findOrFail($id);
        
        // Cek apakah ada penawaran yang sudah "Setuju"[cite: 1]
        $hasApproved = $permintaan->penawarans->where('Status', 'Setuju')->count() > 0;
        
        if ($hasApproved) {
            return back()->with('error', 'Permintaan tidak bisa dihapus karena sudah ada tawaran yang disetujui.');
        }

        $permintaan->delete();
        return back()->with('success', 'Permintaan berhasil dihapus.');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'NamaTanaman'   => 'required|string',
            'komoditas'     => 'required|string',
            'volume'        => 'required|numeric',
            'batas_harga'   => 'required|numeric',
            'batas_akhir'   => 'required|date',
        ]);

        $request->user()->permintaans()->create([
            'NamaTanaman'       => $request->NamaTanaman,
            'Komoditas'         => $request->komoditas,
            'JumlahDibutuhkan'  => $request->volume,
            'HargaMaksimal'     => $request->batas_harga,
            'BatasTanggal'      => $request->batas_akhir,
            'Status'            => 'Aktif',
        ]);

        return redirect()->route('permintaan.index')->with('success', 'Permintaan berhasil dibuat.');
    }

    // FIX NAMA VIEW BERDASARKAN FOTOMU: daftartawaran
    public function lihatPenawaran($id)
    {
        $permintaan = Permintaan::with(['penawarans.petani.petaniProfile'])->findOrFail($id);
        $penawarans = $permintaan->penawarans;

        return view('pembeli.penawaran_list', compact('permintaan', 'penawarans'));
    }

    public function updateStatusPenawaran(Request $request, $id)
    {
        $penawaran = Penawaran::findOrFail($id);
        $penawaran->Status = $request->status;
        $penawaran->save();

        if ($request->status === 'Setuju') {
            $permintaan = Permintaan::findOrFail($penawaran->idMinta);
            $totalBayar = $penawaran->JumlahTawar * $penawaran->HargaTawar;
            
            // Buat tagihan saat itu juga
            Pembayaran::updateOrCreate(
                ['idTawar' => $penawaran->idTawar],
                [
                    'TotalBayar'       => $totalBayar,
                    'StatusPembayaran' => 'Belum Dibayar',
                    'StatusPesanan'    => 'Menunggu Pembayaran'
                ]
            );

            // Cek akumulasi volume
            $totalVolumeTerkumpul = Penawaran::where('idMinta', $penawaran->idMinta)
                                             ->where('Status', 'Setuju')->sum('JumlahTawar');

            if ($totalVolumeTerkumpul >= $permintaan->JumlahDibutuhkan) {
                $permintaan->update(['Status' => 'Selesai']);
                Penawaran::where('idMinta', $penawaran->idMinta)
                         ->where('Status', 'Pending')->update(['Status' => 'Tidak Setuju']);
            }
        }

        return back()->with('success', 'Status penawaran berhasil diperbarui.');
    }
    // Tambahkan fungsi ini di dalam PermintaanController
    public function lihatFoto($id)
    {
        // Cari data penawaran beserta relasi ke petani
        $tawar = Penawaran::with(['petani.petaniProfile'])->findOrFail($id);

        // Arahkan ke file blade baru (sesuaikan foldernya)
        return view('pembeli.foto_penawaran', compact('tawar'));
    }
}