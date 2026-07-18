@extends('layouts.app22')
@section('title', 'Rincian Pesanan')

@section('content')
<div style="background-color: #f4f7f6; min-height: 100vh; padding-bottom: 90px; font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    @php
        $statPembayaran = trim($pesanan->StatusPembayaran);
        $statPengiriman = trim(optional($pesanan->pengiriman)->StatusPesanan);
    
        if ($statPembayaran === 'Menunggu Verifikasi Admin' && !in_array($statPengiriman, ['Petani Menyiapkan Barang', 'Dikirim', 'Pesanan Selesai', 'Selesai'])) {
            $statusPesanan = 'Menunggu Verifikasi Admin';
        } else {
            $statusPesanan = $statPengiriman ?: $statPembayaran;
        }
    
        $isConfirmed = !in_array($statusPesanan, ['Menunggu Pembayaran', 'Menunggu Verifikasi Admin', 'Belum Dibayar']) && !empty($pesanan->BuktiTransfer);
        $isShipped = in_array($statusPesanan, ['Dikirim', 'Dalam Pengiriman', 'Pesanan Selesai', 'Selesai']);
        $isDone = in_array($statusPesanan, ['Pesanan Selesai', 'Selesai']);
    @endphp
    
    {{-- HEADER KEMBALI (Background menyatu dengan halaman, tetap sticky saat di-scroll) --}}
    <div style="background-color: #f4f7f6; position: sticky; top: 0; z-index: 50; padding-top: 0">
        {{-- Padding bottom di-set 15px agar jarak ke kotak di bawahnya sama persis dengan jarak antar kotak --}}
        <div style="max-width: 600px; margin: 0 auto; padding: 0 15px 15px 15px; display: flex; align-items: center; gap: 15px;">
            <a href="{{ route('pembeli.riwayat') }}" style="color: #065f46; font-size: 1.25rem; text-decoration: none;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 style="margin: 0; font-size: 1.2rem; font-weight: 700; color: #111827;">Rincian Pesanan</h1>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div style="max-width: 600px; margin: 0 auto; padding: 0 15px 15px 15px;">
        
        {{-- BANNER STATUS PESANAN --}}
        <div style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h3 style="margin: 0 0 5px 0; font-size: 1.1rem; color: #111827; font-weight: 700;">Status Transaksi</h3>
                
                @if(empty($pesanan->BuktiTransfer))
                    <p style="margin: 0; color: #ef4444; font-size: 0.9rem; font-weight: 600;">Menunggu Pembayaran</p>
                @elseif(optional($pesanan->pengiriman)->StatusPesanan === 'Menunggu Verifikasi Admin')
                    <p style="margin: 0; color: #f59e0b; font-size: 0.9rem; font-weight: 600;">Menunggu Admin TaniHub memverifikasi bukti transfer Anda</p>
                @elseif(optional($pesanan->pengiriman)->StatusPesanan === 'Petani Menyiapkan Barang')
                    <p style="margin: 0; color: #2563eb; font-size: 0.9rem; font-weight: 600;">Pembayaran diterima. Petani sedang mengemas pesanan Anda</p>
                @elseif(optional($pesanan->pengiriman)->StatusPesanan === 'Dikirim')
                    <p style="margin: 0; color: #10b981; font-size: 0.9rem; font-weight: 600;">Pesanan sedang dalam perjalanan ke alamat Anda</p>
                @elseif(optional($pesanan->pengiriman)->StatusPesanan === 'Pesanan Selesai')
                    <p style="margin: 0; color: #059669; font-size: 0.9rem; font-weight: 600;">Pesanan telah selesai. Terima kasih!</p>
                @else
                    <p style="margin: 0; color: #6b7280; font-size: 0.9rem; font-weight: 600;">{{ optional($pesanan->pengiriman)->StatusPesanan ?: $pesanan->StatusPembayaran }}</p>
                @endif
            </div>
            <i class="fas fa-clipboard-list" style="font-size: 2rem; color: #e5e7eb;"></i>
        </div>

        {{-- SEGMEN TIMELINE (Riwayat Proses) --}}
        <div style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
            <h4 style="margin: 0 0 15px 0; font-size: 1rem; color: #1f2937; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-stream" style="color: #10b981;"></i> Riwayat Transaksi
            </h4>
        
            {{-- Timeline Container --}}
            <div style="margin-left: 10px; border-left: 2px solid #e5e7eb; padding-left: 20px; position: relative;">
            
                {{-- 1. Penawaran Disetujui --}}
                <div style="position: relative; margin-bottom: 25px;">
                    <div style="position: absolute; left: -27px; top: 2px; width: 12px; height: 12px; border-radius: 50%; background: #10b981; border: 2px solid white; box-shadow: 0 0 0 2px #10b981;"></div>
                    <div style="font-size: 0.95rem; font-weight: 700; color: #1f2937; margin-bottom: 2px;">Pesanan Dibuat</div>
                    <div style="font-size: 0.85rem; color: #6b7280;">Menunggu pembayaran atau verifikasi admin.</div>
                    <div style="font-size: 0.8rem; color: #9ca3af; margin-top: 2px;">{{ \Carbon\Carbon::parse($pesanan->created_at)->translatedFormat('d M Y - H:i') }}</div>
                </div>

                {{-- 2. Pembayaran Dikonfirmasi --}}
                <div style="position: relative; margin-bottom: 25px; opacity: {{ $isConfirmed ? '1' : '0.4' }};">
                    <div style="position: absolute; left: -27px; top: 2px; width: 12px; height: 12px; border-radius: 50%; background: {{ $isConfirmed ? '#10b981' : '#d1d5db' }}; border: 2px solid white; box-shadow: 0 0 0 2px {{ $isConfirmed ? '#10b981' : '#d1d5db' }};"></div>
                    <div style="font-size: 0.95rem; font-weight: 700; color: #1f2937; margin-bottom: 2px;">Pembayaran Dikonfirmasi</div>
                    <div style="font-size: 0.85rem; color: #6b7280;">Pembayaran berhasil diverifikasi. Pesanan sedang dikemas.</div>
                </div>

                {{-- 3. Pesanan Dikirim --}}
                <div style="position: relative; margin-bottom: 25px; opacity: {{ $isShipped ? '1' : '0.4' }};">
                    <div style="position: absolute; left: -27px; top: 2px; width: 12px; height: 12px; border-radius: 50%; background: {{ $isShipped ? '#10b981' : '#d1d5db' }}; border: 2px solid white; box-shadow: 0 0 0 2px {{ $isShipped ? '#10b981' : '#d1d5db' }};"></div>
                    <div style="font-size: 0.95rem; font-weight: 700; color: #1f2937; margin-bottom: 2px;">Pesanan Dikirim</div>
                    <div style="font-size: 0.85rem; color: #6b7280;">Barang sedang dalam perjalanan menuju lokasi Anda.</div>
                </div>

                {{-- 4. Pesanan Selesai --}}
                <div style="position: relative; opacity: {{ $isDone ? '1' : '0.4' }};">
                    <div style="position: absolute; left: -27px; top: 2px; width: 12px; height: 12px; border-radius: 50%; background: {{ $isDone ? '#10b981' : '#d1d5db' }}; border: 2px solid white; box-shadow: 0 0 0 2px {{ $isDone ? '#10b981' : '#d1d5db' }};"></div>
                    <div style="font-size: 0.95rem; font-weight: 700; color: #1f2937; margin-bottom: 2px;">Pesanan Selesai</div>
                    <div style="font-size: 0.85rem; color: #6b7280;">Barang telah Anda terima.</div>
                    @if($isDone)
                        <div style="font-size: 0.8rem; color: #9ca3af; margin-top: 2px;">{{ \Carbon\Carbon::parse($pesanan->updated_at)->translatedFormat('d M Y - H:i') }}</div>
                    @endif
                </div>
                
            </div>
        </div>

        {{-- ALAMAT PENGIRIMAN --}}
        <div style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
            <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                <i class="fas fa-map-marker-alt" style="color: #10b981; font-size: 1.2rem; margin-top: 2px;"></i>
                <div>
                    <h4 style="margin: 0 0 5px 0; font-size: 1rem; color: #1f2937; font-weight: 700;">Alamat Pengiriman</h4>
                    <p style="margin: 0 0 5px 0; font-size: 0.95rem; font-weight: 600; color: #374151;">{{ auth()->user()->profile->NamaLengkap }} | {{ auth()->user()->profile->NoWhatsApp ?? '-' }}</p>
                    <p style="margin: 0; font-size: 0.9rem; color: #6b7280; line-height: 1.5;">{{ auth()->user()->profile->Alamat ?? 'Alamat belum diatur' }}</p>
                </div>
            </div>
        </div>

        {{-- DETAIL PRODUK & PETANI --}}
        <div style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px; border-bottom: 1px solid #f3f4f6; padding-bottom: 10px;">
                <i class="fas fa-store" style="color: #6b7280;"></i>
                <span style="font-weight: 700; color: #374151;">{{ $pesanan->penawaran->petani->username }}</span>
            </div>

            <div style="display: flex; gap: 15px;">
                <div style="width: 70px; height: 70px; border-radius: 8px; border: 1px solid #e5e7eb; overflow: hidden; background: #f9fafb; flex-shrink: 0;">
                    @if($pesanan->penawaran->Gambar)
                        <img src="{{ asset('storage/' . $pesanan->penawaran->Gambar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #9ca3af;"><i class="fas fa-image"></i></div>
                    @endif
                </div>
                <div style="flex-grow: 1;">
                    <h5 style="margin: 0 0 5px 0; font-size: 1.05rem; font-weight: 700; color: #1f2937;">{{ $pesanan->penawaran->permintaan->Komoditas }}</h5>
                    <p style="margin: 0; font-size: 0.9rem; color: #6b7280;">Jumlah: {{ $pesanan->penawaran->permintaan->JumlahTawar }} Kg</p>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 5px;">
                        <span style="font-weight: 600; color: #1f2937; font-size: 0.95rem;">Rp {{ number_format($pesanan->penawaran->HargaTawar, 0, ',', '.') }} <small style="color: #6b7280; font-weight: 400;">/kg</small></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- RINCIAN PEMBAYARAN KEUANGAN --}}
        <div style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
            <h4 style="margin: 0 0 15px 0; font-size: 1rem; color: #1f2937; font-weight: 700;">Rincian Pembayaran</h4>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span style="color: #6b7280; font-size: 0.95rem;">Total Harga Komoditas</span>
                <span style="color: #374151; font-size: 0.95rem; font-weight: 500;">Rp {{ number_format($pesanan->TotalBayar, 0, ',', '.') }}</span>
            </div>
            
            <div style="border-top: 1px dashed #e5e7eb; padding-top: 15px; margin-top: 5px; display: flex; justify-content: space-between; align-items: center;">
                <span style="color: #1f2937; font-size: 1rem; font-weight: 700;">Total Tagihan</span>
                <span style="color: #2a7a43; font-size: 1.2rem; font-weight: 800;">Rp {{ number_format($pesanan->TotalBayar, 0, ',', '.') }}</span>
            </div>
        </div>

    </div>

    {{-- FIXED BOTTOM BAR UNTUK TOMBOL AKSI UTAMA --}}
    <div style="position: fixed; bottom: 0; width: 100%; background: white; border-top: 1px solid #e5e7eb; padding: 15px 20px; box-shadow: 0 -4px 6px rgba(0,0,0,0.02); display: flex; justify-content: center; z-index: 50;">
        <div style="max-width: 600px; width: 100%; display: flex; gap: 10px;">
            
            @if(empty($pesanan->BuktiTransfer))
                <a href="{{ route('pembayaran.show', $pesanan->idTawar) }}" style="flex: 1; text-align: center; background: #ef4444; color: white; padding: 14px 0; border-radius: 8px; font-weight: 700; font-size: 1rem; text-decoration: none;">
                    Bayar Sekarang
                </a>
            @elseif(optional($pesanan->pengiriman)->StatusPesanan === 'Dikirim')
                <button onclick="document.getElementById('modalUlasanDetail').style.display='flex'" style="flex: 1; background: #2a7a43; color: white; border: none; padding: 14px 0; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer;">
                    Pesanan Diterima
                </button>
            @elseif(in_array(optional($pesanan->pengiriman)->StatusPesanan, ['Pesanan Selesai', 'Selesai']))
                <button disabled style="flex: 1; background: #f3f4f6; color: #9ca3af; border: none; padding: 14px 0; border-radius: 8px; font-weight: 700; font-size: 1rem;">
                    Transaksi Selesai
                </button>
            @else
                <button disabled style="flex: 1; background: #f3f4f6; color: #9ca3af; border: none; padding: 14px 0; border-radius: 8px; font-weight: 700; font-size: 1rem;">
                    Menunggu Proses
                </button>
            @endif
            
        </div>
    </div>
</div>

{{-- MODAL ULASAN SAAT KLIK PESANAN DITERIMA --}}
<div id="modalUlasanDetail" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 16px; width: 90%; max-width: 400px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
        <h4 style="margin: 0 0 10px 0; color: #1f2937; font-weight: 700;">Pesanan Diterima</h4>
        <p style="margin: 0 0 20px 0; font-size: 0.95rem; color: #6b7280;">Beri penilaian untuk kualitas komoditas ini</p>
        
        <form action="{{ route('pembeli.pesanan.selesai', $pesanan->idPembayaran) }}" method="POST">
            @csrf
            
            <div style="font-size: 2.5rem; color: #e5e7eb; margin-bottom: 20px; display: flex; justify-content: center; gap: 5px; cursor: pointer;">
                <i class="fas fa-star star-btn-detail" data-value="1"></i>
                <i class="fas fa-star star-btn-detail" data-value="2"></i>
                <i class="fas fa-star star-btn-detail" data-value="3"></i>
                <i class="fas fa-star star-btn-detail" data-value="4"></i>
                <i class="fas fa-star star-btn-detail" data-value="5"></i>
            </div>
            
            <input type="hidden" name="Rating" id="ratingInputDetail" required>
            
            <textarea name="Ulasan" rows="3" placeholder="Ceritakan pengalaman Anda (Opsional)" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; margin-bottom: 20px; font-family: inherit; font-size: 0.95rem; resize: none; box-sizing: border-box; background: #f9fafb;"></textarea>
            
            <div style="display: flex; gap: 12px;">
                <button type="button" onclick="document.getElementById('modalUlasanDetail').style.display='none'" style="background: #f3f4f6; color: #4b5563; border: none; padding: 12px 0; border-radius: 8px; font-weight: 700; cursor: pointer; flex: 1; transition: 0.2s;">
                    Batal
                </button>
                <button type="submit" style="background: #2a7a43; color: white; border: none; padding: 12px 0; border-radius: 8px; font-weight: 700; cursor: pointer; flex: 1; box-shadow: 0 4px 6px rgba(42,122,67,0.2); transition: 0.2s;">
                    Selesaikan Pesanan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const starsDetail = document.querySelectorAll('.star-btn-detail');
    const ratingInputDetail = document.getElementById('ratingInputDetail');

    starsDetail.forEach(star => {
        star.addEventListener('click', function() {
            let value = this.getAttribute('data-value');
            ratingInputDetail.value = value;
            
            starsDetail.forEach(s => {
                if (s.getAttribute('data-value') <= value) {
                    s.style.color = '#fbbf24'; 
                    s.style.transform = 'scale(1.1)'; 
                } else {
                    s.style.color = '#e5e7eb'; 
                    s.style.transform = 'scale(1)';
                }
            });
        });
    });
</script>
@endsection