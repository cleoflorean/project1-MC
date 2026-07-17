@extends('layouts.admin')

@section('title', 'Pusat Laporan - Tani Harvest')
@section('header_title', 'Pusat Resolusi & Laporan')

@section('content')
<div class="container-fluid p-0">
    
    {{-- ALERT NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white pt-4 pb-0 px-4 border-bottom-0">
            <h5 class="fw-bold text-dark mb-4">
                <i class="fas fa-folder-open text-success me-2"></i> Manajemen Laporan Masuk
            </h5>
            
            {{-- NAV TABS (TOMBOL PEMISAH LAPORAN) --}}
            <ul class="nav nav-tabs border-bottom border-2" id="laporanTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold px-4 py-3" id="sandi-tab" data-bs-toggle="tab" data-bs-target="#sandi" type="button" role="tab" style="color: #198754;">
                        <i class="fas fa-key me-1"></i> Lupa Kata Sandi
                        <span class="badge bg-danger ms-2">{{ $dataLupaSandi->where('status', 'Menunggu')->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold px-4 py-3 text-secondary" id="komplain-tab" data-bs-toggle="tab" data-bs-target="#komplain" type="button" role="tab">
                        <i class="fas fa-box-open me-1"></i> Komplain Transaksi
                        <span class="badge bg-danger ms-2">{{ $dataKomplain->where('status', 'Menunggu')->count() }}</span>
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-0">
            <div class="tab-content" id="laporanTabsContent">
                
                {{-- TAB 1: ISI TABEL LUPA KATA SANDI --}}
                <div class="tab-pane fade show active p-0" id="sandi" role="tabpanel" aria-labelledby="sandi-tab">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-muted fw-bold" style="font-size: 0.85rem;">
                                <tr>
                                    <th class="ps-4 py-3">Waktu</th>
                                    <th class="py-3">Pemilik Akun</th>
                                    <th class="py-3">No. WhatsApp</th>
                                    <th class="py-3">Status</th>
                                    <th class="text-center py-3">Aksi Admin</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 0.9rem;">
                                @forelse($dataLupaSandi as $lupa)
                                <tr>
                                    <td class="ps-4 text-muted">{{ $lupa->created_at->translatedFormat('d M, H:i') }}</td>
                                    <td>
                                        <span class="fw-bold text-dark d-block">{{ $lupa->user->username ?? 'User Dihapus' }}</span>
                                        <small class="text-muted">{{ $lupa->user->email ?? '-' }}</small>
                                    </td>
                                    <td><span class="badge bg-success-subtle text-success"><i class="fab fa-whatsapp"></i> {{ $lupa->no_whatsapp }}</span></td>
                                    <td>
                                        @if($lupa->status === 'Menunggu')
                                            <span class="badge bg-danger-subtle text-danger rounded-pill">📂 Menunggu</span>
                                        @else
                                            <span class="badge bg-success-subtle text-success rounded-pill">✅ Selesai</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            // Format nomor WA agar depannya jadi 62
                                            $noWaLupa = $lupa->no_whatsapp;
                                            if (substr($noWaLupa, 0, 1) == '0') {
                                                $noWaLupa = '62' . substr($noWaLupa, 1);
                                            }
                                            $namaUser = $lupa->user->username ?? 'Pelanggan';
                                        @endphp

                                        @if($lupa->status === 'Menunggu')
                                            {{-- 1. SAAT MENUNGGU: TOMBOL PROSES RESET --}}
                                            <form action="{{ route('admin.lupasandi.proses', $lupa->idLupaSandi) }}" method="POST" onsubmit="return confirm('Yakin ingin mereset sandi pengguna ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning w-100 fw-bold shadow-sm text-dark">
                                                    <i class="fas fa-key"></i> Proses Reset Sandi
                                                </button>
                                            </form>

                                        @else
                                            {{-- 2. SETELAH SELESAI: MUNCUL SANDI BARU & TOMBOL WA YANG SUDAH ADA ISI PASSWORDNYA --}}
                                            <div class="d-flex flex-column align-items-center gap-2">
                                                <small class="text-muted fw-bold">Sandi Baru: <code class="fs-6 text-dark bg-light px-2 py-1 rounded border">{{ $lupa->password_sementara }}</code></small>
                                                
                                                <a href="https://wa.me/{{ $noWaLupa }}?text=Halo%20*{{ urlencode($namaUser) }}*,%20permintaan%20reset%20kata%20sandi%20akun%20Tani Harvest%20Anda%20telah%20berhasil.%0A%0AIni%20password%20baru%20kamu:%20*{{ $lupa->password_sementara }}*%0A%0ASilakan%20login%20kembali%20dan%20jangan%20lupa%20langsung%20ganti%20password%20ya!" 
                                                   target="_blank" 
                                                   class="btn btn-sm btn-success w-100 fw-bold shadow-sm mt-1">
                                                    <i class="fab fa-whatsapp"></i> Kirim Sandi via WA
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada pengaduan lupa kata sandi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAB 2: ISI TABEL KOMPLAIN TRANSAKSI BARANG --}}
                <div class="tab-pane fade p-0" id="komplain" role="tabpanel" aria-labelledby="komplain-tab">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-muted fw-bold" style="font-size: 0.85rem;">
                                <tr>
                                    <th class="ps-4 py-3">Pelapor</th>
                                    <th class="py-3">ID Pembayaran</th>
                                    <th class="py-3">Alasan Komplain</th>
                                    <th class="py-3">Bukti</th>
                                    <th class="py-3">Status</th>
                                    <th class="text-center py-3">Tindakan Admin</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 0.9rem;">
                                @forelse($dataKomplain as $komplain)
                                <tr>
                                    <td class="ps-4">
                                        <strong class="text-dark">{{ $komplain->user->username ?? 'User Dihapus' }}</strong><br>
                                        <small class="text-muted"><i class="fab fa-whatsapp text-success"></i> {{ $komplain->no_whatsapp }}</small>
                                    </td>
                                    <td><span class="badge bg-secondary">#{{ $komplain->idPembayaran }}</span></td>
                                    <td style="max-width: 250px;">
                                        <div class="text-wrap text-truncate" style="font-size: 0.85rem;">{{ $komplain->alasan_komplain }}</div>
                                    </td>
                                    <td>
                                        @if($komplain->bukti_pendukung)
                                            <a href="{{ asset('storage/' . $komplain->bukti_pendukung) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 0.75rem;">Lihat Foto</a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $komplain->status == 'Menunggu' ? 'bg-danger' : ($komplain->status == 'Diproses' ? 'bg-warning' : ($komplain->status == 'Selesai' ? 'bg-success' : 'bg-dark')) }}">
                                            {{ $komplain->status }}
                                        </span>
                                    </td>
                                    
                                    <td class="text-center">
                                        @if($komplain->status == 'Menunggu' || $komplain->status == 'Diproses')
                                            
                                            {{-- TOMBOL CHAT PETANI --}}
                                            @php
                                                $noPetani = $komplain->pembayaran->penawaran->petani->telepon ?? ''; 
                                                if (substr($noPetani, 0, 1) == '0') { $noPetani = '62' . substr($noPetani, 1); }
                                            @endphp
                                            <a href="https://wa.me/{{ $noPetani }}?text=Halo%20Petani,%20ada%20komplain%20dari%20pembeli%20untuk%20ID%20Pesanan%20%23{{ $komplain->idPembayaran }}.%20Mohon%20penjelasannya." 
                                               target="_blank" class="btn btn-sm btn-info mb-2 w-100 text-white fw-bold">
                                                <i class="fab fa-whatsapp"></i> Chat Petani
                                            </a>

                                            {{-- TOMBOL TINDAK TEGAS --}}
                                            <form action="{{ route('admin.komplain.tindak', $komplain->idKomplain) }}" method="POST" onsubmit="return confirm('Tindakan ini akan membatalkan pesanan, MENGEMBALIKAN DANA ke pembeli, dan MEMBLOKIR akun petani. Lanjutkan?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger w-100 fw-bold mb-2">
                                                    <i class="fas fa-gavel"></i> Valid (Refund & Blokir)
                                                </button>
                                            </form>
                                            
                                            <hr class="my-1">
                                        @endif

                                        {{-- UPDATE STATUS MANUAL BIASA --}}
                                        <form action="{{ route('admin.komplain.update', $komplain->idKomplain) }}" method="POST" class="d-flex justify-content-center gap-1">
                                            @csrf
                                            <select name="status" class="form-select form-select-sm" style="width: 110px;">
                                                <option value="Menunggu" {{ $komplain->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="Diproses" {{ $komplain->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="Selesai" {{ $komplain->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="Ditolak" {{ $komplain->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center py-5 text-muted">Belum ada komplain barang yang diajukan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.nav-link').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.nav-link').forEach(t => {
                t.style.color = '#6c757d'; 
            });
            this.style.color = '#198754'; 
        });
    });
</script>
@endsection