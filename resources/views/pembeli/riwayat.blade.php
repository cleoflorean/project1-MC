@extends('layouts.app22')
@section('title', 'Riwayat Transaksi Saya')

@section('content')
<!-- Background abu-abu muda khas halaman pesanan e-commerce -->
<div class="bg-light pb-5 pt-4">
    <div class="container" style="max-width: 1000px;">

        <!-- Header -->
        <h4 class="mb-3 fw-bold text-dark">Riwayat Transaksi</h4>

        @php
            $currentStatus = request()->query('status', 'semua');
            
            $filteredRiwayat = $riwayat->filter(function($pesanan) use ($currentStatus) {
                $sudahUpload = !empty($pesanan->BuktiTransfer);
                
                // PERBAIKAN: Pisahkan status pembayaran dan pengiriman
                $statPembayaran = trim($pesanan->StatusPembayaran);
                $statPengiriman = trim(optional($pesanan->pengiriman)->StatusPesanan);

                if ($currentStatus == 'belum-bayar') return in_array($statPembayaran, ['Menunggu Pembayaran', 'Belum Bayar', 'Belum Dibayar']) || !$sudahUpload;
                if ($currentStatus == 'diproses') return $statPembayaran == 'Menunggu Verifikasi Admin' || $statPengiriman == 'Petani Menyiapkan Barang';
                if ($currentStatus == 'dikirim') return $statPengiriman == 'Dikirim';
                if ($currentStatus == 'selesai') return in_array($statPengiriman, ['Pesanan Selesai', 'Selesai']);
                return true; 
            });
        @endphp

        <!-- TABS NAVIGASI (Shopee Style) -->
        <div class="card border-0 rounded-0 shadow-sm mb-3">
            <div class="d-flex text-center">
                <a href="?status=semua" class="flex-fill py-3 text-decoration-none {{ $currentStatus == 'semua' ? 'text-success fw-bold border-bottom border-success' : 'text-dark' }}" style="{{ $currentStatus == 'semua' ? 'border-bottom-width: 3px !important;' : '' }}">Semua</a>
                
                <a href="?status=belum-bayar" class="flex-fill py-3 text-decoration-none {{ $currentStatus == 'belum-bayar' ? 'text-success fw-bold border-bottom border-success' : 'text-dark' }}" style="{{ $currentStatus == 'belum-bayar' ? 'border-bottom-width: 3px !important;' : '' }}">Belum Bayar</a>
                
                <a href="?status=diproses" class="flex-fill py-3 text-decoration-none {{ $currentStatus == 'diproses' ? 'text-success fw-bold border-bottom border-success' : 'text-dark' }}" style="{{ $currentStatus == 'diproses' ? 'border-bottom-width: 3px !important;' : '' }}">Sedang Diproses</a>
                
                <a href="?status=dikirim" class="flex-fill py-3 text-decoration-none {{ $currentStatus == 'dikirim' ? 'text-success fw-bold border-bottom border-success' : 'text-dark' }}" style="{{ $currentStatus == 'dikirim' ? 'border-bottom-width: 3px !important;' : '' }}">Dikirim</a>
                
                <a href="?status=selesai" class="flex-fill py-3 text-decoration-none {{ $currentStatus == 'selesai' ? 'text-success fw-bold border-bottom border-success' : 'text-dark' }}" style="{{ $currentStatus == 'selesai' ? 'border-bottom-width: 3px !important;' : '' }}">Selesai</a>
            </div>
        </div>

        <!-- DAFTAR TRANSAKSI -->
        @forelse($filteredRiwayat as $pesanan)
        
        @php 
            // Ambil status di awal agar mudah dipanggil di bawah
            $statPembayaran = trim($pesanan->StatusPembayaran);
            $statPengiriman = trim(optional($pesanan->pengiriman)->StatusPesanan);
        @endphp

        <div class="card border-0 shadow-sm mb-3 rounded-0">
            
            <!-- Header Toko & Status -->
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <span class="badge bg-success me-2 rounded-1 px-2 py-1">Mitra Petani</span>
                    <span class="fw-bold text-dark me-3">{{ $pesanan->penawaran->petani->username ?? 'Nama Petani' }}</span>
                    
                    <!-- Fitur Chat Ke WhatsApp -->
                    @php
                        $noTelp = $pesanan->penawaran->petani->no_hp ?? ''; 
                        if(strpos($noTelp, '0') === 0) {
                            $noTelp = '62' . substr($noTelp, 1);
                        }
                        $namaKomoditas = $pesanan->penawaran->permintaan->Komoditas ?? $pesanan->penawaran->permintaan->NamaTanaman ?? 'produk ini';
                        $pesanWA = "Halo, saya ingin bertanya mengenai pesanan saya untuk {$namaKomoditas}.";
                    @endphp

                    <a href="https://wa.me/{{ $noTelp }}?text={{ urlencode($pesanWA) }}" target="_blank" class="btn btn-sm btn-outline-success px-2 py-0 me-2" style="font-size: 0.8rem;">
                        <i class="fab fa-whatsapp"></i> Chat
                    </a>
                </div>

                <div class="d-flex align-items-center">
                    <!-- PERBAIKAN LOGIKA STATUS UNTUK LABEL -->
                    @if(in_array($statPembayaran, ['Menunggu Pembayaran', 'Belum Bayar', 'Belum Dibayar']) || empty($pesanan->BuktiTransfer))
                        <span class="text-danger me-2"><i class="fas fa-exclamation-circle"></i> Menunggu Pembayaran.</span>
                        <span class="text-danger fw-bold border-start border-2 ps-2">BELUM BAYAR</span>
                    @elseif($statPembayaran === 'Menunggu Verifikasi Admin' && !in_array($statPengiriman, ['Dikirim', 'Pesanan Selesai', 'Selesai']))
                        <span class="text-warning text-dark me-2"><i class="fas fa-clock"></i> Sedang dicek oleh Admin.</span>
                        <span class="text-warning fw-bold border-start border-2 ps-2">DIPROSES</span>
                    @elseif($statPengiriman === 'Petani Menyiapkan Barang')
                        <span class="text-primary me-2"><i class="fas fa-box"></i> Petani menyiapkan pesanan.</span>
                        <span class="text-primary fw-bold border-start border-2 ps-2">DIKEMAS</span>
                    @elseif($statPengiriman === 'Dikirim')
                        <span class="text-success me-2"><i class="fas fa-truck"></i> Pesanan dalam perjalanan. <i class="far fa-question-circle text-muted"></i></span>
                        <span class="text-success fw-bold border-start border-2 ps-2">DIKIRIM</span>
                    @elseif(in_array($statPengiriman, ['Pesanan Selesai', 'Selesai']))
                        <span class="text-success me-2"><i class="fas fa-check-circle"></i> Pesanan tiba di alamat tujuan.</span>
                        <span class="text-success fw-bold border-start border-2 ps-2">SELESAI</span>
                    @else
                        <span class="text-secondary fw-bold">{{ strtoupper($statPengiriman ?: $statPembayaran) }}</span>
                    @endif
                </div>
            </div>

            <!-- Body Produk -->
            <div class="card-body bg-white border-bottom py-3">
                <div class="d-flex">
                    <!-- Foto Produk (Sudah Dirapikan) -->
                    <div class="me-3 flex-shrink-0" style="width: 80px; height: 80px; border-radius: 4px; overflow: hidden; border: 1px solid #eaeaea;">
                        @if(!empty($pesanan->penawaran?->Gambar))
                            <img src="{{ asset($pesanan->penawaran->Gambar) }}" alt="Foto Produk" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex justify-content-center align-items-center text-muted" style="width: 100%; height: 100%;">
                                <i class="fas fa-image fa-2x"></i>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Detail Produk -->
                    <div class="flex-grow-1">
                        <h6 class="mb-1 text-dark fs-6">{{ $pesanan->penawaran->permintaan->NamaTanaman ?? 'Nama Tanaman Terhapus' }}</h6>
                        <p class="text-muted mb-0 small">Kuantitas: {{ $pesanan->penawaran->JumlahTawar ?? 0 }} Kg</p>
                    </div>

                    <!-- Harga Produk -->
                    <div class="text-end">
                        <span class="text-dark">Rp{{ number_format($pesanan->penawaran->HargaTawar ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer Total & Aksi -->
            <div class="card-body bg-white bg-opacity-50">
                <div class="d-flex justify-content-end align-items-center mb-4">
                    <span class="text-dark me-2"><i class="fas fa-shield-alt text-success"></i> Total Pesanan:</span>
                    <span class="text-success fs-4 fw-bold">Rp{{ number_format($pesanan->TotalBayar, 0, ',', '.') }}</span>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('detail', $pesanan->idPembayaran) }}" class="btn btn-outline-secondary px-4">Tampilkan Rincian</a>

                    <!-- PERBAIKAN LOGIKA STATUS UNTUK TOMBOL AKSI -->
                    @if(in_array($statPembayaran, ['Menunggu Pembayaran', 'Belum Bayar', 'Belum Dibayar']) || empty($pesanan->BuktiTransfer))
                        <a href="{{ route('pembayaran.show', $pesanan->idTawar) }}" class="btn btn-success px-5 fw-bold">Bayar Sekarang</a>

                    @elseif($statPengiriman === 'Dikirim')
                        <form action="{{ route('pembeli.pesanan.selesai', $pesanan->idPembayaran) }}" method="POST" class="m-0" onsubmit="return confirm('Selesaikan pesanan ini?')">
                            @csrf
                            <button type="submit" class="btn btn-success px-5 fw-bold">Pesanan Diterima</button>
                        </form>

                    @elseif(in_array($statPengiriman, ['Pesanan Selesai', 'Selesai']))
                        @if(!$pesanan->ulasan)
                            <button type="button" class="btn btn-success px-5 fw-bold" data-bs-toggle="modal" data-bs-target="#modalUlasan-{{ $pesanan->idPembayaran }}">
                                Nilai
                            </button>
                        @else
                            <button class="btn btn-outline-secondary px-4" disabled>Sudah Dinilai</button>
                            <button type="button" class="btn btn-outline-success px-4">Beli Lagi</button>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal Ulasan Bootstrap -->
        @if(in_array($statPengiriman, ['Pesanan Selesai', 'Selesai']) && !$pesanan->ulasan)
        <div class="modal fade" id="modalUlasan-{{ $pesanan->idPembayaran }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-0">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title fw-bold">Nilai Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center pt-0">
                        <form action="{{ route('pembeli.ulasan', $pesanan->idPembayaran) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="fs-1 text-warning mb-3" style="cursor: pointer;">
                                @for($i=1; $i<=5; $i++)
                                    <i class="far fa-star star-btn-{{ $pesanan->idPembayaran }}" data-value="{{ $i }}" onclick="setRating({{ $pesanan->idPembayaran }}, {{ $i }})"></i>
                                @endfor
                            </div>
                            <input type="hidden" name="Rating" id="ratingInput-{{ $pesanan->idPembayaran }}" required>
                            <textarea name="Ulasan" class="form-control mb-3 rounded-0" rows="3" placeholder="Bagaimana kualitas produk ini?"></textarea>
                            <div class="mb-4 text-start">
                                <label class="btn btn-outline-success w-100 py-3 rounded-0" style="border: 1px dashed #198754;">
                                    <i class="fas fa-camera fs-4 d-block mb-1"></i> Tambah Foto
                                    <input type="file" name="MediaUlasan" accept="image/*,video/*" class="d-none">
                                </label>
                            </div>
                            <button type="submit" class="btn btn-success w-100 fw-bold rounded-0">Kirim Penilaian</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @empty
        <!-- Jika Kosong -->
        <div class="card border-0 shadow-sm rounded-0 p-5 text-center">
            <div class="text-muted mb-3">
                <i class="fas fa-receipt fa-4x opacity-25"></i>
            </div>
            <h5 class="text-dark">Belum ada pesanan</h5>
        </div>
        @endforelse

    </div>
</div>

<script>
    function setRating(id, value) {
        document.getElementById('ratingInput-' + id).value = value;
        let stars = document.querySelectorAll('.star-btn-' + id);
        stars.forEach(s => {
            if (s.getAttribute('data-value') <= value) {
                s.classList.remove('far');
                s.classList.add('fas');
            } else {
                s.classList.remove('fas');
                s.classList.add('far');
            }
        });
    }
</script>
@endsection