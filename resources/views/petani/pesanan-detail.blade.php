@extends('layouts.app')
@section('title', 'Rincian Pesanan - Premium')

@section('content')
@php
    $pembeli = $pesanan->penawaran->permintaan->user ?? null;
    $profilPembeli = $pembeli ? $pembeli->pembeliProfile : null;
    
    // Melakukan trim agar tidak ada spasi tidak sengaja yang merusak kondisi if
    $statusPesanan = trim($pesanan->StatusPesanan);

    // 1. Pembayaran Dikonfirmasi (aktif jika status telah melewati proses menunggu pembayaran)
    $isConfirmed = !in_array($statusPesanan, ['Menunggu Pembayaran', 'Menunggu Verifikasi Admin', 'Belum Dibayar']);
    
    // 2. Pesanan Dikirim (aktif jika petani sudah mengirim barang / status sudah dikirim atau selesai)
    $isShipped = in_array($statusPesanan, ['Dikirim', 'Dalam Pengiriman', 'Pesanan Selesai', 'Selesai']);
    
    // 3. Pesanan Selesai (aktif jika status transaksi sudah benar-benar tuntas)
    $isDone = in_array($statusPesanan, ['Pesanan Selesai', 'Selesai']);
@endphp

<div style="background-color: #F8FAFC; min-height: 100vh; padding-bottom: 120px; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; color: #0F172A;">
    
    {{-- HEADER KEMBALI --}}
    <div style="max-width: 768px; margin: 0 auto; padding: 32px 20px 24px 20px;">
        <a href="{{ route('petani.pesanan') }}" style="display: inline-flex; align-items: center; gap: 12px; color: #475569; text-decoration: none; font-size: 1rem; font-weight: 500; transition: 0.3s;">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Daftar Pesanan
        </a>
    </div>

    <div style="max-width: 768px; margin: 0 auto; padding: 0 20px;">
        
        {{-- CARD STATUS (Gaya Minimalis Premium) --}}
        <div style="background: #FFFFFF; border-radius: 20px; padding: 32px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; border: 1px solid #F1F5F9; box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.03);">
            <div>
                <h2 style="margin: 0 0 8px 0; font-size: 1.75rem; font-weight: 800; color: #064E3B; letter-spacing: -0.5px;">
                    @if($statusPesanan === 'Menunggu Verifikasi Admin') Menunggu Verifikasi Admin
                    @elseif($statusPesanan === 'Petani Menyiapkan Barang') Siap Dikirim
                    @elseif(in_array($statusPesanan, ['Dikirim', 'Dalam Pengiriman'])) Sedang Diproses
                    @elseif(in_array($statusPesanan, ['Pesanan Selesai', 'Selesai'])) Transaksi Selesai
                    @else {{ $pesanan->StatusPesanan }}
                    @endif
                </h2>
                <p style="margin: 0; font-size: 0.95rem; color: #475569;">
                    @if($statusPesanan === 'Menunggu Verifikasi Admin') Pembeli telah mengunggah bukti pembayaran. Menunggu Admin memverifikasi dana.
                    @elseif($statusPesanan === 'Petani Menyiapkan Barang') Anda sudah bisa mengirimkan pesanan ke alamat pembeli di bawah ini.
                    @elseif(in_array($statusPesanan, ['Dikirim', 'Dalam Pengiriman'])) Pesanan sedang dalam perjalanan menuju lokasi pembeli.
                    @elseif(in_array($statusPesanan, ['Pesanan Selesai', 'Selesai'])) Dana akan segera diteruskan ke rekening Anda oleh Admin.
                    @else Silakan cek status secara berkala.
                    @endif
                </p>
            </div>

            {{-- Tombol Aksi Cepat langsung dari Halaman Detail --}}
            @if($statusPesanan === 'Petani Menyiapkan Barang')
                <div>
                    <form action="{{ route('petani.pesanan.kirim', $pesanan->idPembayaran) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: #059669; color: #FFFFFF; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 700; font-size: 0.95rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);" onmouseover="this.style.background='#047857'" onmouseout="this.style.background='#059669'">
                            <i class="fas fa-paper-plane"></i> Kirim Barang
                        </button>
                    </form>
                </div>
            @endif
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr; gap: 24px;">
            
            {{-- SEGMEN INFO PEMBELI --}}
            <div style="background: #FFFFFF; padding: 24px 32px; border-radius: 20px; border: 1px solid #F1F5F9; box-shadow: 0 4px 20px -10px rgba(0, 0, 0, 0.03);">
                <h3 style="margin: 0 0 16px 0; font-size: 1rem; color: #0F172A; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-map-marker-alt" style="color: #059669;"></i> Alamat Pembeli
                </h3>
                <div style="font-size: 1rem; margin-bottom: 8px;">
                    <span style="font-weight: 700; color: #1E293B;">{{ $profilPembeli->NamaLengkap ?? $pembeli->username ?? 'Nama Pembeli' }}</span> 
                    <span style="color: #64748B; font-size: 0.9rem; margin-left: 8px;">{{ $profilPembeli->NoTlp ? '(+62) ' . ltrim($profilPembeli->NoTlp, '0') : '' }}</span>
                </div>
                <p style="margin: 0; line-height: 1.6; color: #475569; font-size: 0.95rem;">{{ $profilPembeli->Alamat ?? 'Alamat belum dilengkapi.' }}</p>
            </div>

            {{-- SEGMEN TIMELINE (Riwayat Proses Realistis) --}}
            <div style="background: #FFFFFF; padding: 32px; border-radius: 20px; border: 1px solid #F1F5F9; box-shadow: 0 4px 20px -10px rgba(0, 0, 0, 0.03);">
                <h3 style="margin: 0 0 24px 0; font-size: 1.15rem; color: #0F172A; font-weight: 800; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-stream" style="color: #059669; font-size: 1rem;"></i> Riwayat Transaksi
                </h3>
            
                {{-- Timeline Container --}}
                <div style="margin-left: 12px; border-left: 2px solid #E2E8F0; padding-left: 24px; position: relative;">
                
                    {{-- 1. Penawaran Disetujui --}}
                    <div style="position: relative; margin-bottom: 32px;">
                        <div style="position: absolute; left: -31px; top: 2px; width: 14px; height: 14px; border-radius: 50%; background: #059669; border: 3px solid #FFFFFF; box-shadow: 0 0 0 2px #059669;"></div>
                        <div style="font-size: 1rem; font-weight: 700; color: #1E293B; margin-bottom: 4px;">Penawaran Disetujui</div>
                        <div style="font-size: 0.85rem; color: #64748B;">Kesepakatan harga dan kuantitas tercapai.</div>
                        <div style="font-size: 0.85rem; color: #94A3B8; margin-top: 4px; font-weight: 500;">{{ \Carbon\Carbon::parse($pesanan->created_at)->translatedFormat('l, d M Y - H:i') }}</div>
                    </div>

                    {{-- 2. Pembayaran Dikonfirmasi --}}
                    <div style="position: relative; margin-bottom: 32px; opacity: {{ $isConfirmed ? '1' : '0.4' }};">
                        <div style="position: absolute; left: -31px; top: 2px; width: 14px; height: 14px; border-radius: 50%; background: {{ $isConfirmed ? '#059669' : '#CBD5E1' }}; border: 3px solid #FFFFFF; box-shadow: 0 0 0 2px {{ $isConfirmed ? '#059669' : '#CBD5E1' }};"></div>
                        <div style="font-size: 1rem; font-weight: 700; color: #1E293B; margin-bottom: 4px;">Pembayaran Dikonfirmasi</div>
                        <div style="font-size: 0.85rem; color: #64748B;">Bukti pembayaran telah diverifikasi oleh Admin.</div>
                        @if($isConfirmed)
                            <div style="font-size: 0.85rem; color: #94A3B8; margin-top: 4px; font-weight: 500;">Telah diverifikasi</div>
                        @endif
                    </div>

                    {{-- 3. Pesanan Dikirim --}}
                    <div style="position: relative; margin-bottom: 32px; opacity: {{ $isShipped ? '1' : '0.4' }};">
                        <div style="position: absolute; left: -31px; top: 2px; width: 14px; height: 14px; border-radius: 50%; background: {{ $isShipped ? '#059669' : '#CBD5E1' }}; border: 3px solid #FFFFFF; box-shadow: 0 0 0 2px {{ $isShipped ? '#059669' : '#CBD5E1' }};"></div>
                        <div style="font-size: 1rem; font-weight: 700; color: #1E293B; margin-bottom: 4px;">Pesanan Dikirim</div>
                        <div style="font-size: 0.85rem; color: #64748B;">Barang sedang dalam perjalanan menuju lokasi pembeli.</div>
                    </div>

                    {{-- 4. Pesanan Selesai --}}
                    <div style="position: relative; opacity: {{ $isDone ? '1' : '0.4' }};">
                        <div style="position: absolute; left: -31px; top: 2px; width: 14px; height: 14px; border-radius: 50%; background: {{ $isDone ? '#059669' : '#CBD5E1' }}; border: 3px solid #FFFFFF; box-shadow: 0 0 0 2px {{ $isDone ? '#059669' : '#CBD5E1' }};"></div>
                        <div style="font-size: 1rem; font-weight: 700; color: #1E293B; margin-bottom: 4px;">Pesanan Selesai</div>
                        <div style="font-size: 0.85rem; color: #64748B;">Transaksi telah selesai.</div>
                        @if($isDone)
                            <div style="font-size: 0.85rem; color: #94A3B8; margin-top: 4px; font-weight: 500;">{{ \Carbon\Carbon::parse($pesanan->updated_at)->translatedFormat('l, d M Y - H:i') }}</div>
                        @endif
                    </div>
                    
                </div>
            </div>

            {{-- SEGMEN DETAIL PRODUK & PENDAPATAN --}}
            <div style="background: #FFFFFF; border-radius: 20px; border: 1px solid #F1F5F9; box-shadow: 0 4px 20px -10px rgba(0, 0, 0, 0.03); overflow: hidden;">
                {{-- Info Toko --}}
                <div style="padding: 20px 24px; border-bottom: 1px solid #F8FAFC; display: flex; align-items: center; gap: 12px;">
                    <div style="background: #F1F5F9; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-store" style="color: #475569; font-size: 0.85rem;"></i>
                    </div>
                    <span style="font-weight: 600; color: #1E293B; font-size: 1rem;">{{ $pesanan->penawaran->permintaan->user->username ?? 'Mitra Pembeli' }}</span>
                </div>

                {{-- Rincian Tanaman/Komoditas --}}
                <div style="padding: 24px; display: flex; gap: 20px; flex-wrap: wrap;">
                    <div style="width: 100px; height: 100px; background: #F8FAFC; border-radius: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #F1F5F9; flex-shrink: 0;">
                        @if($pesanan->penawaran->Gambar)
                            <img src="{{ asset($pesanan->penawaran->Gambar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fas fa-leaf" style="font-size: 2.5rem; color: #10B981;"></i>
                        @endif
                    </div>
                    <div style="flex: 1; min-width: 200px; display: flex; flex-direction: column; justify-content: center;">
                        <div style="display: flex; gap: 8px; margin-bottom: 6px;">
                            <span style="background: #ECFDF5; color: #059669; padding: 4px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                                {{ $pesanan->penawaran->Komoditas }}
                            </span>
                        </div>
                        <h4 style="margin: 0 0 8px 0; font-size: 1.25rem; color: #0F172A; font-weight: 700;">{{ $pesanan->penawaran->NamaTanaman }}</h4>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; flex-wrap: wrap; gap: 8px;">
                            <span style="color: #64748B; font-size: 0.95rem; font-weight: 500;">
                                Kuantitas: <span style="color: #0F172A; font-weight: 700;">{{ $pesanan->penawaran->JumlahTawar }} kg</span>
                            </span>
                            <div style="text-align: right;">
                                <span style="font-size: 1.1rem; font-weight: 800; color: #0F172A;">Rp {{ number_format($pesanan->penawaran->HargaTawar, 0, ',', '.') }}</span>
                                <span style="color: #94A3B8; font-size: 0.85rem;">/kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Box Total --}}
                <div style="padding: 24px; background: #FAFAFA; border-top: 1px dashed #E2E8F0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                        <span style="font-weight: 600; color: #64748B; font-size: 1rem;">Total Pendapatan</span>
                        <span style="font-size: 1.5rem; font-weight: 800; color: #059669;">Rp {{ number_format($pesanan->TotalBayar, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

{{-- MODAL BUKTI TRANSFER --}}
@if($pesanan->BuktiTransfer)
<div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.9); z-index: 9999; align-items: center; justify-content: center; flex-direction: column; backdrop-filter: blur(8px);">
    <span onclick="document.getElementById('imageModal').style.display='none'" style="position: absolute; top: 32px; right: 40px; color: #FFFFFF; font-size: 2rem; cursor: pointer; background: rgba(255,255,255,0.1); width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">&times;</span>
    <img src="{{ asset($pesanan->BuktiTransfer) }}" style="max-width: 90%; max-height: 75vh; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
    <p style="color: #FFFFFF; margin-top: 24px; font-weight: 600; font-size: 1.1rem; letter-spacing: 0.5px;">Bukti Transfer Pembeli</p>
</div>
@endif
@endsection