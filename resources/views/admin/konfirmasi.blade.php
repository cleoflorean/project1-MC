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
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.75rem;">
                <thead>
                    <tr style="background: #f8fafc; color: #475569; font-weight: 600; border-bottom: 1px solid #e2e8f0; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 0.05em;">
                        <th style="padding: 10px 14px;">Detail Pembeli & Barang</th>
                        <th style="padding: 10px 14px; text-align: center;">Nominal & Waktu</th>
                        <th style="padding: 10px 14px; text-align: center;">Status Finansial</th>
                        <th style="padding: 10px 14px; text-align: center;">Status Logistik</th>
                        <th style="padding: 10px 14px; text-align: center;">Lampiran</th>
                        <th style="padding: 10px 14px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="transaksiTableBody" style="color: #334155;">
                    @forelse($semuaTransaksi ?? [] as $trx)
                    
                    {{-- Penentuan Klaster Status --}}
                    @php
                        $klasterStatus = 'done';
                        if ($trx->StatusPembayaran === 'Belum Bayar' || $trx->StatusPembayaran === 'Menunggu Pembayaran' || empty($trx->BuktiTransfer)) {
                            $klasterStatus = 'unpaid';
                        } elseif ($trx->StatusPembayaran === 'Menunggu Verifikasi Admin' || $trx->StatusPembayaran === 'Menunggu Verifikasi') {
                            $klasterStatus = 'pending';
                        } elseif ($trx->StatusPembayaran === 'Lunas' && !in_array($trx->StatusPesanan, ['Pesanan Selesai', 'Pesanan Diterima', 'Barang Diterima', 'Diterima', 'Dibatalkan'])) {
                            $klasterStatus = 'escrow';
                        } elseif ($trx->StatusPembayaran === 'Lunas' && in_array($trx->StatusPesanan, ['Pesanan Selesai', 'Pesanan Diterima', 'Barang Diterima', 'Diterima'])) {
                            $klasterStatus = 'ready';
                        }
                    @endphp

                    <tr class="trx-row" data-status="{{ $klasterStatus }}" style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                        
                        {{-- 1. INFO PEMBELI & KOMODITAS (TETAP RATA KIRI) --}}
                        <td style="padding: 10px 14px;" class="searchable-cell">
                            <div style="font-weight: 700; color: #0f172a; font-size: 0.78rem;">{{ $trx->penawaran->permintaan->user->username ?? 'Nama Pembeli' }}</div>
                            <div style="font-size: 0.68rem; color: #64748b; margin-top: 1px;">
                                {{ $trx->penawaran->Komoditas ?? 'Komoditas' }}
                            </div>
                        </td>
                        
                        {{-- 2. TOTAL TRANSFER & WAKTU (UBAH KE CENTER) --}}
                        <td style="padding: 10px 14px; text-align: center;">
                            <div style="font-weight: 700; color: #0f172a;">Rp {{ number_format($trx->TotalBayar, 0, ',', '.') }}</div>
                            <div style="font-size: 0.65rem; color: #94a3b8; margin-top: 1px;">{{ $trx->created_at ? $trx->created_at->format('d M Y, H:i') : '-' }}</div>
                        </td>

                        {{-- 3. STATUS PEMBAYARAN BUBBLE (UBAH KE CENTER) --}}
                        <td style="padding: 10px 14px; text-align: center;">
                            @if($klasterStatus === 'unpaid')
                                <span style="background: #f8fafc; color: #64748b; padding: 2px 6px; border-radius: 4px; font-weight: 600; font-size: 0.65rem; border: 1px solid #e2e8f0;">Belum Bayar</span>
                            @elseif($klasterStatus === 'pending')
                                <span style="background: #fff7ed; color: #c2410c; padding: 2px 6px; border-radius: 4px; font-weight: 600; font-size: 0.65rem; border: 1px solid #ffedd5;">Belum Verifikasi</span>
                            @elseif($klasterStatus === 'escrow' || $klasterStatus === 'ready')
                                <span style="background: #ecfdf5; color: #047857; padding: 2px 6px; border-radius: 4px; font-weight: 600; font-size: 0.65rem; border: 1px solid #d1fae5;">Dana Diterima</span>
                            @elseif($trx->StatusPesanan === 'Pesanan Selesai')
                                <span style="background: #f0fdf4; color: #166534; padding: 2px 6px; border-radius: 4px; font-weight: 500; font-size: 0.65rem; border: 1px solid #bbf7d0;">Ditransfer ke Petani</span>
                            @else
                                <span style="background: #fff1f2; color: #991b1b; padding: 2px 6px; border-radius: 4px; font-weight: 500; font-size: 0.65rem; border: 1px solid #fecdd3;">Dibatalkan</span>
                            @endif
                        </td>

                        {{-- 4. STATUS LOGISTIK (UBAH KE CENTER) --}}
                        <td style="padding: 10px 14px; text-align: center;">
                            @if(in_array($trx->StatusPesanan, ['Pesanan Selesai', 'Pesanan Diterima', 'Barang Diterima', 'Diterima']))
                                <span style="color: #166534; font-weight: 700; font-size: 0.7rem;">Barang Diterima</span>
                            @elseif($trx->StatusPesanan === 'Dibatalkan')
                                <span style="color: #991b1b; font-weight: 600; font-size: 0.7rem;"> Batal</span>
                            @elseif($klasterStatus === 'unpaid')
                                <span style="color: #64748b; font-weight: 500; font-size: 0.7rem;">Menunggu Pembayaran</span>
                            @else
                                <span style="color: #025487; font-weight: 600; font-size: 0.7rem;">{{ $trx->StatusPesanan ?? 'Proses Kirim' }}</span>
                            @endif
                        </td>

                        {{-- 5. BUKTI TRANSFER BUTTON (TETAP CENTER) --}}
                        <td style="padding: 10px 14px; text-align: center;">
                            @if($trx->BuktiTransfer)
                                <button type="button" onclick="bukaModalBukti('{{ asset('storage/' . $trx->BuktiTransfer) }}', '{{ $trx->idPembayaran }}')" style="background: #f8fafc; color: #475569; border: 1px solid #cbd5e1; padding: 2px 8px; border-radius: 4px; font-weight: 600; font-size: 0.65rem; cursor: pointer; transition: all 0.15s;" onmouseover="this.style.background='#ef4444'; this.style.color='white'; this.style.borderColor='#ef4444'" onmouseout="this.style.background='#f8fafc'; this.style.color='#475569'; this.style.borderColor='#cbd5e1'">
                                    <i class="fas fa-file-image"></i> Bukti Transfer
                                </button>
                            @else
                                <span style="color: #cbd5e1; font-style: italic;">Tidak ada</span>
                            @endif
                        </td>

                        {{-- 6. TINDAKAN ADMIN (TETAP CENTER) --}}
                        <td style="padding: 10px 14px; text-align: center;">
                            <div style="display: flex; gap: 4px; justify-content: center; align-items: center;">
                                
                                {{-- BELUM BAYAR (MENUNGGU TRANSAKSI) --}}
                                @if($klasterStatus === 'unpaid')
                                    <span style="color: #94a3b8; font-size: 0.65rem; font-style: italic;"><i class="fas fa-clock"></i> Menunggu Pembayaran</span>

                                {{-- PERLU VERIFIKASI BUKTI --}}
                                @elseif($klasterStatus === 'pending')
                                    <form action="{{ route('admin.transaksi.verifikasi', $trx->idPembayaran) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin dana kiriman sudah valid masuk ke rekening sistem?')">
                                        @csrf
                                        <button type="submit" style="background: #10b981; color: white; border: none; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 0.65rem; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">
                                            Terima
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.transaksi.tolak', $trx->idPembayaran) }}" method="POST" onsubmit="return confirm('Tolak dan batalkan pembayaran ini?')">
                                        @csrf
                                        <button type="submit" style="background: white; color: #ef4444; border: 1px solid #fca5a5; padding: 3px 8px; border-radius: 4px; font-weight: 600; font-size: 0.65rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='white'">
                                            Tolak
                                        </button>
                                    </form>

                                {{-- BARANG SUDAH DITERIMA (SIAP CAIRKAN) --}}
                                @elseif($klasterStatus === 'ready')
                                    <form action="{{ route('admin.transaksi.cairkan', $trx->idPembayaran) }}" method="POST" onsubmit="return confirm('Kirim dana aman Escrow ke rekening Petani?')">
                                        @csrf
                                        <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 4px 12px; border-radius: 4px; font-weight: 700; font-size: 0.65rem; cursor: pointer; box-shadow: 0 1px 2px rgba(59,130,246,0.2); transition: background 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                                            Cairkan Ke Petani
                                        </button>
                                    </form>

                                {{-- BARANG MASIH DI JALAN --}}
                                @elseif($klasterStatus === 'escrow')
                                    <span style="color: #0284c7; font-size: 0.65rem; font-weight: 600; background: #e0f2fe; padding: 3px 8px; border-radius: 4px; border: 1px solid #bae6fd; display: inline-flex; align-items: center; gap: 4px;">
                                        Dalam Pengiriman
                                    </span>
                                    
                                    <form action="{{ route('admin.transaksi.refund', $trx->idPembayaran) }}" method="POST" onsubmit="return confirm('Refund dana kembali ke pembeli?')">
                                        @csrf
                                        <button type="submit" style="background: transparent; color: #991b1b; border: none; padding: 2px 4px; font-weight: 600; font-size: 0.65rem; cursor: pointer; text-decoration: underline;">
                                            Refund
                                        </button>
                                    </form>

                                {{-- TRANSAKSI SELESAI / DANA SUDAH CAIR --}}
                                @elseif($trx->StatusPesanan === 'Pesanan Selesai')
                                    <span style="color: #166534; font-size: 0.65rem; font-weight: 600; background: #f0fdf4; padding: 3px 8px; border-radius: 4px; border: 1px solid #bbf7d0; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fas fa-check-double" style="font-size: 0.6rem;"></i> Dana Dicairkan
                                    </span>

                                {{-- FALLBACK / TRANSAKSI BATAL --}}
                                @else
                                    <span style="color: #94a3b8; font-size: 0.65rem; font-weight: 500;"><i class="fas fa-ban" style="font-size: 0.6rem;"></i> Selesai</span>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 40px 14px; text-align: center; color: #94a3b8;">
                            <i class="fas fa-folder-open" style="font-size: 1.6rem; color: #cbd5e1; margin-bottom: 6px; display: block;"></i>
                            Tidak ditemukan data transaksi yang sesuai.
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
</script>
@endsection