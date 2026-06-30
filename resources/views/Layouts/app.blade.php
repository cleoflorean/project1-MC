<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Token CSRF untuk keamanan request POST --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TaniConnect - @yield('title', 'Dashboard Petani')</title>

    {{-- Google Fonts: Nunito untuk body, untuk heading --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Nunito:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 untuk grid dan komponen dasar --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons untuk ikon sidebar dan navbar --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    {{-- CSS kustom TaniConnect --}}
    <link rel="stylesheet" href="{{ asset('css/tanidashboard.css') }}">

    @stack('styles')
</head>
<body>

{{-- ============================================================
     SIDEBAR - Menu navigasi kiri
     Ditampilkan di semua halaman setelah login.
     Berisi logo, menu utama, dan badge notifikasi.
     ============================================================ --}}
<aside class="tc-sidebar" id="sidebar">

    {{-- Logo TaniConnect --}}
    <div class="tc-sidebar-logo">
        <div class="tc-logo-icon">
            <i class="fas fa-leaf"></i>
        </div>
        <div class="tc-logo-text-container">
            <div class="tc-logo-name">TaniHarvest</div>
            <div class="tc-logo-sub">PETANI</div>
        </div>
    </div>

    {{-- Divider --}}
    <hr class="tc-sidebar-divider">

    {{-- Menu Navigasi Utama --}}
    <nav class="tc-sidebar-nav">
        <ul>
            {{-- Dashboard - Halaman utama petani --}}
            <li>
                <a href="{{ route('petani.dashboard') }}"
                   class="{{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- Cari Permintaan Pasar --}}
            <li>
                <a href="{{ route('petani.permintaan.index') }}"
                   class="{{ request()->routeIs('permintaan*') || request()->routeIs('tawar.create') ? 'active' : '' }}">
                    <i class="bi bi-shop"></i>
                    <span>Cari Permintaan</span>
                </a>
            </li>
            
            {{-- Tawarkan Panen --}}
            <li>
                <a href="{{ route('tawar.index') }}"
                   class="{{ request()->routeIs('tawar.index') ? 'active' : '' }}">
                    <i class="bi bi-tags-fill"></i>
                    <span>Tawarkan Panen</span>
                </a>
            </li>

            {{-- Pengiriman --}}
            <li>
                <a href="#"
                   class="{{ request()->routeIs('pengiriman*') ? 'active' : '' }}">
                    <i class="bi bi-truck"></i>
                    <span>Pengiriman</span>
                </a>
            </li>

            {{-- Harga Pasar (informasi statis harga komoditas) --}}
            <li>
                <a href="#" class="{{ request()->is('harga*') ? 'active' : '' }}">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>Harga Pasar</span>
                </a>
            </li>
        </ul>

        {{-- Divider pemisah menu utama dan menu sekunder --}}
        <hr class="tc-sidebar-divider mt-3">
        </ul>
    </nav>
</aside>

{{-- ============================================================
     MAIN CONTENT AREA
     Area konten utama di kanan sidebar.
     Berisi navbar atas dan konten halaman.
     ============================================================ --}}
<main class="tc-main">
    {{-- --------------------------------------------------------
         NAVBAR ATAS
         Berisi: hamburger toggle, judul halaman, search bar,
         notif bell, dan dropdown profil pengguna.
         -------------------------------------------------------- --}}
    <header class="tc-navbar">
        {{-- Tombol toggle sidebar untuk layar kecil --}}
        <button class="tc-sidebar-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>

        {{-- Judul halaman dinamis dari tiap view --}}
        <h1 class="tc-navbar-title" style="font-size: 150%">@yield('page-title', 'Dashboard')</h1>

        {{-- Spacer mendorong elemen ke kanan --}}
        <div class="flex-grow-1"></div>

        {{-- Notifikasi bell dengan badge (juga di navbar untuk akses cepat) --}}
        <a href="#" class="tc-navbar-icon-btn me-2">
            <i class="bi bi-bell-fill"></i>
            @if(isset($notifikasiCount) && $notifikasiCount > 0)
                <span class="tc-navbar-badge">5</span>
            @endif
        </a>

        {{-- Dropdown profil pengguna di pojok kanan navbar --}}
        <div class="dropdown">
            <button class="tc-navbar-profile-btn dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('images/profile.jpg') }}"
                     alt="Profil" class="tc-navbar-avatar">
                <span class="tc-navbar-username d-none d-md-inline">
                    {{ auth()->user()->username }}
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end tc-dropdown-menu">
                <li>
                    <a class="dropdown-item" href="{{ route('petani.profil') }}">
                        <i class="bi bi-person-fill me-2"></i> Profil Saya
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    {{-- Logout dengan form POST agar aman (CSRF protected) --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </header>

    {{-- --------------------------------------------------------
         FLASH MESSAGES
         Pesan sukses/error dari controller setelah aksi.
         -------------------------------------------------------- --}}
    <div class="tc-flash-container px-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-x-circle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    {{-- KONTEN HALAMAN UTAMA --}}
    <div class="tc-content">
        @yield('content')
    </div>
</main>

{{-- Bootstrap JS Bundle (termasuk Popper untuk dropdown) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- Script utama TaniConnect --}}
<script src="{{ asset('js/taniconnect.js') }}"></script>

{{-- Area untuk script tambahan per halaman --}}
@stack('scripts')

</body>
</html>
