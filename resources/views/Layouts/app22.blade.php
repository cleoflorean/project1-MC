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
        <li><a href="{{ route('beranda') }}" class="nav-item {{ request()->routeIs('beranda') ? 'active' : '' }}">Beranda</a></li>
    @endguest
    
    @auth
        @if(auth()->user()->role === 'pembeli')
            <li>
                <a href="{{ route('pembeli') }}" class="nav-item {{ request()->routeIs('pembeli') ? 'active' : '' }}">
                    Dashboard
                </a>
            </li>
            <li>
    <a href="{{ route('permintaan.index') }}" class="nav-item {{ request()->routeIs('permintaan.index') ? 'active' : '' }}">
        Permintaan Saya
    </a>
</li>
        @endif

        @if(auth()->user()->role === 'petani')
            <li><a href="{{ route('petani.dashboard') }}" class="nav-item">Beranda Petani</a></li>
            <li><a href="{{ route('petani.permintaan.index') }}" class="nav-item">Cari Permintaan</a></li>
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
                    <div class="profile-section">
                    <div class="profile-avatar">{{ substr(auth()->user()->username, 0, 2) }}</div>
                    <div class="profile-info">
                    <a href="{{ route('profil') }}" class="profile-link"><span class="profile-name">{{ auth()->user()->username }}</span></a>
                    <form action="{{ route('logout') }}" method="POST">
                    @csrf
                        <button type="submit" style="background:none; border:none; color:red; cursor:pointer; font-size: 0.8rem;">Logout</button>
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