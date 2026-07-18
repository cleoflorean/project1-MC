@extends('layouts.admin')

@section('title', 'Pusat Kelola Transaksi')
@section('header_title', 'Kelola & Verifikasi Pembayaran')

@section('content')
<div style="font-family: 'Inter', sans-serif; max-width: 1200px; margin: 0 auto; color: #1e293b;">
    
    {{-- BAR ATAS: JUDUL UTAMA --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
        <div>
            <h2 style="margin: 0; font-size: 1.15rem; font-weight: 800; tracking: -0.025em; color: #0f172a;">Pusat Kelola Transaksi</h2>
            <p style="margin: 2px 0 0 0; color: #64748b; font-size: 0.75rem;">Verifikasi bukti pembayaran, pantau status pengiriman, dan kelola pencairan dana<p>
        </div>
    </div>

    {{-- NOTIFIKASI SYSTEM --}}
    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 10px 14px; border-radius: 6px; margin-bottom: 15px; font-weight: 500; font-size: 0.75rem; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-check-circle" style="color: #16a34a;"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fff1f2; border: 1px solid #fecdd3; color: #991b1b; padding: 10px 14px; border-radius: 6px; margin-bottom: 15px; font-weight: 500; font-size: 0.75rem; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-exclamation-circle" style="color: #dc2626;"></i> {{ session('error') }}
        </div>
    @endif

    {{-- KONTROL UTAMA: FILTER & PENCARIAN --}}
    <div style="background: white; padding: 12px 16px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 15px; display: flex; gap: 12px; align-items: center; justify-content: space-between; flex-wrap: wrap;">
        
        <div style="display: flex; gap: 10px; flex-grow: 1; align-items: center; flex-wrap: wrap;">
            {{-- SEARCH BAR COMPACT --}}
            <div style="position: relative; width: 260px; max-width: 100%;">
                <span style="position: absolute; left: 10px; top: 7px; color: #94a3b8; font-size: 0.75rem;"><i class="fas fa-search"></i></span>
                <input type="text" id="cariInput" onkeyup="jalankanSmartFilter()" placeholder="Cari nama pembeli atau komoditas..." style="width: 100%; padding: 6px 10px 6px 30px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.75rem; outline: none; color: #334155; transition: all 0.2s;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 2px rgba(59,130,246,0.1)'" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'">
            </div>

            {{-- DROPDOWN FILTER --}}
            <div style="position: relative; width: 200px;">
                <span style="position: absolute; left: 10px; top: 7px; color: #64748b; font-size: 0.75rem; pointer-events: none;"><i class="fas fa-filter"></i></span>
                <select id="filterStatusSelect" onchange="jalankanSmartFilter()" style="width: 100%; padding: 6px 28px 6px 28px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.75rem; outline: none; color: #334155; appearance: none; background: white; cursor: pointer; font-weight: 500; transition: all 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#cbd5e1'">
                    <option value="all">Semua Status Transaksi</option>
                    <option value="unpaid">Belum Bayar</option>
                    <option value="pending">Perlu Verifikasi Admin</option>
                    <option value="escrow">Dikirim </option>
                    <option value="ready">Barang Diterima</option>
                    <option value="done">Transaksi Selesai / di Tolak</option>
                </select>
                <span style="position: absolute; right: 10px; top: 8px; color: #94a3b8; pointer-events: none; font-size: 0.65rem;"><i class="fas fa-chevron-down"></i></span>
            </div>
        </div>

        <div style="font-size: 0.7rem; color: #64748b; font-weight: 500;">
            Total: <span id="CounterData" style="color: #0f172a; font-weight: 700;">{{ count($semuaTransaksi ?? []) }}</span> data ditemukan
        </div>
    </div>

    {{-- TABEL UTAMA --}}
    <div style="background: white; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0; text-align: left; font-size: 0.85rem;">
                <thead>
                    <tr style="background: #f8fafc; color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.5px;">
                        <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0; border-top-left-radius: 8px;">Transaksi</th>
                        <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0;">Pembeli & Komoditas</th>
                        <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0;">Status Info</th>
                        <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0; text-align: center;">Lampiran</th>
                        <th style="padding: 16px 20px; border-bottom: 2px solid #e2e8f0; border-top-right-radius: 8px; text-align: right;">Aksi Kendali</th>
                    </tr>
                </thead>
                <tbody id="transaksiTableBody" style="color: #334155;">
                    @forelse($semuaTransaksi ?? [] as $trx)
                    
                    @php
                        $statusPesanan = trim(optional($trx->pengiriman)->StatusPesanan);
                        $klasterStatus = 'unknown';
                        
                        if ($trx->StatusPembayaran === 'Belum Bayar' || $trx->StatusPembayaran === 'Menunggu Pembayaran' || empty($trx->BuktiTransfer)) {
                            $klasterStatus = 'unpaid';
                        } elseif ($trx->StatusPembayaran === 'Menunggu Verifikasi Admin' || $trx->StatusPembayaran === 'Menunggu Verifikasi') {
                            $klasterStatus = 'pending';
                        } elseif ($statusPesanan === 'Pesanan Selesai' || $trx->StatusPembayaran === 'Ditolak' || $trx->StatusPembayaran === 'Dibatalkan' || $statusPesanan === 'Dibatalkan') {
                            $klasterStatus = 'done';
                        } elseif ($trx->StatusPembayaran === 'Lunas' && in_array($statusPesanan, ['Selesai', 'Pesanan Diterima', 'Barang Diterima', 'Diterima'])) {
                            $klasterStatus = 'ready';
                        } elseif ($trx->StatusPembayaran === 'Lunas') {
                            $klasterStatus = 'escrow';
                        }
                    @endphp

                    <tr class="trx-row" data-status="{{ $klasterStatus }}" style="transition: all 0.2s ease; border-bottom: 1px solid #f1f5f9;" onmouseover="this.style.backgroundColor='#f8fafc'; this.style.transform='translateY(-1px)';" onmouseout="this.style.backgroundColor='transparent'; this.style.transform='none';">
                        
                        {{-- 1. Transaksi Info --}}
                        <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9;">
                            <div style="font-weight: 800; color: #0f172a; font-size: 0.9rem; margin-bottom: 4px;">Rp {{ number_format($trx->TotalBayar, 0, ',', '.') }}</div>
                            <div style="color: #94a3b8; font-size: 0.75rem;"><span style="color:#64748b; font-weight: 600;">#{{ $trx->idPembayaran }}</span> &bull; {{ $trx->created_at ? $trx->created_at->format('d M Y') : '-' }}</div>
                        </td>
                        
                        {{-- 2. Pembeli & Komoditas --}}
                        <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9;" class="searchable-cell">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem;">
                                    {{ strtoupper(substr($trx->penawaran->permintaan->user->username ?? 'G', 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: #1e293b; font-size: 0.85rem;">{{ $trx->penawaran->permintaan->user->username ?? 'Guest' }}</div>
                                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">
                                        <i class="fas fa-box" style="color: #cbd5e1; font-size: 0.7rem; margin-right: 3px;"></i> {{ $trx->penawaran->permintaan->Komoditas ?? 'Komoditas' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                        {{-- 3. Status Info --}}
                        <td style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9;">
                            <div style="display: flex; flex-direction: column; gap: 6px;">
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
                                <div style="font-size: 0.7rem; font-weight: 600; color: #64748b; margin-left: 2px;">
                                    <i class="fas fa-truck" style="margin-right: 4px; color: #cbd5e1;"></i> 
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
                        
                        {{-- 4. Lampiran --}}
                        <td style="padding: 16px 20px; text-align: center; border-bottom: 1px solid #f1f5f9;">
                            @if($trx->BuktiTransfer)
                                <button type="button" onclick="bukaModalBukti('{{ asset('storage/' . $trx->BuktiTransfer) }}', '{{ $trx->idPembayaran }}')" style="background: #ffffff; color: #475569; border: 1px solid #cbd5e1; padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 0.75rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'; this.style.borderColor='#94a3b8';" onmouseout="this.style.background='#ffffff'; this.style.borderColor='#cbd5e1';">
                                    <i class="fas fa-image" style="color: #3b82f6;"></i> Bukti
                                </button>
                            @else
                                <span style="color: #cbd5e1; font-style: italic; font-size: 0.75rem;">Kosong</span>
                            @endif
                        </td>
                        
                        {{-- 5. Aksi Kendali --}}
                        <td style="padding: 16px 20px; text-align: right; border-bottom: 1px solid #f1f5f9;">
                            <div style="display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                                
                                @if($klasterStatus === 'unpaid')
                                    <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 500; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fas fa-clock"></i> Belum Bayar
                                    </span>

                                @elseif($klasterStatus === 'pending')
                                    <div style="display: flex; gap: 6px;">
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
                                    <span style="color: #0284c7; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; background: #e0f2fe; padding: 4px 10px; border-radius: 6px;">
                                        Menunggu Pengiriman
                                    </span>
                                    <form action="{{ route('admin.transaksi.refund', $trx->idPembayaran) }}" method="POST" onsubmit="return confirm('Yakin ingin Refund dana ke Pembeli?')" style="margin:0;">
                                        @csrf
                                        <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: 700; text-decoration: underline; font-size: 0.75rem; cursor: pointer; padding: 0;">
                                            Refund Dana
                                        </button>
                                    </form>

                                @elseif($klasterStatus === 'ready')
                                    @php $rek = optional($trx->penawaran->petani->rekening); @endphp
                                    <button type="button" onclick="bukaModalCairkan('{{ route('admin.transaksi.cairkan', $trx->idPembayaran) }}', '{{ $rek->NamaBank ?? '' }}', '{{ $rek->NoRekening ?? '' }}', '{{ $rek->AtasNama ?? '' }}')" style="background: #3b82f6; color: white; border: none; padding: 6px 14px; border-radius: 6px; font-weight: 700; font-size: 0.75rem; cursor: pointer; box-shadow: 0 2px 4px rgba(59,130,246,0.25); transition: background 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
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
                            <div style="font-size: 0.9rem; font-weight: 500;">Tidak ditemukan data transaksi.</div>
                            <div style="font-size: 0.75rem; margin-top: 4px;">Coba ubah filter pencarian Anda.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL PREVIEW BUKTI TRANSFER --}}
<div id="modalBuktiAdmin" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 16px; border-radius: 8px; max-width: 380px; width: 90%; text-align: center; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
            <h4 style="margin: 0; color: #0f172a; font-size: 0.85rem; font-weight: 700;">Arsip Dokumen Bukti <span id="textIdTrx" style="color: #64748b; font-weight: 500;"></span></h4>
            <button onclick="document.getElementById('modalBuktiAdmin').style.display='none'" style="background: none; border: none; font-size: 1.1rem; color: #94a3b8; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        <img id="imgModalTarget" src="" style="max-width: 100%; max-height: 300px; object-fit: contain; border-radius: 6px; border: 1px solid #cbd5e1; margin-bottom: 12px; background: #f8fafc; padding: 4px;">
        <button onclick="document.getElementById('modalBuktiAdmin').style.display='none'" style="background: #0f172a; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.75rem; cursor: pointer; width: 100%; transition: background 0.2s;" onmouseover="this.style.background='#1e293b'" onmouseout="this.style.background='#0f172a'">Tutup Jendela</button>
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

{{-- JAVASCRIPT: SMART FILTER CONTROLLER --}}
<script>
    function jalankanSmartFilter() {
        let selectedStatus = document.getElementById('filterStatusSelect').value;
        let searchKeyword = document.getElementById('cariInput').value.toLowerCase();
        let rows = document.querySelectorAll('.trx-row');
        let counter = 0;

        rows.forEach(row => {
            let rowStatus = row.getAttribute('data-status');
            let searchableText = row.querySelector('.searchable-cell').innerText.toLowerCase();
            
            let cocokStatus = (selectedStatus === 'all' || rowStatus === selectedStatus);
            let cocokSearch = searchableText.includes(searchKeyword);

            if (cocokStatus && cocokSearch) {
                row.style.display = '';
                counter++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('CounterData').innerText = counter;
    }

    function bukaModalBukti(urlGambar, idTrx) {
        document.getElementById('imgModalTarget').src = urlGambar;
        document.getElementById('textIdTrx').innerText = '#' + idTrx;
        document.getElementById('modalBuktiAdmin').style.display = 'flex';
    }

    function bukaModalCairkan(urlAksiForm, bank, norek, pemilik) {
        document.getElementById('cairkanBank').innerText = bank || 'Belum diatur';
        document.getElementById('cairkanNoRek').innerText = norek || 'Belum diatur';
        document.getElementById('cairkanPemilik').innerText = pemilik || 'Belum diatur';
        document.getElementById('formCairkanTarget').action = urlAksiForm;
        document.getElementById('modalCairkanAdmin').style.display = 'flex';
    }
</script>
@endsection