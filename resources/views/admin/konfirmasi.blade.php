@extends('layouts.admin')

@section('title', 'Konfirmasi Pembayaran')
@section('header_title', 'Verifikasi Pembayaran')

@section('content')
<div style="font-family: 'Inter', sans-serif;">
    
    {{-- SUB-TITLE UTAMA --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h2 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: #1e293b;">💳 Menunggu Konfirmasi</h2>
            <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.85rem;">Validasi bukti transfer pembeli sebelum dana masuk ke sistem (Escrow)</p>
        </div>
        <span style="background: white; padding: 6px 14px; border-radius: 30px; font-weight: 600; font-size: 0.75rem; color: #e65100; border: 1px solid #ffe0b2; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            Tugas Prioritas
        </span>
    </div>

    {{-- ALERT NOTIFIKASI --}}
    @if(session('success'))
        <div style="background: #e8f5e9; border-left: 4px solid #2e7d32; color: #1b5e20; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; font-weight: 500; font-size: 0.85rem;">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #ffebee; border-left: 4px solid #c62828; color: #b71c1c; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; font-weight: 500; font-size: 0.85rem;">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    {{-- TABEL KONFIRMASI PEMBAYARAN --}}
    <div style="background: white; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); overflow: hidden;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #e2e8f0; background: #fafafa; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #1e293b;"><i class="fas fa-file-invoice-dollar me-2"></i> Daftar Antrean Verifikasi</h3>
        </div>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem;">
                <thead>
                    <tr style="background: #f8fafc; color: #475569; font-weight: 700; border-bottom: 1px solid #e2e8f0;">
                        <th style="padding: 12px 20px;">ID Transaksi</th>
                        <th style="padding: 12px 20px;">Info Pembeli</th>
                        <th style="padding: 12px 20px;">Total Transfer</th>
                        <th style="padding: 12px 20px;">Tanggal Bayar</th>
                        <th style="padding: 12px 20px; text-align: center;">Bukti Transfer</th>
                        <th style="padding: 12px 20px; text-align: center;">Tindakan Admin</th>
                    </tr>
                </thead>
                <tbody style="color: #334155;">
                    {{-- Ganti $transaksiPending dengan variabel dari controller Anda --}}
                    @forelse($transaksiPending ?? [] as $trx)
                    <tr style="border-bottom: 1px solid #f1f5f9;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                        <td style="padding: 12px 20px;">
                            <span style="font-weight: 700; color: #1e293b; display: block;">#{{ $trx->idPembayaran }}</span>
                            <small style="color: #64748b;">{{ $trx->penawaran->Komoditas ?? 'Komoditas' }}</small>
                        </td>
                        <td style="padding: 12px 20px;">
                            <div style="font-weight: 600; color: #1e293b;">{{ $trx->penawaran->permintaan->user->username ?? 'Nama Pembeli' }}</div>
                            <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">{{ $trx->penawaran->permintaan->user->email ?? 'email@pembeli.com' }}</div>
                        </td>
                        <td style="padding: 12px 20px; font-weight: 700; color: #1e293b;">
                            Rp {{ number_format($trx->TotalBayar, 0, ',', '.') }}
                        </td>
                        <td style="padding: 12px 20px;">
                            {{ $trx->created_at ? $trx->created_at->format('d M Y, H:i') : '-' }}
                        </td>
                        <td style="padding: 12px 20px; text-align: center;">
                            <button type="button" onclick="bukaModalBukti('{{ asset('storage/' . $trx->BuktiTransfer) }}', '{{ $trx->idPembayaran }}')" style="background: #e3f2fd; color: #1565c0; border: 1px solid #bbdefb; padding: 4px 10px; border-radius: 4px; font-weight: 600; font-size: 0.75rem; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#bbdefb'" onmouseout="this.style.background='#e3f2fd'">
                                <i class="fas fa-eye me-1"></i> Lihat Bukti
                            </button>
                        </td>
                        <td style="padding: 12px 20px; text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center;">
                                {{-- Tombol Setujui --}}
                                <form action="{{ route('admin.transaksi.verifikasi', $trx->idPembayaran) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin dana sudah masuk ke rekening sistem?')">
                                    @csrf
                                    <button type="submit" style="background: #2e7d32; color: white; border: none; padding: 5px 10px; border-radius: 4px; font-weight: 600; font-size: 0.75rem; cursor: pointer;" title="Setujui Pembayaran">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                {{-- Tombol Tolak --}}
                                <form action="{{ route('admin.transaksi.tolak', $trx->idPembayaran) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak pembayaran ini?')">
                                    @csrf
                                    <button type="submit" style="background: #c62828; color: white; border: none; padding: 5px 10px; border-radius: 4px; font-weight: 600; font-size: 0.75rem; cursor: pointer;" title="Tolak Pembayaran">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 40px 20px; text-align: center; color: #94a3b8;">
                            <i class="fas fa-check-circle" style="font-size: 2rem; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                            Tidak ada pembayaran yang menunggu konfirmasi saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL BUKTI TRANSFER KHUSUS KONFIRMASI --}}
<div id="modalBuktiAdmin" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.75); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 20px; border-radius: 10px; max-width: 450px; width: 90%; text-align: center; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
            <h4 style="margin: 0; color: #1e293b; font-size: 1rem; font-weight: 700;">Bukti Transfer <span id="textIdTrx" style="color: #64748b;"></span></h4>
            <button onclick="document.getElementById('modalBuktiAdmin').style.display='none'" style="background: none; border: none; font-size: 1.2rem; color: #94a3b8; cursor: pointer;">&times;</button>
        </div>
        
        <img id="imgModalTarget" src="" style="max-width: 100%; max-height: 350px; object-fit: contain; border-radius: 6px; border: 1px solid #e2e8f0; margin-bottom: 15px; background: #f8fafc;">
        
        <div style="display: flex; gap: 8px; justify-content: center;">
            <button onclick="document.getElementById('modalBuktiAdmin').style.display='none'" style="background: #e2e8f0; color: #334155; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; cursor: pointer; width: 100%;">Tutup Jendela</button>
        </div>
    </div>
</div>

<script>
    function bukaModalBukti(urlGambar, idTrx) {
        // Set gambar ke dalam modal
        document.getElementById('imgModalTarget').src = urlGambar;
        // Set teks ID Transaksi di judul modal
        document.getElementById('textIdTrx').innerText = '#' + idTrx;
        // Tampilkan modal
        document.getElementById('modalBuktiAdmin').style.display = 'flex';
    }
</script>
@endsection