<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Tani Harvest')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-green: #2e7d32;
            --bg-body: #f4f7f6;
            --text-main: #333333;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg-body); color: var(--text-main); overflow-x: hidden; }
        .sidebar { width: var(--sidebar-width); background-color: #ffffff; height: 100vh; position: fixed; display: flex; flex-direction: column; border-right: 1px solid var(--border-color); z-index: 1000; }
        .sidebar-brand { padding: 40px 20px 30px; text-align: center; display: flex; flex-direction: column; align-items: center; }
        .brand-icon { width: 55px; height: 55px; background-color: var(--primary-green); color: white; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 15px; box-shadow: 0 4px 10px rgba(46, 125, 50, 0.2); }
        .brand-text { color: var(--primary-green); font-size: 1.4rem; font-weight: 800; margin: 0; letter-spacing: -0.5px; }
        .brand-sub { color: var(--text-muted); font-size: 0.75rem; letter-spacing: 2px; font-weight: 600; margin-top: 2px; }
        .sidebar-menu { list-style: none; padding: 10px 0; margin: 0; flex-grow: 1; }
        .sidebar-menu li { margin-bottom: 5px; }
        .sidebar-menu li a { display: flex; align-items: center; padding: 12px 30px; color: var(--text-muted); text-decoration: none; transition: all 0.2s ease; gap: 15px; font-weight: 500; font-size: 0.95rem; border-left: 4px solid transparent; }
        .sidebar-menu li a:hover { color: var(--primary-green); background-color: #f8fafc; }
        .sidebar-menu li a.active { color: var(--primary-green); font-weight: 600; border-left: 4px solid var(--primary-green); background-color: #f0fdf4; }
        .sidebar-menu li a i { font-size: 1.1rem; width: 20px; text-align: center; }
        .menu-divider { height: 1px; background-color: var(--border-color); margin: 15px 30px; }
        
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; display: flex; flex-direction: column; }
        .top-navbar { background-color: #ffffff; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 10; border-bottom: 1px solid var(--border-color); }
        .navbar-title { margin: 0; color: var(--text-main); font-weight: 700; font-size: 1.4rem; }
        .nav-right-actions { display: flex; align-items: center; gap: 20px; }
        .btn-notification { width: 40px; height: 40px; border-radius: 50%; background-color: #f3f4f6; display: flex; align-items: center; justify-content: center; color: var(--text-muted); text-decoration: none; transition: 0.2s; }
        .btn-notification:hover { background-color: #e5e7eb; color: var(--text-main); }
        .profile-trigger { display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 5px 10px; border-radius: 30px; transition: 0.2s; }
        .profile-trigger:hover { background-color: #f9fafb; }
        .profile-avatar { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb; }
        .profile-name { color: var(--text-main); font-weight: 600; font-size: 0.95rem; }
        .custom-dropdown-menu { border: 1px solid var(--border-color); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 8px 0; min-width: 200px; margin-top: 15px !important; }
        .custom-dropdown-menu .dropdown-item { padding: 10px 20px; font-weight: 500; color: var(--text-main); display: flex; align-items: center; gap: 12px; font-size: 0.95rem; }
        .custom-dropdown-menu .dropdown-item:hover { background-color: #f9fafb; }
        .content-area { padding: 30px 40px; flex-grow: 1; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Tani Harvest Logo" style="height: 55px; width: auto; margin-bottom: 15px; object-fit: contain;">
            <h1 class="brand-text">Tani Harvest</h1>
            <span class="brand-sub">ADMIN PANEL</span>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard Utama
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pengguna') }}" class="{{ request()->routeIs('admin.pengguna*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Data Pengguna
                </a>
            </li>
            <li>
                <a href="{{ route('admin.konfirmasi') }}" class="{{ request()->routeIs('admin.konfirmasi') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar"></i> Konfirmasi Pembayaran
                </a>
            </li>
            <li>
                <a href="{{ route('admin.laporan') }}" class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                    <i class="fas fa-flag"></i> Laporan Masuk
                </a>
            </li>
        </ul>
        
        <div class="menu-divider"></div>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">@csrf</form>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <div>
                <h4 class="navbar-title">@yield('header_title', 'Dashboard Admin')</h4>
            </div>
            <div class="nav-right-actions">
                <div class="dropdown">
                    <div class="profile-trigger" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=f0fdf4&color=2e7d32&rounded=true" alt="Admin" class="profile-avatar">
                        <span class="profile-name d-none d-md-block">Admin</span>
                    </div>
                    
                    <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profil') }}">
                                <i class="fas fa-university text-secondary"></i> Profil & Rekening
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>