@extends('layouts.app22')

@section('title', 'Beranda - Tani Harvest')

@section('content')
<!-- Hero Section -->
<section class="hero-section position-relative overflow-hidden">
    <div class="container position-relative z-index-1">
        <div class="row align-items-center justify-content-center min-vh-75 py-5">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 fw-extrabold text-dark mb-4 animate-fade-in-up" style="animation-delay: 0.2s; letter-spacing: -1px;">
                    Dapatkan Komoditas Pertanian Terbaik <span class="text-gradient">Langsung dari Petani</span>
                </h1>
                <p class="lead text-secondary mb-5 px-lg-5 animate-fade-in-up" style="animation-delay: 0.3s; font-size: 1.25rem;">
                    Buat permintaan produk yang Anda butuhkan, dan biarkan ribuan petani memberikan penawaran terbaik mereka. Transparan, efisien, dan menguntungkan untuk bisnis Anda.
                </p>
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 animate-fade-in-up" style="animation-delay: 0.4s;">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-premium btn-lg px-5 py-3 fw-bold rounded-pill shadow-sm">
                            Buat Permintaan Sekarang <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="#cara-kerja" class="btn btn-outline-dark btn-lg px-5 py-3 fw-bold rounded-pill">
                            Pelajari Cara Kerja
                        </a>
                    @endguest
                    
                    @auth
                        <a href="{{ route('pembeli') }}" class="btn btn-premium btn-lg px-5 py-3 fw-bold rounded-pill shadow-sm">
                            Ke Dashboard <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
</section>

<!-- Cara Kerja Section -->
<section id="cara-kerja" class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark">Cara Kerja yang Mudah</h2>
            <p class="text-secondary">Tiga langkah sederhana untuk memenuhi kebutuhan pasokan Anda.</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Step 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="step-card h-100 p-5 bg-white rounded-4 shadow-sm text-center position-relative">
                    <div class="step-number">1</div>
                    <div class="icon-box bg-success-subtle text-success rounded-circle mb-4 mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-edit fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Buat Permintaan</h4>
                    <p class="text-secondary mb-0">Tentukan jenis komoditas, jumlah, spesifikasi, dan harga yang Anda harapkan.</p>
                </div>
            </div>
            
            <!-- Step 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="step-card h-100 p-5 bg-white rounded-4 shadow-sm text-center position-relative">
                    <div class="step-number">2</div>
                    <div class="icon-box bg-success-subtle text-success rounded-circle mb-4 mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-comments-dollar fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Terima Penawaran</h4>
                    <p class="text-secondary mb-0">Petani akan melihat permintaan Anda dan mengirimkan penawaran harga terbaik mereka.</p>
                </div>
            </div>
            
            <!-- Step 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="step-card h-100 p-5 bg-white rounded-4 shadow-sm text-center position-relative">
                    <div class="step-number">3</div>
                    <div class="icon-box bg-success-subtle text-success rounded-circle mb-4 mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-handshake fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Pilih & Transaksi</h4>
                    <p class="text-secondary mb-0">Bandingkan kualitas dan harga, pilih penawaran yang paling sesuai, lalu selesaikan transaksi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Bottom -->
<section class="cta-bottom py-5 bg-white">
    <div class="container py-5">
        <div class="cta-box bg-dark text-white rounded-5 p-5 text-center position-relative overflow-hidden shadow-lg" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <div class="position-relative z-index-1">
                <h2 class="display-6 fw-bold mb-3 text-white">Siap Mendapatkan Pasokan Terbaik?</h2>
                <p class="lead mb-4 text-white-50">Bergabunglah dengan ribuan pembeli lainnya di Tani Harvest.</p>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-premium btn-lg px-5 py-3 fw-bold rounded-pill">
                        Daftar Gratis Sekarang
                    </a>
                @else
                    <a href="{{ route('permintaan.index') }}" class="btn btn-premium btn-lg px-5 py-3 fw-bold rounded-pill">
                        Lihat Permintaan Saya
                    </a>
                @endguest
            </div>
            <!-- Decorative circle -->
            <div class="cta-circle"></div>
        </div>
    </div>
</section>
@endsection