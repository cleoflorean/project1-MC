@forelse($dataPesanan as $pesanan)
<div style="border: 1px solid #e0e0e0; border-radius: 10px; padding: 20px; margin-bottom: 20px; transition: 0.2s;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f0f0f0; padding-bottom: 15px; margin-bottom: 15px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-store" style="color: #9e9e9e; font-size: 1.2rem;"></i>
            <span style="font-weight: 700; font-size: 1rem; color: #212121;">Pembeli: {{ $pesanan->penawaran->permintaan->user->username ?? 'Tidak Diketahui' }}</span>
        </div>
        
        <div>
            @php $statusPesanan = trim($pesanan->StatusPesanan); @endphp
            
            @if($statusPesanan === 'Menunggu Verifikasi Admin')
                <span style="color: #f59e0b; font-weight: 700; font-size: 0.9rem;"><i class="fas fa-clock mr-1"></i> Menunggu Verifikasi Admin</span>
            @elseif(in_array($statusPesanan, ['Pesanan Selesai', 'Selesai']))
                <span style="color: #10b981; font-weight: 700; font-size: 0.9rem;"><i class="fas fa-check-circle mr-1"></i> Selesai</span>
            @else
                <span style="color: #00aa5b; font-weight: 700; font-size: 0.9rem;">{{ $statusPesanan }}</span>
            @endif
        </div>
    </div>

    <div style="display: flex; align-items: flex-start; gap: 15px;">
        <div style="width: 80px; height: 80px; border-radius: 8px; border: 1px solid #eeeeee; overflow: hidden; background: #f9f9f9; flex-shrink: 0;">
            @if($pesanan->penawaran->Gambar)
                <img src="{{ asset('storage/' . $pesanan->penawaran->Gambar) }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #bdbdbd;"><i class="fas fa-box fa-2x"></i></div>
            @endif
        </div>
        <div style="flex-grow: 1;">
            <h5 style="margin: 0 0 5px 0; font-size: 1.1rem; font-weight: 600; color: #212121;">{{ $pesanan->penawaran->Komoditas }}</h5>
            <p style="margin: 0; font-size: 0.9rem; color: #757575;">
                {{ $pesanan->penawaran->JumlahTawar }} Kg x Rp {{ number_format($pesanan->penawaran->HargaTawar, 0, ',', '.') }}
            </p>
        </div>
        <div style="text-align: right;">
            <p style="margin: 0 0 5px 0; font-size: 0.85rem; color: #757575;">Total Belanja</p>
            <h5 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #00aa5b;">Rp {{ number_format($pesanan->TotalBayar, 0, ',', '.') }}</h5>
        </div>
    </div>

    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 15px; padding-top: 15px; border-top: 1px solid #f0f0f0;">
        <a href="{{ route('petani.pesanan.detail', $pesanan->idPembayaran) }}" style="background: white; border: 1px solid #e0e0e0; color: #757575; padding: 8px 20px; border-radius: 6px; font-weight: 600; text-decoration: none;">
            Lihat Rincian
        </a>

        @if($statusPesanan === 'Menunggu Verifikasi Admin')
            <div style="background: #fffbeb; border: 1px solid #fde68a; padding: 6px 15px; border-radius: 6px; font-size: 0.85rem; color: #d97706; font-weight: 600;">
                <i class="fas fa-shield-alt mr-1"></i> Menunggu Admin 
            </div>
        @elseif($statusPesanan === 'Petani Menyiapkan Barang')
            <form action="{{ route('petani.pesanan.kirim', $pesanan->idPembayaran) }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="background: #00aa5b; border: 1px solid #00aa5b; color: white; padding: 8px 20px; border-radius: 6px; font-weight: 600; cursor: pointer;">
                    Kirim Barang
                </button>
            </form>
        @elseif($statusPesanan === 'Dikirim')
            <button type="button" disabled style="background: #f5f5f5; border: 1px solid #e0e0e0; color: #9e9e9e; padding: 8px 20px; border-radius: 6px; font-weight: 600; cursor: not-allowed;">
                Sedang Dikirim
            </button>
        @elseif(in_array($statusPesanan, ['Pesanan Selesai', 'Selesai']))
            {{-- TAMBAHAN: Tombol Cek Rating Pembeli jika Status Selesai --}}
            @if($pesanan->ulasan)
                <button type="button" 
                        class="btn-lihat-rating"
                        data-rating="{{ $pesanan->ulasan->Rating }}"
                        data-ulasan="{{ $pesanan->ulasan->Ulasan }}"
                        data-media="{{ $pesanan->ulasan->MediaUlasan ? asset('storage/' . $pesanan->ulasan->MediaUlasan) : '' }}"
                        data-pembeli="{{ $pesanan->penawaran->permintaan->user->username ?? 'Pembeli' }}"
                        onclick="bukaModalRating(this)"
                        style="background: #fbbf24; border: 1px solid #fbbf24; color: #1e293b; padding: 8px 20px; border-radius: 6px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fas fa-star"></i> Lihat Rating
                </button>
            @else
                <span style="color: #94a3b8; font-size: 0.85rem; font-style: italic; align-self: center; font-weight: 500;">
                    Belum ada ulasan
                </span>
            @endif
        @endif
    </div>
</div>
@empty
<div style="text-align: center; padding: 50px 20px; background: white; border-radius: 8px; border: 1px dashed #e0e0e0;">
    <i class="fas fa-box-open" style="font-size: 3rem; color: #e0e0e0; margin-bottom: 15px;"></i>
    <h5 style="margin: 0 0 5px 0; color: #757575;">Belum ada pesanan</h5>
    <p style="margin: 0; color: #9e9e9e; font-size: 0.9rem;">Pesanan yang masuk akan tampil di sini.</p>
</div>
@endforelse