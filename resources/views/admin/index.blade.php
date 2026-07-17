@extends('layouts.admin')

@section('title', 'Dashboard Administrator')
@section('header_title', 'Control Panel Admin')

@section('content')
<div style="font-family: 'Inter', sans-serif;">
    
    {{-- SUB-TITLE UTAMA --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h2 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: #1e293b;">🛡️ Ringkasan Sistem</h2>
            <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.85rem;">Sistem Pengawasan Transaksi & Kelola Pengguna</p>
        </div>
    </div>

    {{-- ALERT NOTIFIKASI --}}
    @if(session('success'))
        <div style="background: #e8f5e9; border-left: 4px solid #2e7d32; color: #1b5e20; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; font-weight: 500; font-size: 0.85rem;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #ffebee; border-left: 4px solid #c62828; color: #b71c1c; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; font-weight: 500; font-size: 0.85rem;">
            {{ session('error') }}
        </div>
    @endif

    {{-- KARTU STATISTIK (ANGKA UTAMA) --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px;">
        <div style="background: white; padding: 16px; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
            <div style="color: #64748b; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Dana Ditampung (Escrow)</div>
            <div style="font-size: 1.3rem; font-weight: 800; color: #2e7d32; margin-top: 6px;">Rp {{ number_format($totalEscrow, 0, ',', '.') }}</div>
            <small style="color: #94a3b8; display: block; margin-top: 4px; font-size: 0.75rem;">Uang aman di tangan sistem</small>
        </div>
        <div style="background: white; padding: 16px; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
            <div style="color: #64748b; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Perlu Verifikasi Admin</div>
            <div style="font-size: 1.3rem; font-weight: 800; color: #e65100; margin-top: 6px;">{{ $menungguVerifikasi }} Transaksi</div>
            <small style="color: #94a3b8; display: block; margin-top: 4px; font-size: 0.75rem;">Cek bukti transfer pembeli</small>
        </div>
        <div style="background: white; padding: 16px; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
            <div style="color: #64748b; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Total Transaksi Sukses</div>
            <div style="font-size: 1.3rem; font-weight: 800; color: #1565c0; margin-top: 6px;">Rp {{ number_format($totalTransaksiSukses, 0, ',', '.') }}</div>
            <small style="color: #94a3b8; display: block; margin-top: 4px; font-size: 0.75rem;">Dana diteruskan ke petani</small>
        </div>
        <div style="background: white; padding: 16px; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
            <div style="color: #64748b; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Jumlah Mitra Petani</div>
            <div style="font-size: 1.3rem; font-weight: 800; color: #2e7d32; margin-top: 6px;">{{ $jumlahPetani }} Akun</div>
            <small style="color: #94a3b8; display: block; margin-top: 4px; font-size: 0.75rem;">Petani terdaftar di sistem</small>
        </div>
    </div>

    {{-- TAB MENU ADMIN --}}
    <div style="display: flex; gap: 15px; border-bottom: 2px solid #e2e8f0; margin-bottom: 15px;">
        <button class="tab-btn active-tab" onclick="openAdminTab(event, 'tabTransaksi')">Daftar Transaksi (Rekber)</button>
        <button class="tab-btn" onclick="openAdminTab(event, 'tabAkun')">Kelola Akun Pengguna</button>
    </div>

    {{-- 1. KONTEN TAB TRANSAKSI --}}
    <div id="tabTransaksi" class="admin-tab-content" style="display: block;">
        <div style="background: white; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); overflow: hidden;">
            <div style="padding: 15px 20px; border-bottom: 1px solid #e2e8f0; background: #fafafa;">
                <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #1e293b;"><i class="fas fa-exchange-alt"></i> Monitor Aliran Dana Transaksi</h3>
            </div>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem;">
                    <thead>
                        <tr style="background: #f8fafc; color: #475569; font-weight: 700; border-bottom: 1px solid #e2e8f0;">
                            <th style="padding: 12px 20px;">Komoditas</th>
                            <th style="padding: 12px 20px;">Aktor (Pembeli -> Petani)</th>
                            <th style="padding: 12px 20px;">Nominal</th>
                            <th style="padding: 12px 20px;">Status Pembayaran</th>
                            <th style="padding: 12px 20px;">Status Logistik</th>
                            <th style="padding: 12px 20px; text-align: center;">Tombol Kendali Admin</th>
                        </tr>
                    </thead>
                    <tbody style="color: #334155;">
                        @forelse($semuaTransaksi as $trx)
                        <tr style="border-bottom: 1px solid #f1f5f9;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                            <td style="padding: 12px 20px;">
                                <small style="color: #64748b;">{{ $trx->penawaran->Komoditas ?? 'Tanaman' }}</small>
                            </td>
                            <td style="padding: 12px 20px;">
                                <div style="font-weight: 600; color: #1e293b;">🛒 {{ $trx->penawaran->permintaan->user->username ?? 'Unknown' }}</div>
                                <div style="font-size: 0.75rem; color: #2e7d32; margin-top: 2px;">👨‍🌾 {{ $trx->penawaran->petani->username ?? 'Unknown' }}</div>
                            </td>
                            <td style="padding: 12px 20px; font-weight: 700; color: #1e293b;">
                                Rp {{ number_format($trx->TotalBayar, 0, ',', '.') }}
                            </td>
                            <td style="padding: 12px 20px;">
                                @if($trx->StatusPembayaran === 'Menunggu Verifikasi Admin' || $trx->StatusPembayaran === 'Menunggu Verifikasi')
                                    <span style="background: #fff3e0; color: #e65100; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 0.75rem;">Verifikasi Admin</span>
                                @elseif($trx->StatusPembayaran === 'Lunas')
                                    <span style="background: #e8f5e9; color: #2e7d32; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 0.75rem;">Lunas (Escrow)</span>
                                @elseif($trx->StatusPembayaran === 'Ditolak')
                                    <span style="background: #ffebee; color: #c62828; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 0.75rem;">Dibatalkan/Refund</span>
                                @else
                                    <span style="background: #f1f5f9; color: #64748b; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 0.75rem;">{{ $trx->StatusPembayaran }}</span>
                                @endif
                            </td>
                            <td style="padding: 12px 20px; text-align: center;">
    <div style="display: flex; gap: 6px; justify-content: center;">
        
        {{-- Tombol Cek Bukti: Muncul jika Status Pembayaran ATAU Status Pesanan masih meminta verifikasi --}}
        @if($trx->StatusPembayaran === 'Menunggu Verifikasi Admin' || $trx->StatusPembayaran === 'Menunggu Verifikasi' || $trx->StatusPesanan === 'Menunggu Verifikasi Admin')
            <button onclick="bukaModalBukti('{{ asset('storage/' . $trx->BuktiTransfer) }}', '{{ route('admin.transaksi.verifikasi', $trx->idPembayaran) }}')" style="background: #2e7d32; color: white; border: none; padding: 5px 10px; border-radius: 4px; font-weight: 600; font-size: 0.75rem; cursor: pointer;">
                Cek Bukti Transfer
            </button>
        @endif

        {{-- Tombol Kendali Darurat (Refund / Cairkan): Hanya boleh muncul jika benar-benar sudah Lunas DAN tidak sedang dalam status menunggu verifikasi --}}
        @if($trx->StatusPembayaran === 'Lunas' && $trx->StatusPesanan !== 'Pesanan Selesai' && $trx->StatusPesanan !== 'Menunggu Verifikasi Admin')
            <form action="{{ route('admin.transaksi.refund', $trx->idPembayaran) }}" method="POST" onsubmit="return confirm('Yakin ingin Refund dana ke Pembeli?')">
                @csrf
                <button type="submit" style="background: #c62828; color: white; border: none; padding: 5px 10px; border-radius: 4px; font-weight: 600; font-size: 0.75rem; cursor: pointer;">
                    🚨 Refund
                </button>
            </form>
            <form action="{{ route('admin.transaksi.cairkan', $trx->idPembayaran) }}" method="POST" onsubmit="return confirm('Paksa Cairkan dana ke Petani?')">
                @csrf
                <button type="submit" style="background: #1565c0; color: white; border: none; padding: 5px 10px; border-radius: 4px; font-weight: 600; font-size: 0.75rem; cursor: pointer;">
                    💰 Cairkan
                </button>
            </form>
        @endif
        
    </div>
</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="padding: 20px; text-align: center; color: #94a3b8;">Belum ada aktivitas transaksi terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 2. KONTEN TAB DAFTAR AKUN PENGGUNA --}}
    <div id="tabAkun" class="admin-tab-content" style="display: none;">
        <div style="background: white; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); overflow: hidden;">
            <div style="padding: 15px 20px; border-bottom: 1px solid #e2e8f0; background: #fafafa;">
                <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #1e293b;"><i class="fas fa-users"></i> Daftar Semua Pengguna</h3>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem;">
                    <thead>
                        <tr style="background: #f8fafc; color: #475569; font-weight: 700; border-bottom: 1px solid #e2e8f0;">
                            <th style="padding: 12px 20px;">Username</th>
                            <th style="padding: 12px 20px;">Email</th>
                            <th style="padding: 12px 20px;">Role / Peran</th>
                            <th style="padding: 12px 20px;">Tgl Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($semuaAkun as $akun)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 12px 20px; font-weight: 700; color: #1e293b;">{{ $akun->username }}</td>
                            <td style="padding: 12px 20px;">{{ $akun->email }}</td>
                            <td style="padding: 12px 20px;">
                                @if($akun->role === 'admin')
                                    <span style="background: #fff3e0; color: #e65100; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 0.75rem;">Admin</span>
                                @elseif($akun->role === 'petani')
                                    <span style="background: #e8f5e9; color: #2e7d32; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 0.75rem;">Petani</span>
                                @else
                                    <span style="background: #e3f2fd; color: #1565c0; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 0.75rem;">Pembeli</span>
                                @endif
                            </td>
                            <td style="padding: 12px 20px;">{{ $akun->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL BUKTI TRANSFER UNTUK ADMIN --}}
<div id="modalBuktiAdmin" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 20px; border-radius: 10px; max-width: 400px; width: 90%; text-align: center; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <h4 style="margin: 0 0 12px 0; color: #1e293b; font-size: 1.1rem;">Validasi Bukti Pembayaran</h4>
        <img id="imgModalTarget" src="" style="max-width: 100%; max-height: 200px; object-fit: contain; border-radius: 6px; border: 1px solid #e2e8f0; margin-bottom: 15px;">
        
        <div style="display: flex; gap: 8px; justify-content: center;">
            <button onclick="document.getElementById('modalBuktiAdmin').style.display='none'" style="background: #e2e8f0; color: #334155; border: none; padding: 6px 14px; border-radius: 4px; font-weight: 600; font-size: 0.85rem; cursor: pointer;">Tutup</button>
            <form id="formVerifikasiTarget" action="" method="POST" style="margin:0;">
                @csrf
                <button type="submit" style="background: #2e7d32; color: white; border: none; padding: 6px 14px; border-radius: 4px; font-weight: 600; font-size: 0.85rem; cursor: pointer;">Sah, Setujui Lunas</button>
            </form>
        </div>
    </div>
</div>

<style>
    .tab-btn { background: none; border: none; padding: 10px 16px; font-size: 0.85rem; font-weight: 600; color: #64748b; cursor: pointer; border-bottom: 3px solid transparent; transition: 0.2s; }
    .tab-btn:hover { color: #2e7d32; }
    .active-tab { color: #2e7d32; border-bottom: 3px solid #2e7d32; }
</style>

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
</script>
@endsection