<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permintaan;
use App\Models\Penawaran;
use App\Models\Pembayaran;
use App\Models\Pengiriman; // <-- Tambahkan ini untuk menghitung total kontrak
use App\Models\User;
use App\Models\Ulasan; 
use Illuminate\Support\Facades\DB;

class PermintaanController extends Controller
{
    public function dashboard(Request $request)
    {
        Penawaran::cleanExpired();
        $idPermintaans = $request->user()->permintaans()->pluck('idPermintaan');
        $penawarans = Penawaran::with(['petani.profile', 'permintaan']) // <-- FIX: profile jadi profile
            ->whereIn('idMinta', $idPermintaans)->latest()->take(5)->get(); 

        return view('pembeli.pembeli', compact('penawarans'));
    }

    public function index(Request $request)
    {
        Penawaran::cleanExpired();
        $permintaans = $request->user()->permintaans()->with('penawarans')->latest()->get(); 
        return view('pembeli.permintaan', compact('permintaans')); 
    }

    public function destroy($id)
    {
        $permintaan = Permintaan::with('penawarans')->findOrFail($id);
        
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

    public function lihatPenawaran($id)
    {
        Penawaran::cleanExpired();
        $permintaan = Permintaan::with(['penawarans.petani.profile'])->findOrFail($id); // <-- FIX: profile jadi profile
        $penawarans = $permintaan->penawarans;

        return view('pembeli.penawaran_list', compact('permintaan', 'penawarans'));
    }

    public function lihatFoto($id)
    {
        $tawar = Penawaran::with(['petani.profile', 'permintaan'])->findOrFail($id);
        return view('pembeli.foto_penawaran', compact('tawar'));
    }

    public function updateStatusPenawaran(Request $request, $id)
    {
        Penawaran::cleanExpired();
        if ($request->status === 'Setuju') {
            return DB::transaction(function () use ($request, $id) {
                // 1. Kunci baris penawaran dari race condition (klik barengan)
                $penawaran = Penawaran::lockForUpdate()->findOrFail($id);

                // Cek pengaman: Kalau ternyata sudah bukan Pending lagi (misal baru saja otomatis ditutup sistem), batalkan!
                if ($penawaran->Status !== 'Pending') {
                    return back()->with('error', 'Maaf, penawaran ini sudah kedaluwarsa (melampaui batas 2x24 jam tanpa respon) atau stok petani sudah dialokasikan ke pesanan lain.');
                }

                $penawaran->Status = 'Setuju';
                $penawaran->save();

                $permintaan = Permintaan::findOrFail($penawaran->idMinta);
                $totalBayar = $penawaran->JumlahTawar * $penawaran->HargaTawar;
                
                // 2. Buat tagihan pembayaran
                Pembayaran::updateOrCreate(
                    ['idTawar' => $penawaran->idTawar],
                    [
                        'TotalBayar'       => $totalBayar,
                        'StatusPembayaran' => 'Belum Dibayar'
                    ]
                );

                // 3. Buat data pengiriman awal agar StatusPesanan bisa dilacak
                Pengiriman::updateOrCreate(
                    ['idTawar' => $penawaran->idTawar],
                    [
                        'StatusPesanan' => 'Menunggu Pembayaran'
                    ]
                );

                // 4. FITUR ANTI DOUBLE-BOOKING: Otomatis batalkan penawaran lain dari PETANI INI untuk JENIS TANAMAN YANG SAMA yang masih Pending
                Penawaran::where('idPetani', $penawaran->idPetani)
                         ->where('idTawar', '!=', $id)
                         ->where('Status', 'Pending')
                         ->whereHas('permintaan', function ($query) use ($permintaan) {
                             $query->where('NamaTanaman', $permintaan->NamaTanaman);
                         })
                         ->update([
                             'Status' => 'Tidak Setuju',
                             'Catatan' => 'Dibatalkan otomatis oleh sistem: Stok panen ' . $permintaan->NamaTanaman . ' sudah dialokasikan ke pesanan lain yang disetujui.'
                         ]);

                // 5. Cek apakah volume permintaan pembeli sudah terpenuhi
                $totalVolumeTerkumpul = Penawaran::where('idMinta', $penawaran->idMinta)
                                                 ->where('Status', 'Setuju')->sum('JumlahTawar');

                if ($totalVolumeTerkumpul >= $permintaan->JumlahDibutuhkan) {
                    $permintaan->update(['Status' => 'Selesai']);
                    Penawaran::where('idMinta', $penawaran->idMinta)
                             ->where('Status', 'Pending')->update(['Status' => 'Tidak Setuju']);
                }

                return back()->with('success', 'Status penawaran berhasil disetujui. Penawaran ganda lain untuk ' . $permintaan->NamaTanaman . ' dari petani ini otomatis ditutup oleh sistem.');
            });
        } else {
            // Untuk status selain 'Setuju' (misal 'Tidak Setuju' / tolak manual)
            $penawaran = Penawaran::findOrFail($id);
            $penawaran->Status = $request->status;
            $penawaran->save();

            return back()->with('success', 'Status penawaran berhasil diperbarui.');
        }
    }

    // ==========================================
    // METHOD PROFIL PETANI (SUDAH DISINKRONKAN)
    // ==========================================
    public function showPetani($id)
    {
        // 1. FIX: Cari user petani menggunakan relasi profile universal
        $petaniUser = User::with('profile')->findOrFail($id);
        
        // 2. Ambil data profil petaninya
        $petani = $petaniUser->profile;
        
        if (!$petani) {
            return back()->with('error', 'Petani ini belum melengkapi data profilnya.');
        }

        $petani->setRelation('user', $petaniUser);

        // 3. FIX: StatusPesanan sekarang mengacu ke tabel pengirimans agar sinkron dengan sisi petani
        $totalKontrak = Pengiriman::whereIn('StatusPesanan', ['Pesanan Selesai', 'Selesai'])
            ->whereHas('penawaran', function ($query) use ($id) {
                $query->where('idPetani', $id);
            })->count();

        // 4. FIX: Ulasan sekarang terhubung langsung ke penawaran (tanpa lewat pembayaran)
        $rataRataRating = Ulasan::whereHas('penawaran', function ($query) use ($id) {
            $query->where('idPetani', $id); 
        })->avg('Rating');
        $rataRataRating = $rataRataRating ? round($rataRataRating, 1) : 0;

        $totalUlasan = Ulasan::whereHas('penawaran', function ($query) use ($id) {
            $query->where('idPetani', $id);
        })->count();

        // 5. FIX: Menyesuaikan rantai relasi untuk daftar rincian ulasan
        $daftarUlasan = Ulasan::with('penawaran.permintaan.user.profile')
            ->whereHas('penawaran', function ($query) use ($id) {
                $query->where('idPetani', $id); 
            })->latest()->get();

        // 6. Kirim data ke view
        return view('pembeli.infopetani', compact(
            'petani', 
            'totalKontrak', 
            'rataRataRating', 
            'totalUlasan',
            'daftarUlasan'
        ));
    }
}