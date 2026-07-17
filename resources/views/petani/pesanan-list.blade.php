@forelse($dataPesanan as $pesanan)
<div class="tc-premium-container bg-white border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
    
    {{-- Header Kartu: Toko & Status --}}
    <div class="d-flex justify-content-between align-items-center p-3 border-bottom" style="background-color: #fafafa;">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-store text-secondary fs-5"></i>
            <span class="fw-bold text-dark fs-6">{{ $pesanan->penawaran->permintaan->user->username ?? 'Tidak Diketahui' }}</span>
        </div>
        
        <div class="text-end">
            @php $statusPesanan = trim($pesanan->StatusPesanan); @endphp
            
            @if($statusPesanan === 'Menunggu Verifikasi Admin')
                <span class="text-warning fw-bold small text-uppercase"><i class="fas fa-clock me-1"></i> Menunggu Admin</span>
            @elseif(in_array($statusPesanan, ['Pesanan Selesai', 'Selesai']))
                <span class="text-success fw-bold small text-uppercase"><i class="fas fa-check-circle me-1"></i> Selesai</span>
            @else
                <span class="text-success fw-bold small text-uppercase">{{ $statusPesanan }}</span>
            @endif
        </div>
    </div>

    {{-- Body Kartu: Detail Produk --}}
    <div class="p-3 shadow-sm-hover transition-all" style="background-color: #ffffff;">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="rounded-3 border overflow-hidden bg-light d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    @if($pesanan->penawaran->Gambar)
                        <img src="{{ asset($pesanan->penawaran->Gambar) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="Produk">
                    @else
                        <i class="fas fa-box fa-2x text-muted opacity-50"></i>
                    @endif
                </div>
            </div>
            <div class="col">
                <h5 class="fw-bold text-dark mb-1 fs-5">{{ $pesanan->penawaran->Komoditas }}</h5>
                <p class="mb-1 text-secondary small">
                    <i class="bi bi-box me-1"></i> {{ number_format($pesanan->penawaran->JumlahTawar, 0, ',', '.') }} Kg
                </p>
            </div>
            <div class="col-auto text-end">
                <div class="text-dark small mb-1">Harga Satuan</div>
                <div class="fw-semibold text-dark">
                    Rp {{ number_format($pesanan->penawaran->HargaTawar, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Kartu: Total & Aksi --}}
    <div class="p-3" style="background-color: #fafafa;">
        <div class="d-flex justify-content-end align-items-center mb-3">
            <span class="text-secondary me-3 small">Total Pesanan:</span>
            <span class="fs-5 fw-bold text-success">Rp {{ number_format($pesanan->TotalBayar, 0, ',', '.') }}</span>
        </div>
        
        <div class="d-flex justify-content-end align-items-center gap-2 border-top pt-3">
            <a href="{{ route('petani.pesanan.detail', $pesanan->idPembayaran) }}" class="btn btn-outline-secondary px-4 fw-semibold rounded-pill bg-white">
                Lihat Rincian
            </a>

            @if($statusPesanan === 'Menunggu Verifikasi Admin')
                <div class="btn btn-light text-warning fw-bold border-warning px-4 rounded-pill disabled" style="opacity: 1; background: #fffbeb;">
                    <i class="fas fa-shield-alt me-1"></i> Verifikasi Admin 
                </div>
            @elseif($statusPesanan === 'Petani Menyiapkan Barang')
                <form action="{{ route('petani.pesanan.kirim', $pesanan->idPembayaran) }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-premium px-4 fw-bold rounded-pill shadow-sm">
                        Kirim Barang
                    </button>
                </form>
            @elseif($statusPesanan === 'Dikirim')
                <button type="button" disabled class="btn btn-secondary px-4 fw-bold rounded-pill disabled" style="cursor: not-allowed; opacity: 0.7;">
                    Sedang Dikirim
                </button>
            @elseif(in_array($statusPesanan, ['Pesanan Selesai', 'Selesai']))
                @if($pesanan->ulasan)
                    <button type="button" 
                            class="btn btn-warning px-4 fw-bold rounded-pill shadow-sm text-dark"
                            data-rating="{{ $pesanan->ulasan->Rating }}"
                            data-ulasan="{{ $pesanan->ulasan->Ulasan }}"
                            data-media="{{ $pesanan->ulasan->MediaUlasan ? asset('storage/' . $pesanan->ulasan->MediaUlasan) : '' }}"
                            data-pembeli="{{ $pesanan->penawaran->permintaan->user->username ?? 'Pembeli' }}"
                            onclick="bukaModalRating(this)">
                        <i class="fas fa-star me-1"></i> Lihat Rating
                    </button>
                @else
                    <span class="text-muted small fst-italic px-3">
                        Belum ada ulasan
                    </span>
                @endif
            @endif
        </div>
    </div>
</div>
@empty
<div class="tc-empty-state py-5 text-center bg-white rounded-4 shadow-sm border-0 mt-4">
    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
        <i class="fas fa-box-open fs-1 text-muted opacity-50"></i>
    </div>
    <h5 class="fw-bold text-dark">Belum ada pesanan</h5>
    <p class="text-muted">Pesanan yang masuk akan tampil di sini.</p>
</div>
@endforelse