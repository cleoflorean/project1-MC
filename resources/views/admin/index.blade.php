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
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.75rem;">
                    <thead>
                        <tr style="background: #fafafa; color: #475569; font-weight: 700; border-bottom: 1px solid #e2e8f0; text-transform: uppercase; font-size: 0.68rem; letter-spacing: 0.05em;">
                            <th style="padding: 12px 16px; width: 25%;">Detail Pembeli & Barang</th>
                            <th style="padding: 12px 16px; text-align: center; width: 18%;">Nominal & Waktu</th>
                            <th style="padding: 12px 16px; text-align: center; width: 15%;">Status Finansial</th>
                            <th style="padding: 12px 16px; text-align: center; width: 15%;">Status Logistik</th>
                            <th style="padding: 12px 16px; text-align: center; width: 12%;">Lampiran</th>
                            <th style="padding: 12px 16px; text-align: center; width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="color: #334155;">
                        @forelse($semuaTransaksi as $trx)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                            
                            {{-- Kolom 1: Detail Pembeli & Barang --}}
                            <td style="padding: 14px 16px;">
                                <div style="font-weight: 700; color: #0f172a; font-size: 0.85rem;">
                                    {{ $trx->penawaran->permintaan->user->username ?? '-' }}
                                </div>
                                <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">
                                    {{ $trx->penawaran->Komoditas ?? 'Komoditas' }}
                                </div>
                            </td>
                            
                            {{-- Kolom 2: Nominal & Waktu --}}
                            <td style="padding: 14px 16px; text-align: center;">
                                <div style="font-weight: 700; color: #0f172a; font-size: 0.85rem;">
                                    Rp {{ number_format($trx->TotalBayar, 0, ',', '.') }}
                                </div>
                                <div style="font-size: 0.72rem; color: #64748b; margin-top: 2px;">
                                    {{ $trx->created_at ? $trx->created_at->format('d M Y, H:i') : '-' }}
                                </div>
                            </td>
                            
                            {{-- Kolom 3: Status Finansial (Bubble Pills Match Screenshot) --}}
                            <td style="padding: 14px 16px; text-align: center;">
                                @if($trx->StatusPembayaran === 'Menunggu Verifikasi Admin' || $trx->StatusPembayaran === 'Menunggu Verifikasi')
                                    <span style="background: #fff7ed; color: #c2410c; padding: 4px 10px; border-radius: 4px; font-weight: 600; font-size: 0.68rem; border: 1px solid #ffedd5;">Belum Verifikasi</span>
                                @elseif($trx->StatusPembayaran === 'Lunas')
                                    <span style="background: #ecfdf5; color: #047857; padding: 4px 10px; border-radius: 4px; font-weight: 600; font-size: 0.68rem; border: 1px solid #d1fae5;">Dana Diterima</span>
                                @elseif($trx->StatusPembayaran === 'Ditolak' || $trx->StatusPembayaran === 'Dibatalkan')
                                    <span style="background: #fff1f2; color: #991b1b; padding: 4px 10px; border-radius: 4px; font-weight: 600; font-size: 0.68rem; border: 1px solid #fecdd3;">Dibatalkan</span>
                                @else
                                    <span style="background: #f8fafc; color: #64748b; padding: 4px 10px; border-radius: 4px; font-weight: 600; font-size: 0.68rem; border: 1px solid #e2e8f0;">Belum Bayar</span>
                                @endif
                            </td>

                            {{-- Kolom 4: Status Logistik (Teks Berwarna Match Screenshot) --}}
                            <td style="padding: 14px 16px; text-align: center; font-size: 0.75rem;">
                                @if(in_array($trx->StatusPesanan, ['Pesanan Selesai', 'Pesanan Diterima', 'Barang Diterima', 'Diterima']))
                                    <span style="color: #166534; font-weight: 700;">Barang Diterima</span>
                                @elseif($trx->StatusPesanan === 'Dibatalkan')
                                    <span style="color: #991b1b; font-weight: 700;">Batal</span>
                                @elseif($trx->StatusPembayaran === 'Menunggu Verifikasi' || $trx->StatusPembayaran === 'Belum Bayar')
                                    <span style="color: #64748b; font-weight: 500;">Menunggu Pembayaran</span>
                                @else
                                    <span style="color: #025487; font-weight: 700;">{{ $trx->StatusPesanan ?? 'Dikirim' }}</span>
                                @endif
                            </td>
                            
                            {{-- Kolom 5: Lampiran --}}
                            <td style="padding: 14px 16px; text-align: center;">
                                @if($trx->BuktiTransfer)
                                    <button type="button" onclick="bukaModalBukti('{{ asset('storage/' . $trx->BuktiTransfer) }}', '{{ route('admin.transaksi.verifikasi', $trx->idPembayaran) }}')" style="background: white; color: #334155; border: 1px solid #cbd5e1; padding: 4px 10px; border-radius: 4px; font-weight: 600; font-size: 0.68rem; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                        <i class="fas fa-file-image" style="color: #64748b;"></i> Bukti Transfer
                                    </button>
                                @else
                                    <span style="color: #cbd5e1; font-style: italic;">Tidak ada</span>
                                @endif
                            </td>
                            
                            {{-- Kolom 6: Aksi Kendali --}}
                            <td style="padding: 14px 16px; text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center; align-items: center;">
                                    
                                    {{-- JIKA BELUM BAYAR --}}
                                    @if($trx->StatusPembayaran === 'Belum Bayar' || empty($trx->BuktiTransfer))
                                        <span style="color: #64748b; font-size: 0.72rem; display: inline-flex; align-items: center; gap: 4px; font-weight: 500;">
                                            <i class="fas fa-clock" style="color: #94a3b8;"></i> Menunggu Pembayaran
                                        </span>

                                    {{-- JIKA PERLU VERIFIKASI CEK BUKTI --}}
                                    @elseif($trx->StatusPembayaran === 'Menunggu Verifikasi Admin' || $trx->StatusPembayaran === 'Menunggu Verifikasi')
                                        <button onclick="bukaModalBukti('{{ asset('storage/' . $trx->BuktiTransfer) }}', '{{ route('admin.transaksi.verifikasi', $trx->idPembayaran) }}')" style="background: #10b981; color: white; border: none; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 0.65rem; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">
                                            Cek Bukti
                                        </button>

                                    {{-- JIKA TRANSAKSI SUDAH LUNAS (DANA DI ESCROW) --}}
                                    @elseif($trx->StatusPembayaran === 'Lunas' && $trx->StatusPesanan !== 'Pesanan Selesai')
                                        <form action="{{ route('admin.transaksi.cairkan', $trx->idPembayaran) }}" method="POST" onsubmit="return confirm('Paksa Cairkan dana ke Petani?')" style="margin:0;">
                                            @csrf
                                            <button type="submit" style="background: #e0f2fe; color: #0369a1; border: none; padding: 4px 10px; border-radius: 4px; font-weight: 700; font-size: 0.68rem; cursor: pointer;">
                                                Dalam Pengiriman
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.transaksi.refund', $trx->idPembayaran) }}" method="POST" onsubmit="return confirm('Yakin ingin Refund dana ke Pembeli?')" style="margin:0;">
                                            @csrf
                                            <button type="submit" style="background: none; border: none; color: #991b1b; font-weight: 700; text-decoration: underline; font-size: 0.68rem; cursor: pointer; padding: 0;">
                                                Refund
                                            </button>
                                        </form>

                                    {{-- JIKA TRANSAKSI SUDAH SELESAI --}}
                                    @elseif($trx->StatusPesanan === 'Pesanan Selesai' || $trx->StatusPembayaran === 'Ditolak')
                                        <span style="color: #94a3b8; font-size: 0.72rem; display: inline-flex; align-items: center; gap: 4px; font-weight: 500;">
                                            <i class="fas fa-ban" style="color: #cbd5e1;"></i> Selesai
                                        </span>
                                    @endif
                                    
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="padding: 40px; text-align: center; color: #94a3b8; font-style: italic;">
                                <i class="fas fa-folder-open" style="display:block; font-size: 1.5rem; color: #cbd5e1; margin-bottom: 4px;"></i> Belum ada aktivitas transaksi terdaftar.
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
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.75rem;">
                    <thead>
                        <tr style="background: #fafafa; color: #64748b; font-weight: 600; border-bottom: 1px solid #e2e8f0; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 0.05em;">
                            <th style="padding: 10px 16px;">Nama Akun / Username</th>
                            <th style="padding: 10px 16px;">Alamat Email</th>
                            <th style="padding: 10px 16px; text-align: center;">Tingkat Hak Akses</th>
                            <th style="padding: 10px 16px; text-align: center;">Tanggal Registrasi</th>
                        </tr>
                    </thead>
                    <tbody style="color: #334155;">
                        @foreach($semuaAkun as $akun)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                            <td style="padding: 10px 16px; font-weight: 700; color: #0f172a;">{{ $akun->username }}</td>
                            <td style="padding: 10px 16px; color: #475569;">{{ $akun->email }}</td>
                            <td style="padding: 10px 16px; text-align: center;">
                                @if($akun->role === 'admin')
                                    <span style="background: #fff3e0; color: #e65100; padding: 2px 6px; border-radius: 4px; font-weight: 600; font-size: 0.65rem; border: 1px solid #ffe8cc;">Sistem Admin</span>
                                @elseif($akun->role === 'petani')
                                    <span style="background: #ecfdf5; color: #047857; padding: 2px 6px; border-radius: 4px; font-weight: 600; font-size: 0.65rem; border: 1px solid #d1fae5;">Mitra Petani</span>
                                @else
                                    <span style="background: #e0f2fe; color: #0369a1; padding: 2px 6px; border-radius: 4px; font-weight: 600; font-size: 0.65rem; border: 1px solid #bae6fd;">Akun Pembeli</span>
                                @endif
                            </td>
                            <td style="padding: 10px 16px; text-align: center; color: #64748b;">{{ $akun->created_at->format('d M Y') }}</td>
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
</script>
@endsection