@extends('layouts.app')
@section('title', 'Rincian Pesanan - Premium')

@section('content')
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
        <div style="background: #FFFFFF; border-radius: 20px; padding: 32px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #F1F5F9; box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.03);">
            <div>
                <p style="margin: 0 0 8px 0; font-size: 0.85rem; color: #64748B; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                    Order ID: #{{ $pesanan->idPembayaran }}
                </p>
                <h2 style="margin: 0 0 8px 0; font-size: 1.75rem; font-weight: 800; color: #064E3B; letter-spacing: -0.5px;">
                    @if($pesanan->StatusPesanan === 'Menunggu Konfirmasi Petani') Verifikasi Pembayaran
                    @elseif(in_array($pesanan->StatusPesanan, ['Petani Menyiapkan Barang', 'Dikirim', 'Dalam Pengiriman'])) Sedang Diproses
                    @elseif($pesanan->StatusPesanan === 'Pesanan Selesai') Transaksi Selesai
                    @else {{ $pesanan->StatusPesanan }}
                    @endif
                </h2>
                <p style="margin: 0; font-size: 0.95rem; color: #475569;">
                    @if($pesanan->StatusPesanan === 'Menunggu Konfirmasi Petani') Pembeli sudah membayar. Mohon verifikasi bukti transfer.
                    @elseif(in_array($pesanan->StatusPesanan, ['Petani Menyiapkan Barang', 'Dikirim', 'Dalam Pengiriman'])) Pesanan sedang dalam tahap penyelesaian.
                    @elseif($pesanan->StatusPesanan === 'Pesanan Selesai') Dana akan segera diteruskan ke rekening Anda.
                    @else Silakan cek status secara berkala.
                    @endif
                </p>
            </div>
            <div style="background: #ECFDF5; width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-seedling" style="font-size: 2rem; color: #059669;"></i>
            </div>
        </div>

        @php
            $pembeli = $pesanan->penawaran->permintaan->user ?? null;
            $profilPembeli = $pembeli ? $pembeli->pembeliProfile : null;
        @endphp
        
        <div style="display: grid; grid-template-columns: 1fr; gap: 24px;">
            
            {{-- SEGMEN DETAIL PRODUK & PENDAPATAN --}}
            <div style="background: #FFFFFF; border-radius: 20px; border: 1px solid #F1F5F9; box-shadow: 0 4px 20px -10px rgba(0, 0, 0, 0.03); overflow: hidden;">
                
                {{-- Info Toko --}}
                <div style="padding: 20px 24px; border-bottom: 1px solid #F8FAFC; display: flex; align-items: center; gap: 12px;">
                    <div style="background: #F1F5F9; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-store" style="color: #475569; font-size: 0.85rem;"></i>
                    </div>
                    <span style="font-weight: 600; color: #1E293B; font-size: 1rem;">{{ $pesanan->penawaran->user->username ?? 'Toko Pertanian' }}</span>
                </div>

                {{-- Rincian Tanaman/Komoditas --}}
                <div style="padding: 24px; display: flex; gap: 20px;">
                    <div style="width: 100px; height: 100px; background: #F8FAFC; border-radius: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #F1F5F9;">
                        @if($pesanan->penawaran->Gambar)
                            <img src="{{ asset('storage/' . $pesanan->penawaran->Gambar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fas fa-leaf" style="font-size: 2.5rem; color: #10B981;"></i>
                        @endif
                    </div>
                    <div style="flex: 1; display: flex; flex-direction: column; justify-content: center;">
                        <div style="display: flex; gap: 8px; margin-bottom: 6px;">
                            <span style="background: #ECFDF5; color: #059669; padding: 4px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                                {{ $pesanan->penawaran->Komoditas }}
                            </span>
                        </div>
                        {{-- Menampilkan Nama Tanaman agar lebih detail --}}
                        <h4 style="margin: 0 0 8px 0; font-size: 1.25rem; color: #0F172A; font-weight: 700;">{{ $pesanan->penawaran->NamaTanaman }}</h4>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
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
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 600; color: #64748B; font-size: 1rem;">Total Pendapatan</span>
                        <span style="font-size: 1.5rem; font-weight: 800; color: #059669;">Rp {{ number_format($pesanan->TotalBayar, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- SEGMEN TIMELINE (Riwayat Proses Realistis) --}}
            <div style="background: #FFFFFF; padding: 32px; border-radius: 20px; border: 1px solid #F1F5F9; box-shadow: 0 4px 20px -10px rgba(0, 0, 0, 0.03);">
                <h3 style="margin: 0 0 24px 0; font-size: 1.15rem; color: #0F172A; font-weight: 800; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-stream" style="color: #059669; font-size: 1rem;"></i> Riwayat Transaksi
                </h3>
                
                {{-- Timeline Container --}}
                <div style="margin-left: 12px; border-left: 2px solid #E2E8F0; padding-left: 24px; position: relative;">
                    
                    {{-- 1. Penawaran Disetujui (Selalu aktif, mengambil created_at) --}}
                    <div style="position: relative; margin-bottom: 32px;">
                        <div style="position: absolute; left: -31px; top: 2px; width: 14px; height: 14px; border-radius: 50%; background: #059669; border: 3px solid #FFFFFF; box-shadow: 0 0 0 2px #059669;"></div>
                        <div style="font-size: 1rem; font-weight: 700; color: #1E293B; margin-bottom: 4px;">Penawaran Disetujui</div>
                        <div style="font-size: 0.85rem; color: #64748B;">Kesepakatan harga dan kuantitas tercapai.</div>
                        <div style="font-size: 0.85rem; color: #94A3B8; margin-top: 4px; font-weight: 500;">{{ \Carbon\Carbon::parse($pesanan->created_at)->translatedFormat('l, d M Y - H:i') }}</div>
                    </div>

                    {{-- 2. Pembayaran Dikonfirmasi --}}
                    @php
                        // Logika: Jika status BUKAN Menunggu Verifikasi / Menunggu Konfirmasi Petani, berarti sudah dikonfirmasi.
                        $isConfirmed = !in_array($pesanan->StatusPesanan, ['Menunggu Konfirmasi Petani', 'Menunggu Verifikasi', 'Belum Bayar']);
                        $isDone = ($pesanan->StatusPesanan === 'Pesanan Selesai');
                    @endphp
                    
                    <div style="position: relative; margin-bottom: {{ $isConfirmed ? '32px' : '0' }}; opacity: {{ $isConfirmed ? '1' : '0.4' }};">
                        <div style="position: absolute; left: -31px; top: 2px; width: 14px; height: 14px; border-radius: 50%; background: {{ $isConfirmed ? '#059669' : '#CBD5E1' }}; border: 3px solid #FFFFFF; box-shadow: 0 0 0 2px {{ $isConfirmed ? '#059669' : '#CBD5E1' }};"></div>
                        <div style="font-size: 1rem; font-weight: 700; color: #1E293B; margin-bottom: 4px;">Pembayaran Dikonfirmasi</div>
                        <div style="font-size: 0.85rem; color: #64748B;">Bukti pembayaran telah diverifikasi oleh Anda.</div>
                        @if($isConfirmed && $pesanan->updated_at)
                        <div style="font-size: 0.85rem; color: #94A3B8; margin-top: 4px; font-weight: 500;">
                           Telah diverifikasi
                        </div>
                        @endif
                    </div>

                    {{-- 3. Pesanan Selesai --}}
                    @if($isConfirmed)
                    <div style="position: relative; opacity: {{ $isDone ? '1' : '0.4' }};">
                        <div style="position: absolute; left: -31px; top: 2px; width: 14px; height: 14px; border-radius: 50%; background: {{ $isDone ? '#059669' : '#CBD5E1' }}; border: 3px solid #FFFFFF; box-shadow: 0 0 0 2px {{ $isDone ? '#059669' : '#CBD5E1' }};"></div>
                        <div style="font-size: 1rem; font-weight: 700; color: #1E293B; margin-bottom: 4px;">Pesanan Selesai</div>
                        <div style="font-size: 0.85rem; color: #64748B;">Transaksi telah selesai. Menunggu penilaian.</div>
                        @if($isDone)
                        <div style="font-size: 0.85rem; color: #94A3B8; margin-top: 4px; font-weight: 500;">{{ \Carbon\Carbon::parse($pesanan->updated_at)->translatedFormat('l, d M Y - H:i') }}</div>
                        @endif
                    </div>
                    @endif
                    
                </div>
            </div>

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

        </div>
    </div>
    
    {{-- ACTION BAR (Melayang di bawah layaknya aplikasi premium) --}}
    <div style="position: fixed; bottom: 0; left: 0; width: 100%; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); padding: 20px; border-top: 1px solid #E2E8F0; z-index: 50;">
        <div style="max-width: 768px; width: 100%; margin: 0 auto; display: flex; justify-content: flex-end; gap: 16px;">
            
            @if($pesanan->StatusPesanan === 'Menunggu Konfirmasi Petani')
                <button onclick="document.getElementById('imageModal').style.display='flex'" style="background: transparent; border: 2px solid #064E3B; color: #064E3B; padding: 14px 28px; border-radius: 12px; font-weight: 700; cursor: pointer;">Lihat Bukti Transfer</button>
                <form action="{{ route('petani.pesanan.terima', $pesanan->idPembayaran) }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: #064E3B; color: #FFFFFF; border: none; padding: 16px 32px; border-radius: 12px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 15px rgba(6, 78, 59, 0.2);">Konfirmasi Pembayaran</button>
                </form>
            @elseif(in_array($pesanan->StatusPesanan, ['Petani Menyiapkan Barang', 'Dikirim', 'Dalam Pengiriman']))
                <form action="{{ route('petani.pesanan.kirim', $pesanan->idPembayaran) }}" method="POST" style="margin: 0;">
                    @csrf
                    {{-- Anda dapat menyesuaikan route atau mematikan tombol jika pengiriman offline/manual --}}
                    <button type="submit" style="background: #064E3B; color: #FFFFFF; border: none; padding: 16px 32px; border-radius: 12px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 15px rgba(6, 78, 59, 0.2);">Tandai Sedang Dikirim</button>
                </form>
            @elseif($pesanan->StatusPesanan === 'Pesanan Selesai')
                <button disabled style="background: #F1F5F9; color: #94A3B8; border: 1px solid #E2E8F0; padding: 16px 32px; border-radius: 12px; font-weight: 700; cursor: not-allowed;">Transaksi Selesai</button>
            @else
                <button disabled style="background: #F1F5F9; color: #94A3B8; border: 1px solid #E2E8F0; padding: 16px 32px; border-radius: 12px; font-weight: 700; cursor: not-allowed;">Menunggu Pembeli</button>
            @endif

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