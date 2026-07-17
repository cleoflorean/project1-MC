<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Platform Komoditas')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (Icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('pembeli.css') }}">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top py-3">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center fw-bold text-success" href="#" style="font-size: 1.3rem;">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Tani Harvest Logo" style="height: 40px; width: auto; margin-right: 12px; object-fit: contain;">
                Tani Harvest
            </a>

            <!-- Toggle Button for Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Navigation -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-2">
                    @guest
                        <li class="nav-item">
                            <a href="{{ route('beranda') }}" class="nav-link fw-semibold {{ request()->routeIs('beranda') ? 'text-success active' : 'text-secondary' }}">
                                Beranda
                            </a>
                        </li>
                    @endguest
                    
                    @auth
                        @if(auth()->user()->role === 'pembeli')
                            <li class="nav-item">
                                <a href="{{ route('pembeli') }}" class="nav-link fw-semibold {{ request()->routeIs('pembeli') ? 'text-success active' : 'text-secondary' }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('permintaan.index') }}" class="nav-link fw-semibold {{ request()->routeIs('permintaan.index') && !request()->routeIs('permintaan.penawaran') ? 'text-success active' : 'text-secondary' }}">
                                    Permintaan Saya
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('permintaan.index') }}" class="nav-link fw-semibold {{ request()->routeIs('permintaan.penawaran') ? 'text-success active' : 'text-secondary' }}">
                                    Penawaran Masuk
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold {{ request()->routeIs('pembeli.riwayat') ? 'text-success active' : 'text-secondary' }}" href="{{ route('pembeli.riwayat') }}">
                                    Riwayat Transaksi
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->role === 'petani')
                            <li class="nav-item">
                                <a href="{{ route('petani.dashboard') }}" class="nav-link fw-semibold {{ request()->routeIs('petani.dashboard') ? 'text-success active' : 'text-secondary' }}">
                                    Beranda Petani
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('petani.permintaan.index') }}" class="nav-link fw-semibold {{ request()->routeIs('petani.permintaan.index') ? 'text-success active' : 'text-secondary' }}">
                                    Cari Permintaan
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <!-- Profile / Auth Area -->
                <div class="d-flex align-items-center ms-auto">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-link text-success fw-bold text-decoration-none me-2">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-success px-4 py-2" style="border-radius: 6px;">Daftar</a>
                    @endguest

                    @auth
                        <!-- DROPDOWN PROFIL -->
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0;">
                                
                                <!-- Foto Profil Bulat -->
                                <div class="profile-avatar-circle" style="width: 38px; height: 38px; font-size: 0.8rem;">
                                    @php
                                        // Ambil foto dari profile pembeli jika ada
                                        $fotoProfil = auth()->user()->pembeliProfile?->FotoProfile;
                                    @endphp

                                    @if($fotoProfil) 
                                        <!-- Menampilkan foto yang di-upload dari controller Anda -->
                                        <img src="{{ asset($fotoProfil) }}" alt="Profil">
                                    @else
                                        <!-- Default jika belum mengupload foto (Inisial Nama) -->
                                        <span>{{ strtoupper(substr(auth()->user()->username, 0, 2)) }}</span>
                                    @endif
                                </div>
                                
                                <span class="fw-bold text-dark">{{ auth()->user()->username }}</span>
                            </a>
                            
                            <!-- Isi Dropdown Menu -->
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('profil') }}">
                                        <i class="fas fa-user-circle fa-fw text-secondary me-2"></i> Profil Saya
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger fw-semibold">
                                            <i class="fas fa-sign-out-alt fa-fw me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <main class="flex-grow-1 py-4">
        @yield('content')
    </main>

    <!-- SIMPEL FOOTER -->
    <footer class="bg-white border-top py-4 text-center text-secondary">
        <div class="container">
            <span class="fw-semibold text-success">Tani Harvest</span>
            <p class="mb-0 mt-1" style="font-size: 0.85rem;">&copy; {{ date('Y') }} Tani Harvest. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('/pembeli.js') }}"></script>
</body>
</html>