@extends('layouts.app22')

@section('title', 'Dashboard Pembeli')

@section('content')
<div class="container py-2">
    
    <!-- HEADER WELCOME -->
    <header class="mb-4">
        <h1 class="h3 fw-bold text-dark">Selamat Datang Kembali</h1>
        <p class="text-secondary mb-0">Kelola permintaan pengadaan dan pantau penawaran secara real-time.</p>
    </header>

    <!-- GRID SISTEM BOOTSTRAP -->
    <div class="row g-4">
        
        <!-- KOLOM UTAMA (PENAWARAN MASUK) -->
        <div class="col-12 col-lg-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold text-dark">Penawaran Terbaru Masuk</h5>
                </div>
                
                <div class="card-body p-4">
                    <div class="product-grid">
                        @forelse($penawarans ?? [] as $tawar)
                            <div class="product-card">
                                <!-- Wrapper Image (Rasio Kotak 1:1) -->
                                <div class="product-image-wrapper" style="position: relative; overflow: hidden; aspect-ratio: 1/1;">
                                    
                                    <!-- FOTO PRODUK DINAMIS (DARI CONTROLLER PETANI) -->
                                    @if($tawar->Gambar && file_exists(public_path($tawar->Gambar)))
                                        <!-- Menampilkan foto yang diupload petani -->
                                        <img src="{{ asset($tawar->Gambar) }}" alt="{{ $tawar->permintaan->NamaTanaman ?? 'Komoditas' }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <!-- Default Placeholder jika petani tidak upload foto -->
                                        <img src="https://placehold.co/400x400?text=Tidak+Ada+Foto" alt="No Image" style="width: 100%; height: 100%; object-fit: cover;">
                                    @endif
                                    
                                    <!-- Badges Status -->
                                    @php
                                        $statusClass = '';
                                        if($tawar->Status === 'Pending') $statusClass = 'status-pending';
                                        elseif($tawar->Status === 'Setuju') $statusClass = 'status-setuju';
                                        else $statusClass = 'status-tolak';
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ $tawar->Status }}
                                    </span>
                                </div>
                                
                                <!-- Detail Info Produk -->
                                <div class="product-info-body">
                                    <h4 class="product-title">
                                        {{ $tawar->permintaan->NamaTanaman ?? 'Permintaan #'.$tawar->idMinta }}
                                    </h4>
                                    <p class="product-seller mb-1">
                                        <i class="fas fa-store me-1" style="font-size: 0.75rem;"></i> 
                                        {{ $tawar->petani?->profile?->NamaLengkap ?? $tawar->petani?->username ?? 'Petani Tidak Diketahui' }}
                                    </p>
                                    <p class="product-category mb-2">
                                        {{ $tawar->permintaan->Komoditas ?? '-' }}
                                    </p>
                                    
                                    <div class="product-meta-row">
                                        <div class="product-price">
                                            Rp {{ number_format($tawar->HargaTawar, 0, ',', '.') }}<span class="price-unit">/kg</span>
                                        </div>
                                        <div class="product-stock mt-1">
                                            Stok: {{ number_format($tawar->JumlahTawar, 0, ',', '.') }} kg
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Tampilan Jika Data Kosong -->
                            <div class="text-center py-5 w-100" style="grid-column: 1 / -1;">
                                <i class="fas fa-box-open text-muted mb-3" style="font-size: 3rem;"></i>
                                <p class="text-secondary mb-0">Belum ada penawaran masuk untuk permintaan Anda.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- =========================================================================
             FORM BUAT PERMINTAAN PENGADAAN (DI-KOMENTARI / DISABLED)
             ========================================================================= --}}
        
        {{-- 
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 p-4">
                <h5 class="fw-bold text-dark mb-3">Buat Permintaan Pengadaan</h5>
                
                @if(session('success'))
                    <div class="alert alert-success py-2 px-3 mb-3 fs-6" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('permintaan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-secondary fw-semibold small">Nama Tanaman</label>
                        <input type="text" name="NamaTanaman" class="form-control" placeholder="Contoh: Cabai Rawit" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary fw-semibold small">Komoditas</label>
                        <select name="komoditas" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="Sayur">Sayur</option>
                            <option value="Kacang-Kacangan">Kacang-Kacangan</option>
                            <option value="Buah-Buahan">Buah-Buahan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary fw-semibold small">Volume (kg)</label>
                        <input type="number" name="volume" class="form-control" placeholder="2500" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary fw-semibold small">Harga Maksimal (Rp)</label>
                        <input type="number" name="batas_harga" class="form-control" placeholder="30000" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary fw-semibold small">Batas Tanggal</label>
                        <input type="date" name="batas_akhir" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2 fw-semibold" style="border-radius: 6px;">
                        Kirim Permintaan
                    </button>
                </form>
            </div>
        </div>
        --}}

    </div>
</div>
@endsection