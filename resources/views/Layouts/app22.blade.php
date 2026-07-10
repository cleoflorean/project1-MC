<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Platform Komoditas')</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('pembeli.css') }}">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            
            <div class="nav-left">
                <div class="logo">
                    <i class="fas fa-leaf"></i> TaniHarvest
                </div>
                
                <ul class="nav-menu">
                    @guest
                        <li>
                            <a href="{{ route('beranda') }}" class="nav-item {{ request()->routeIs('beranda') ? 'active' : '' }}">
                                Beranda
                            </a>
                        </li>
                    @endguest
                    
                    @auth
                        @if(auth()->user()->role === 'pembeli')
                            <li>
                                <a href="{{ route('pembeli') }}" class="nav-item {{ request()->routeIs('pembeli') ? 'active' : '' }}">
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('permintaan.index') }}" class="nav-item {{ request()->routeIs('permintaan.index') && !request()->routeIs('permintaan.penawaran') ? 'active' : '' }}">
                                    Permintaan Saya
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('permintaan.index') }}" class="nav-item {{ request()->routeIs('permintaan.penawaran') ? 'active' : '' }}">
                                    Penawaran Masuk
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold {{ request()->routeIs('pembeli.riwayat') ? 'active text-success' : 'text-dark' }}" href="{{ route('pembeli.riwayat') }}">
                                    <i class="fas fa-receipt"></i> Riwayat Transaksi
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->role === 'petani')
                            <li>
                                <a href="{{ route('petani.dashboard') }}" class="nav-item {{ request()->routeIs('petani.dashboard') ? 'active' : '' }}">
                                    Beranda Petani
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('petani.permintaan.index') }}" class="nav-item {{ request()->routeIs('petani.permintaan.index') ? 'active' : '' }}">
                                    Cari Permintaan
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
            
            <div class="nav-right">
                @guest
                    <a href="{{ route('login') }}" style="margin-right: 15px; color: #2e7d32; font-weight: 600; text-decoration: none;">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary" style="padding: 8px 20px; border-radius: 6px; background-color: #2e7d32; color: white; text-decoration: none;">Daftar</a>
                @endguest

                @auth
                    <div class="profile-section" style="display: flex; align-items: center; gap: 12px;">
                        <div class="profile-avatar" style="text-transform: uppercase;">
                            {{ substr(auth()->user()->username, 0, 2) }}
                        </div>
                        <div class="profile-info" style="display: flex; flex-direction: column;">
                            <a href="{{ route('profil') }}" class="profile-link" style="text-decoration: none; color: #333; font-weight: 600;">
                                <span class="profile-name">{{ auth()->user()->username }}</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" style="background: none; border: none; color: red; cursor: pointer; font-size: 0.8rem; padding: 0; text-align: left;">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
            
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    <script src="{{ asset('/pembeli.js') }}"></script>
</body>
</html>