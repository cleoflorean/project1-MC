@extends('layouts.admin')

@section('title', 'Dashboard Administrator')
@section('header_title', 'Control Panel Admin')

@section('content')
<div style="font-family: 'Inter', sans-serif; max-width: 1200px; margin: 0 auto; color: #1e293b;">
    
    {{-- SUB-TITLE UTAMA --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; border-bottom: 1px solid #e2e8f0; padding-bottom: 14px;">
        <div>
            <h2 style="margin: 0; font-size: 1.2rem; font-weight: 800; tracking: -0.025em; color: #0f172a;">Ringkasan Sistem</h2>
            <p style="margin: 3px 0 0 0; color: #64748b; font-size: 0.75rem;">Sistem pengawasan transaksi dan manajemen akun pengguna.</p>
        </div>
    </div>

    {{-- ALERT NOTIFIKASI SYSTEM --}}
    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 10px 14px; border-radius: 6px; margin-bottom: 20px; font-weight: 500; font-size: 0.75rem; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-check-circle" style="color: #16a34a;"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fff1f2; border: 1px solid #fecdd3; color: #991b1b; padding: 10px 14px; border-radius: 6px; margin-bottom: 20px; font-weight: 500; font-size: 0.75rem; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-exclamation-circle" style="color: #dc2626;"></i> {{ session('error') }}
        </div>
    @endif

    {{-- KARTU STATISTIK (DIKUNCI PASTI 4 KOLOM SEJAJAR) --}}
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 25px;">
        
        {{-- CARD 1 --}}
        <div style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="color: #64748b; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Dana Ditampung</div>
                <div style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin-top: 6px;">Rp {{ number_format($totalDanaAdmin, 0, ',', '.') }}</div>
            </div>
            <small style="color: #94a3b8; display: block; margin-top: 8px; font-size: 0.7rem; border-top: 1px dashed #f1f5f9; padding-top: 6px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <i class="fas fa-wallet" style="color: #10b981;"></i> Saldo di Rekening Admin
            </small>
        </div>

        {{-- CARD 2 --}}
        <div style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="color: #64748b; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Perlu Verifikasi</div>
                <div style="font-size: 1.35rem; font-weight: 800; color: #d97706; margin-top: 6px;">{{ $menungguVerifikasi }} <span style="font-size: 0.85rem; font-weight: 500; color: #64748b;">Transaksi</span></div>
            </div>
            <small style="color: #94a3b8; display: block; margin-top: 8px; font-size: 0.7rem; border-top: 1px dashed #f1f5f9; padding-top: 6px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <i class="fas fa-clock" style="color: #f59e0b;"></i> Menunggu peninjauan
            </small>
        </div>

        {{-- CARD 3 --}}
        <div style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="color: #64748b; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Transaksi Sukses</div>
                <div style="font-size: 1.35rem; font-weight: 800; color: #2563eb; margin-top: 6px;">Rp {{ number_format($totalTransaksiSukses, 0, ',', '.') }}</div>
            </div>
            <small style="color: #94a3b8; display: block; margin-top: 8px; font-size: 0.7rem; border-top: 1px dashed #f1f5f9; padding-top: 6px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <i class="fas fa-check-double" style="color: #3b82f6;"></i> Sukses ke petani
            </small>
        </div>

        {{-- CARD 4 --}}
        <div style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="color: #64748b; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Mitra Petani</div>
                <div style="font-size: 1.35rem; font-weight: 800; color: #047857; margin-top: 6px;">{{ $jumlahPetani }} <span style="font-size: 0.85rem; font-weight: 500; color: #64748b;">Akun</span></div>
            </div>
            <small style="color: #94a3b8; display: block; margin-top: 8px; font-size: 0.7rem; border-top: 1px dashed #f1f5f9; padding-top: 6px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <i class="fas fa-users" style="color: #10b981;"></i> Petani terdaftar resmi
            </small>
        </div>
    </div>

    {{-- NAVIGATION TABS MENU --}}
    <div style="display: flex; gap: 4px; border-bottom: 1px solid #e2e8f0; margin-bottom: 16px;">
        <button class="tab-btn active-tab" onclick="openAdminTab(event, 'tabTransaksi')">
            <i class="fas fa-exchange-alt" style="margin-right: 6px; font-size: 0.8rem;"></i> Daftar Transaksi Terbaru
        </button>
        <button class="tab-btn" onclick="openAdminTab(event, 'tabAkun')">
            <i class="fas fa-user-cog" style="margin-right: 6px; font-size: 0.8rem;"></i> Manajemen Pengguna
        </button>
    </div>

    {{-- KONTEN 1: TAB DAFTAR TRANSAKSI (DESAIN PERSIS GAMBAR CONTOH) --}}
    <div id="tabTransaksi" class="admin-tab-content" style="display: block;">
        <div style="background: white; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); overflow: hidden;">
            <div style="padding: 12px 16px; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                <h3 style="margin: 0; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.025em; color: #475569;">
                    <i class="fas fa-history" style="color: #64748b;"></i> Monitoring 5 Aktivitas Transaksi Terakhir
                </h3>
            </div>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: separate; border-spacing: 0; text-align: left; font-size: 0.85rem;">
                    <thead>
                    <tr style="background: #f8fafc; color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.5px;">
                        <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0; text-align: left; border-top-left-radius: 8px; text-align: center;">Transaksi</th>
                        <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0; text-align: center;">Petani</th>
                        <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0; text-align: center;">Pembeli</th>
                        <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0; text-align: center;">Komoditas</th>
                        <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0; text-align: center;">Status Info</th>
                        <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0; text-align: center;">Lampiran</th>
                        <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0; border-top-right-radius: 8px; text-align: center;">Aksi Kendali</th>
                    </tr>
                </thead>
                    <tbody style="color: #334155;">
                        @forelse($semuaTransaksi as $trx)
                        
                        @php
                            $statusPesanan = trim(optional($trx->pengiriman)->StatusPesanan);
                            $klasterStatus = 'unknown';
                            
                            if ($trx->StatusPembayaran === 'Belum Bayar' || $trx->StatusPembayaran === 'Menunggu Pembayaran' || empty($trx->BuktiTransfer)) {
                                $klasterStatus = 'unpaid';
                            } elseif ($trx->StatusPembayaran === 'Menunggu Verifikasi Admin' || $trx->StatusPembayaran === 'Menunggu Verifikasi') {
                                $klasterStatus = 'pending';
                            } elseif ($trx->StatusPembayaran === 'Dana Dicairkan') {
                                // STATUS BARU: Uang sudah dikirim ke Petani
                                $klasterStatus = 'done';
                            } elseif ($trx->StatusPembayaran === 'Ditolak' || $trx->StatusPembayaran === 'Dibatalkan' || $statusPesanan === 'Dibatalkan') {
                                $klasterStatus = 'done';
                            } elseif ($trx->StatusPembayaran === 'Lunas' && in_array($statusPesanan, ['Pesanan Selesai', 'Selesai', 'Pesanan Diterima', 'Barang Diterima', 'Diterima'])) {
                                // Jika pesanan sudah diterima/selesai TAPI uang masih Lunas (belum dicairkan), tombol cairkan muncul
                                $klasterStatus = 'ready'; 
                            } elseif ($trx->StatusPembayaran === 'Lunas') {
                                $klasterStatus = 'escrow';
                            }
                        @endphp

                        <tr class="trx-row" data-status="{{ $klasterStatus }}" style="transition: all 0.2s ease; border-bottom: 1px solid #f1f5f9;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.transform='translateY(-1px)';" onmouseout="this.style.backgroundColor='transparent'; this.style.transform='none';">
    
                        {{-- 1. Transaksi Info --}}
                        <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; white-space: nowrap; min-width: 200px;">
                            <div style="font-weight: 800; color: #0f172a; font-size: 0.9rem; margin-bottom: 4px;">{{ $trx->no_pesanan ?? '-' }}</div>
                            <div style="font-weight: 700; color: #059669; font-size: 0.85rem; margin-bottom: 4px;">Rp {{ number_format($trx->TotalBayar, 0, ',', '.') }}</div>
                            <div style="color: #94a3b8; font-size: 0.75rem;">{{ $trx->created_at ? $trx->created_at->format('d M Y') : '-' }}</div>
                        </td>

                        {{-- 2. PETANI  --}}
                        <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9;" class="searchable-cell">
                            <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; flex-shrink: 0;">
                                    {{ strtoupper(substr($trx->penawaran->petani->username ?? 'P', 0, 1)) }}
                                </div>
                                <div style="font-weight: 700; color: #1e293b; font-size: 0.85rem;">
                                    {{ $trx->penawaran->petani->username ?? '-' }}
                                </div>
                            </div>
                        </td>

                        {{-- 3. PEMBELI  --}}
                        <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9;" class="searchable-cell">
                            <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; flex-shrink: 0;">
                                    {{ strtoupper(substr($trx->penawaran->permintaan->user->username ?? 'G', 0, 1)) }}
                                </div>
                                <div style="font-weight: 700; color: #1e293b; font-size: 0.85rem;">
                                    {{ $trx->penawaran->permintaan->user->username ?? 'Guest' }}
                                </div>
                            </div>
                        </td>
                        
                        {{-- 4. Komoditas --}}
                        <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; text-align: center;" class="searchable-cell">
                            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <div style="font-weight: 700; color: #1e293b; font-size: 0.85rem;">
                                    {{ $trx->penawaran->permintaan->Komoditas->namatanaman ?? '-' }}
                                </div>
                                <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">
                                    {{ $trx->penawaran->permintaan->Komoditas->komoditas ?? '-' }}
                                </div>
                            </div>
                        </td>
                        
                        {{-- 5. Status Info --}}
                        <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; text-align: center;">
                            <div style="display: flex; flex-direction: column; gap: 6px; align-items: center; justify-content: center;">
                                <div>
                                    @if($klasterStatus === 'unpaid')
                                        <span style="background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 9999px; font-weight: 600; font-size: 0.7rem; border: 1px solid #e2e8f0; display: inline-block;">Belum Bayar</span>
                                    @elseif($klasterStatus === 'pending')
                                        <span style="background: #fff7ed; color: #c2410c; padding: 4px 10px; border-radius: 9999px; font-weight: 600; font-size: 0.7rem; border: 1px solid #ffedd5; display: inline-block;">Belum Verifikasi</span>
                                    @elseif($klasterStatus === 'escrow' || $klasterStatus === 'ready')
                                        <span style="background: #ecfdf5; color: #047857; padding: 4px 10px; border-radius: 9999px; font-weight: 600; font-size: 0.7rem; border: 1px solid #d1fae5; display: inline-block;">Dana Diterima</span>
                                    @elseif($klasterStatus === 'done' && $trx->StatusPembayaran !== 'Ditolak' && $trx->StatusPembayaran !== 'Dibatalkan' && $statusPesanan !== 'Dibatalkan')
                                        <span style="background: #f0fdf4; color: #166534; padding: 4px 10px; border-radius: 9999px; font-weight: 600; font-size: 0.7rem; border: 1px solid #bbf7d0; display: inline-block;">Selesai (Cair)</span>
                                    @else
                                        <span style="background: #fef2f2; color: #991b1b; padding: 4px 10px; border-radius: 9999px; font-weight: 600; font-size: 0.7rem; border: 1px solid #fecaca; display: inline-block;">Dibatalkan</span>
                                    @endif
                                </div>
                                <div style="font-size: 0.7rem; font-weight: 600; color: #64748b;">
                                    @if(in_array($statusPesanan, ['Pesanan Selesai', 'Selesai', 'Pesanan Diterima', 'Barang Diterima', 'Diterima']))
                                        <span style="color: #059669;">Barang Diterima</span>
                                    @elseif($statusPesanan === 'Dibatalkan' || $trx->StatusPembayaran === 'Dibatalkan' || $trx->StatusPembayaran === 'Ditolak')
                                        <span style="color: #dc2626;">Batal</span>
                                    @elseif($klasterStatus === 'unpaid')
                                        <span>Menunggu Pembayaran</span>
                                    @else
                                        <span style="color: #0284c7;">{{ $statusPesanan ?: 'Diproses' }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        
                        {{-- 6. Lampiran --}}
                        <td style="padding: 16px 20px; text-align: center; border-bottom: 1px solid #f1f5f9;">
                            @if($trx->BuktiTransfer)
                                <button type="button" onclick="bukaModalBukti('{{ asset('storage/' . $trx->BuktiTransfer) }}', '{{ $trx->idPembayaran }}')" style="background: #ffffff; color: #475569; border: 1px solid #cbd5e1; padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 0.75rem; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'; this.style.borderColor='#94a3b8';" onmouseout="this.style.background='#ffffff'; this.style.borderColor='#cbd5e1';">
                                    <i class="fas fa-image" style="color: #3b82f6;"></i> Bukti
                                </button>
                            @else
                                <span style="color: #cbd5e1; font-style: italic; font-size: 0.75rem;">Kosong</span>
                            @endif
                        </td>
                        
                        {{-- 7. Aksi Kendali  --}}
                        <td style="padding: 16px 20px; text-align: center; border-bottom: 1px solid #f1f5f9; min-width: 140px;">
                            <div style="display: flex; flex-direction: column; gap: 8px; align-items: center; justify-content: center; width: 100%;">
                                
                                @if($klasterStatus === 'unpaid')
                                    <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 500; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fas fa-clock"></i> Belum Bayar
                                    </span>

                                @elseif($klasterStatus === 'pending')
                                    <div style="display: flex; gap: 6px; justify-content: center;">
                                        <form action="{{ route('admin.transaksi.verifikasi', $trx->idPembayaran) }}" method="POST" onsubmit="return confirm('Setujui pembayaran ini?')" style="margin:0;">
                                            @csrf
                                            <button type="submit" style="background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.7rem; cursor: pointer; transition: background 0.2s; box-shadow: 0 2px 4px rgba(16,185,129,0.2);" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">
                                                Terima
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.transaksi.tolak', $trx->idPembayaran) }}" method="POST" onsubmit="return confirm('Tolak pembayaran ini?')" style="margin:0;">
                                            @csrf
                                            <button type="submit" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.7rem; cursor: pointer; transition: background 0.2s; box-shadow: 0 2px 4px rgba(239,68,68,0.2);" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>

                                @elseif($klasterStatus === 'escrow')
                                    @php $rekPembeli = optional($trx->penawaran->permintaan->user->rekening); @endphp
                                    <span style="color: #0284c7; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; gap: 4px; background: #e0f2fe; padding: 4px 10px; border-radius: 6px; text-align: center;">
                                        Menunggu Pengiriman
                                    </span>
                                    <button type="button" onclick="bukaModalRefund('{{ route('admin.transaksi.refund', $trx->idPembayaran) }}', '{{ $rekPembeli->NamaBank ?? '' }}', '{{ $rekPembeli->NoRekening ?? '' }}', '{{ $rekPembeli->AtasNama ?? '' }}')" style="background: none; border: none; color: #ef4444; font-weight: 700; text-decoration: underline; font-size: 0.75rem; cursor: pointer; padding: 0; text-align: center; width: 100%;">
                                        Refund Dana
                                    </button>

                                @elseif($klasterStatus === 'ready')
                                    @php $rek = optional($trx->penawaran->petani->rekening); @endphp
                                    <button type="button" onclick="bukaModalCairkan('{{ route('admin.transaksi.cairkan', $trx->idPembayaran) }}', '{{ $rek->NamaBank ?? '' }}', '{{ $rek->NoRekening ?? '' }}', '{{ $rek->AtasNama ?? '' }}')" style="background: #3b82f6; color: white; border: none; padding: 6px 14px; border-radius: 6px; font-weight: 700; font-size: 0.75rem; cursor: pointer; box-shadow: 0 2px 4px rgba(59,130,246,0.25); transition: background 0.2s; text-align: center;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                                        Cairkan Ke Petani
                                    </button>

                                @elseif($klasterStatus === 'done')
                                    @if($trx->StatusPembayaran === 'Ditolak' || $trx->StatusPembayaran === 'Dibatalkan' || $statusPesanan === 'Dibatalkan')
                                        <span style="color: #991b1b; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; background: #fef2f2; padding: 4px 10px; border-radius: 6px;">
                                            <i class="fas fa-ban"></i> Dibatalkan
                                        </span>
                                    @else
                                        <span style="color: #166534; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; background: #f0fdf4; padding: 4px 10px; border-radius: 6px;">
                                            <i class="fas fa-check-double"></i> Dana Dicairkan
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 60px 20px; text-align: center; color: #94a3b8;">
                            <i class="fas fa-folder-open" style="font-size: 2.5rem; color: #e2e8f0; margin-bottom: 12px; display: block;"></i>
                            <div style="font-size: 0.9rem; font-weight: 500;">Belum Ada Transaksi yang Masuk.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>

    {{-- KONTEN 2: TAB DAFTAR AKUN PENGGUNA --}}
    <div id="tabAkun" class="admin-tab-content" style="display: none;">
        <div style="background: white; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); overflow: hidden;">
            <div style="padding: 12px 16px; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                <h3 style="margin: 0; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.025em; color: #475569;">
                    <i class="fas fa-users-cog" style="color: #64748b;"></i> Data 5 Pengguna Paling Baru Terdaftar
                </h3>
            </div>
            <div style="overflow-x: auto;">
                  <table style="width: 100%; border-collapse: separate; border-spacing: 0; text-align: left; font-size: 0.85rem;">
                      <thead>
                          <tr style="background: #f8fafc; color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.5px;">
                              <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0; border-top-left-radius: 8px;">Nama Akun / Username</th>
                              <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0;">Alamat Email</th>
                              <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0; text-align: center;">Tingkat Hak Akses</th>
                              <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0; border-top-right-radius: 8px; text-align: center;">Tanggal Registrasi</th>
                          </tr>
                      </thead>
                      <tbody style="color: #334155;">
                          @foreach($semuaAkun as $akun)
                          <tr style="transition: all 0.2s ease; border-bottom: 1px solid #f1f5f9;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.transform='translateY(-1px)';" onmouseout="this.style.backgroundColor='transparent'; this.style.transform='none';">
                              <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9;">
                                  <div style="font-weight: 700; color: #0f172a; font-size: 0.85rem;">{{ $akun->username }}</div>
                              </td>
                              <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; color: #64748b;">
                                  <i class="fas fa-envelope" style="color: #cbd5e1; margin-right: 4px;"></i> {{ $akun->email }}
                              </td>
                              <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                  @if($akun->role === 'admin')
                                      <span style="background: #fff7ed; color: #c2410c; padding: 4px 10px; border-radius: 9999px; font-weight: 600; font-size: 0.7rem; border: 1px solid #ffedd5; display: inline-block;">Sistem Admin</span>
                                  @elseif($akun->role === 'petani')
                                      <span style="background: #ecfdf5; color: #047857; padding: 4px 10px; border-radius: 9999px; font-weight: 600; font-size: 0.7rem; border: 1px solid #d1fae5; display: inline-block;">Mitra Petani</span>
                                  @else
                                      <span style="background: #e0f2fe; color: #0284c7; padding: 4px 10px; border-radius: 9999px; font-weight: 600; font-size: 0.7rem; border: 1px solid #bae6fd; display: inline-block;">Akun Pembeli</span>
                                  @endif
                              </td>
                              <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; text-align: center; color: #64748b; font-size: 0.75rem; font-weight: 500;">
                                  {{ $akun->created_at->format('d M Y') }}
                              </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL BUKTI TRANSFER PREMIUM DESIGN (BACKDROP BLUR) --}}
<div id="modalBuktiAdmin" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 16px; border-radius: 8px; max-width: 380px; width: 90%; text-align: center; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
            <h4 style="margin: 0; color: #0f172a; font-size: 0.85rem; font-weight: 700;">Validasi Bukti Pembayaran</h4>
            <button onclick="document.getElementById('modalBuktiAdmin').style.display='none'" style="background: none; border: none; font-size: 1.1rem; color: #94a3b8; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        
        <img id="imgModalTarget" src="" style="max-width: 100%; max-height: 280px; object-fit: contain; border-radius: 6px; border: 1px solid #cbd5e1; margin-bottom: 15px; background: #f8fafc; padding: 4px;">
        
        <div style="display: flex; gap: 6px; justify-content: flex-end;">
            <button onclick="document.getElementById('modalBuktiAdmin').style.display='none'" style="background: white; color: #475569; border: 1px solid #cbd5e1; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.75rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">Batal</button>
            <form id="formVerifikasiTarget" action="" method="POST" style="margin:0;">
                @csrf
                <button type="submit" style="background: #10b981; color: white; border: none; padding: 6px 14px; border-radius: 6px; font-weight: 600; font-size: 0.75rem; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">Sah, Setujui Lunas</button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL CAIRKAN DANA KE PETANI --}}
<div id="modalCairkanAdmin" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 20px; border-radius: 8px; max-width: 400px; width: 90%; text-align: left; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
            <h4 style="margin: 0; color: #0f172a; font-size: 1rem; font-weight: 700;">Konfirmasi Pencairan Dana</h4>
            <button onclick="document.getElementById('modalCairkanAdmin').style.display='none'" style="background: none; border: none; font-size: 1.2rem; color: #94a3b8; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        
        <p style="font-size: 0.85rem; color: #64748b; margin-top: 0; margin-bottom: 15px;">Silakan transfer dana ke rekening petani berikut, lalu klik tombol konfirmasi jika sudah berhasil.</p>
        
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
            <div style="margin-bottom: 10px;">
                <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Nama Bank / E-Wallet</div>
                <div id="cairkanBank" style="font-size: 0.95rem; font-weight: 700; color: #0f172a;">-</div>
            </div>
            <div style="margin-bottom: 10px;">
                <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Nomor Rekening</div>
                <div id="cairkanNoRek" style="font-size: 1.1rem; font-weight: 800; color: #0f172a; letter-spacing: 1px;">-</div>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Atas Nama</div>
                <div id="cairkanPemilik" style="font-size: 0.95rem; font-weight: 700; color: #0f172a;">-</div>
            </div>
        </div>

        <div style="display: flex; gap: 8px; justify-content: flex-end;">
            <button type="button" onclick="document.getElementById('modalCairkanAdmin').style.display='none'" style="background: white; color: #475569; border: 1px solid #cbd5e1; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; cursor: pointer;">Batal</button>
            <form id="formCairkanTarget" action="" method="POST" style="margin:0;">
                @csrf
                <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">Ya, Dana Telah Ditransfer</button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL REFUND DANA KE PEMBELI --}}
<div id="modalRefundAdmin" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 20px; border-radius: 8px; max-width: 400px; width: 90%; text-align: left; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
            <h4 style="margin: 0; color: #0f172a; font-size: 1rem; font-weight: 700;">Konfirmasi Refund Dana Pembeli</h4>
            <button onclick="document.getElementById('modalRefundAdmin').style.display='none'" style="background: none; border: none; font-size: 1.2rem; color: #94a3b8; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        
        <p style="font-size: 0.85rem; color: #64748b; margin-top: 0; margin-bottom: 15px;">Silakan transfer pengembalian dana (refund) ke rekening pembeli berikut, lalu klik tombol konfirmasi di bawah ini jika sudah berhasil.</p>
        
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
            <div style="margin-bottom: 10px;">
                <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Nama Bank / E-Wallet</div>
                <div id="refundBank" style="font-size: 0.95rem; font-weight: 700; color: #0f172a;">-</div>
            </div>
            <div style="margin-bottom: 10px;">
                <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Nomor Rekening</div>
                <div id="refundNoRek" style="font-size: 1.1rem; font-weight: 800; color: #0f172a; letter-spacing: 1px;">-</div>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Atas Nama</div>
                <div id="refundPemilik" style="font-size: 0.95rem; font-weight: 700; color: #0f172a;">-</div>
            </div>
        </div>

        <div style="display: flex; gap: 8px; justify-content: flex-end;">
            <button type="button" onclick="document.getElementById('modalRefundAdmin').style.display='none'" style="background: white; color: #475569; border: 1px solid #cbd5e1; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; cursor: pointer;">Batal</button>
            <form id="formRefundTarget" action="" method="POST" style="margin:0;">
                @csrf
                <button type="submit" style="background: #ef4444; color: white; border: none; padding: 8px 14px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">Refund Telah Dilakukan</button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL & TABS INLINE OVERRIDE STYLING --}}
<style>
    .tab-btn { background: none; border: none; padding: 8px 14px; font-size: 0.78rem; font-weight: 600; color: #64748b; cursor: pointer; border-bottom: 2px solid transparent; transition: all 0.2s; display: inline-flex; align-items: center; }
    .tab-btn:hover { color: #0f172a; }
    .active-tab { color: #3b82f6; border-bottom: 2px solid #3b82f6; font-weight: 700; }
</style>

{{-- CORE DASHBOARD CONTROL JAVASCRIPT --}}
<script>
    function openAdminTab(evt, tabName) {
        let i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("admin-tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tab-btn");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active-tab", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active-tab";
    }

    function bukaModalBukti(urlGambar, urlAksiForm) {
        document.getElementById('imgModalTarget').src = urlGambar;
        document.getElementById('formVerifikasiTarget').action = urlAksiForm;
        document.getElementById('modalBuktiAdmin').style.display = 'flex';
    }

    function bukaModalCairkan(urlAksiForm, bank, norek, pemilik) {
        document.getElementById('cairkanBank').innerText = bank || 'Belum diatur';
        document.getElementById('cairkanNoRek').innerText = norek || 'Belum diatur';
        document.getElementById('cairkanPemilik').innerText = pemilik || 'Belum diatur';
        document.getElementById('formCairkanTarget').action = urlAksiForm;
        document.getElementById('modalCairkanAdmin').style.display = 'flex';
    }

    function bukaModalRefund(urlAksiForm, bank, norek, pemilik) {
        document.getElementById('refundBank').innerText = bank || 'Belum diatur';
        document.getElementById('refundNoRek').innerText = norek || 'Belum diatur';
        document.getElementById('refundPemilik').innerText = pemilik || 'Belum diatur';
        document.getElementById('formRefundTarget').action = urlAksiForm;
        document.getElementById('modalRefundAdmin').style.display = 'flex';
    }
</script>
@endsection