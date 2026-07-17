<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permintaan;
use App\Models\Penawaran;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\Ulasan; // <-- Tambahkan ini untuk memanggil model User

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
        // Panggil relasi penawarans agar kita bisa cek apakah ada yang disetujui
        $permintaans = $request->user()->permintaans()->with('penawarans')->latest()->get(); 
        return view('pembeli.permintaan', compact('permintaans')); 
    }

    public function destroy($id)
    {
        $permintaan = Permintaan::with('penawarans')->findOrFail($id);
        
        // Cek apakah ada penawaran yang sudah "Setuju"
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
    
    public function lihatFoto($id)
    {
        // Cari data penawaran beserta relasi ke petani
        $tawar = Penawaran::with(['petani.petaniProfile'])->findOrFail($id);

        // Arahkan ke file blade baru (sesuaikan foldernya)
        return view('pembeli.foto_penawaran', compact('tawar'));
    }

    // ==========================================
    // METHOD BARU: Menampilkan Informasi Petani
    // ==========================================
    public function showPetani($id)
    {
        // 1. Cari user petani beserta relasi profilnya
        $petaniUser = User::with('petaniProfile')->findOrFail($id);
        
        // 2. Ambil data profil petaninya
        $petani = $petaniUser->petaniProfile;
        
        if (!$petani) {
            return back()->with('error', 'Petani ini belum melengkapi data profilnya.');
        }

        // Menyisipkan data user ke dalam variabel profil
        $petani->setRelation('user', $petaniUser);

        // 3. Hitung Statistik Transaksi Berhasil (Pesanan Selesai)
        $totalKontrak = Pembayaran::whereIn('StatusPesanan', ['Pesanan Selesai', 'Selesai'])
            ->whereHas('penawaran', function ($query) use ($id) {
                $query->where('idPetani', $id);
            })->count();

        // 4. Hitung Rating & Total Ulasan Asli
        $rataRataRating = Ulasan::whereHas('pembayaran.penawaran', function ($query) use ($id) {
            $query->where('idPetani', $id); 
        })->avg('Rating');
        $rataRataRating = $rataRataRating ? round($rataRataRating, 1) : 0;

        $totalUlasan = Ulasan::whereHas('pembayaran.penawaran', function ($query) use ($id) {
            $query->where('idPetani', $id);
        })->count();

        // 5. Ambil Daftar Ulasan Lengkap beserta relasinya
        $daftarUlasan = Ulasan::with('pembayaran.penawaran.permintaan.user')
            ->whereHas('pembayaran.penawaran', function ($query) use ($id) {
                $query->where('idPetani', $id); 
            })->latest()->get();

        // 6. Kirim data ke view
        return view('pembeli.infopetani', compact(
            'petani', 
            'totalKontrak', 
            'rataRataRating', 
            'totalUlasan',
            'daftarUlasan' // <-- Variabel baru untuk rincian ulasan
        ));
    }
}