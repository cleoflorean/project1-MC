{{-- LAYOUT UTAMA (PEMBELI & PETANI) --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tani Harvest - Platform Komoditas')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (Icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://api.fontshare.com">
    <link rel="preconnect" href="https://cdn.fontshare.com" crossorigin>
    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@1&f[]=cabinet-grotesk@1&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('pembeli.css') }}">

    <style>
        body {
            margin: 0;
            font-family: 'Satoshi', system-ui, sans-serif;
            background-color: #f6f7f4;
        }
        a {
            color: inherit;
            text-decoration: none;
        }
        a:hover {
            opacity: .88;
        }
        h1, h2, h3 {
            font-family: 'Cabinet Grotesk', 'Satoshi', system-ui, sans-serif;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR FLOATING PILL -->
    <div class="container pt-3 pb-2">
        <nav class="navbar navbar-expand-lg bg-white shadow-sm px-4 py-2 mx-auto" style="border-radius: 50px; max-width: 1040px; border: 1px solid #f1f5f9;">
            <div class="container-fluid">
                <!-- Logo Tani Harvest -->
                <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-success" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Tani Harvest Logo" style="height: 40px; width: auto; margin-right: 12px; object-fit: contain;">
                    <span>Tani Harvest</span>
                </a>

                <!-- Tombol Hamburger Mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu Navigation -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-2 gap-lg-3">
                        @guest
                            <li class="nav-item">
                                <a href="#cara-kerja" class="nav-link text-secondary fw-medium text-nowrap">Cara kerja</a>
                            </li>
                            <li class="nav-item">
                                <a href="#peran" class="nav-link text-secondary fw-medium text-nowrap">Untuk siapa</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kurir.landing') }}" class="nav-link text-secondary fw-medium text-nowrap">Untuk kurir</a>
                            </li>
                        @endguest

                        @auth
                            @if(strtolower(auth()->user()->role) === 'pembeli')
                                <li class="nav-item">
                                    <a href="{{ route('pembeli') }}" class="nav-link fw-semibold text-nowrap {{ request()->routeIs('pembeli') ? 'text-success active' : 'text-secondary' }}">
                                        Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('permintaan.index') }}" class="nav-link fw-semibold text-nowrap {{ request()->routeIs('permintaan.index') && !request()->routeIs('permintaan.penawaran') ? 'text-success active' : 'text-secondary' }}">
                                        Permintaan Saya
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('permintaan.index') }}" class="nav-link fw-semibold text-nowrap {{ request()->routeIs('permintaan.penawaran') ? 'text-success active' : 'text-secondary' }}">
                                        Penawaran Masuk
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('pembeli.riwayat') }}" class="nav-link fw-semibold text-nowrap {{ request()->routeIs('pembeli.riwayat') ? 'text-success active' : 'text-secondary' }}">
                                        Riwayat Transaksi
                                    </a>
                                </li>
                            @endif

                            @if(strtolower(auth()->user()->role) === 'petani')
                                <li class="nav-item">
                                    <a href="{{ route('petani.dashboard') }}" class="nav-link fw-semibold text-nowrap {{ request()->routeIs('petani.dashboard') ? 'text-success active' : 'text-secondary' }}">
                                        Beranda Petani
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('petani.permintaan.index') }}" class="nav-link fw-semibold text-nowrap {{ request()->routeIs('petani.permintaan.index') ? 'text-success active' : 'text-secondary' }}">
                                        Cari Permintaan
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Bagian Kanan: Tombol Masuk/Daftar atau Dropdown Profil -->
                    <div class="d-flex align-items-center gap-2">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-link text-success fw-semibold text-decoration-none text-nowrap">Masuk</a>
                            <a href="{{ route('register') }}" class="btn btn-success px-4 rounded-pill fw-semibold text-nowrap" style="background-color: #14532d; border-color: #14532d;">Daftar</a>
                        @else
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 fw-semibold text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                        {{ strtoupper(substr(auth()->user()->username ?? 'U', 0, 1)) }}
                                    </span>
                                    <span>{{ auth()->user()->username }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" style="border-radius: 12px;">
                                    <li>
                                        <a class="dropdown-item py-2" href="{{ route('profil') }}">
                                            <i class="fas fa-user-circle me-2 text-secondary"></i> Profil
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i> Keluar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <!-- CONTENT -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- SIMPEL FOOTER -->
    <footer class="bg-white border-top py-4 text-center text-secondary mt-5">
        <div class="container">
            <span class="fw-semibold text-success">Tani Harvest</span>
            <p class="mb-0 mt-1" style="font-size: 0.85rem;">&copy; {{ date('Y') }} Tani Harvest. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>