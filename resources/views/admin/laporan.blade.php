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
            </ul>
        </div>

        <div class="card-body p-0">
            <div class="tab-content" id="laporanTabsContent">
                
                {{-- TAB 1: ISI TABEL LUPA KATA SANDI --}}
                <div class="tab-pane fade show active p-0" id="sandi" role="tabpanel" aria-labelledby="sandi-tab">
                    <div class="table-responsive">
                        <table style="width: 100%; border-collapse: separate; border-spacing: 0; text-align: left; font-size: 0.85rem;">
                            <thead>
                                <tr style="background: #f8fafc; color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.5px;">
                                    <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0; border-top-left-radius: 8px;">Waktu</th>
                                    <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0;">Pemilik Akun</th>
                                    <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0;">No. WhatsApp</th>
                                    <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0;">Status</th>
                                    <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0; border-top-right-radius: 8px; text-align: center;">Aksi Admin</th>
                                </tr>
                            </thead>
                            <tbody style="color: #334155;">
                                @forelse($dataLupaSandi as $lupa)
                                <tr style="transition: all 0.2s ease; border-bottom: 1px solid #f1f5f9;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.transform='translateY(-1px)';" onmouseout="this.style.backgroundColor='transparent'; this.style.transform='none';">
                                    <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-size: 0.8rem;">
                                        <i class="far fa-clock" style="margin-right: 4px;"></i> {{ $lupa->created_at->translatedFormat('d M, H:i') }}
                                    </td>
                                    <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9;">
                                        <div style="font-weight: 700; color: #0f172a; font-size: 0.85rem;">{{ $lupa->user->username ?? 'User Dihapus' }}</div>
                                        <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">{{ $lupa->user->email ?? '-' }}</div>
                                    </td>
                                    <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9;">
                                        <span style="background: #ecfdf5; color: #047857; padding: 4px 10px; border-radius: 9999px; font-weight: 600; font-size: 0.7rem; border: 1px solid #d1fae5; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fab fa-whatsapp"></i> {{ $lupa->no_whatsapp }}
                                        </span>
                                    </td>
                                    <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9;">
                                        @if($lupa->status === 'Menunggu')
                                            <span style="background: #fef2f2; color: #991b1b; padding: 4px 10px; border-radius: 9999px; font-weight: 600; font-size: 0.7rem; border: 1px solid #fecaca; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="fas fa-folder-open"></i> Menunggu
                                            </span>
                                        @else
                                            <span style="background: #f0fdf4; color: #166534; padding: 4px 10px; border-radius: 9999px; font-weight: 600; font-size: 0.7rem; border: 1px solid #bbf7d0; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="fas fa-check-circle"></i> Selesai
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                        @php
                                            $noWaLupa = $lupa->no_whatsapp;
                                            if (substr($noWaLupa, 0, 1) == '0') {
                                                $noWaLupa = '62' . substr($noWaLupa, 1);
                                            }
                                            $namaUser = $lupa->user->username ?? 'Pelanggan';
                                        @endphp

                                        @if($lupa->status === 'Menunggu')
                                            <form action="{{ route('admin.lupasandi.proses', $lupa->idLupaSandi) }}" method="POST" onsubmit="return confirm('Yakin ingin mereset sandi pengguna ini?')" style="margin: 0;">
                                                @csrf
                                                <button type="submit" style="background: #f59e0b; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 0.75rem; width: 100%; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#d97706'" onmouseout="this.style.background='#f59e0b'">
                                                    <i class="fas fa-key"></i> Proses Reset Sandi
                                                </button>
                                            </form>
                                        @else
                                            <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                                <div style="font-size: 0.7rem; color: #64748b; font-weight: 600;">Sandi Baru: <code style="font-size: 0.75rem; color: #0f172a; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0;">{{ $lupa->password_sementara }}</code></div>
                                                
                                                <a href="https://wa.me/{{ $noWaLupa }}?text=Halo%20*{{ urlencode($namaUser) }}*,%20permintaan%20reset%20kata%20sandi%20akun%20Tani Harvest%20Anda%20telah%20berhasil.%0A%0AIni%20password%20baru%20kamu:%20*{{ $lupa->password_sementara }}*%0A%0ASilakan%20login%20kembali%20dan%20jangan%20lupa%20langsung%20ganti%20password%20ya!" 
                                                   target="_blank" 
                                                   style="display: block; width: 100%; background: #10b981; color: white; text-decoration: none; padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 0.75rem; transition: background 0.2s;"
                                                   onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">
                                                    <i class="fab fa-whatsapp"></i> Kirim Sandi via WA
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" style="padding: 60px 20px; text-align: center; color: #94a3b8;">
                                        <i class="fas fa-inbox" style="font-size: 2.5rem; color: #e2e8f0; margin-bottom: 12px; display: block;"></i>
                                        <div style="font-size: 0.9rem; font-weight: 500;">Belum ada pengaduan lupa kata sandi.</div>
                                    </td>
                                </tr>
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