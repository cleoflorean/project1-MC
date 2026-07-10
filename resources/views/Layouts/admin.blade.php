<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - TaniHarvest')</title>
    
    {{-- Google Fonts & FontAwesome --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #f59e0b; 
            --dark-bg: #14532d;       
            --hover-bg: #166534;      
            --light-bg: #f8fafc;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--light-bg);
            overflow-x: hidden;
        }

        /* SIDEBAR STYLE */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--dark-bg);
            color: white;
            height: 100vh;
            position: fixed;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0,0,0,0.05);
            z-index: 1000;
        }
        .sidebar-brand {
            padding: 30px 20px;
            font-size: 1.5rem;
            font-weight: 800;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--primary-color);
            letter-spacing: 1px;
        }
        .sidebar-menu {
            list-style: none;
            padding: 15px 0;
            margin: 0;
            flex-grow: 1;
        }
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 14px 25px;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            gap: 15px;
            font-weight: 500;
            border-left: 4px solid transparent;
        }
        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background-color: var(--hover-bg);
            color: white;
            border-left: 4px solid var(--primary-color);
        }
        .sidebar-menu li a i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        /* MAIN CONTENT STYLE */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }
        
        /* NAVBAR STYLE */
        .top-navbar {
            background-color: white;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .content-area {
            padding: 30px;
            flex-grow: 1;
        }

        .logout-btn {
            display: block;
            padding: 12px;
            margin: 0 20px;
            background-color: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            text-decoration: none;
            font-weight: 600;
            border-radius: 8px;
            transition: 0.3s;
            text-align: center;
        }
        .logout-btn:hover {
            background-color: #ef4444;
            color: white;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-leaf"></i> TaniHarvest
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
                <a href="#">
                    <i class="fas fa-flag"></i> Laporan Masuk
                </a>
            </li>
        </ul>
        
        <div style="padding: 25px 0; border-top: 1px solid rgba(255, 255, 255, 0.1);">
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-btn">
                <i class="fas fa-sign-out-alt me-2"></i> Keluar
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <div>
                <h4 style="margin:0; color: #1e293b; font-weight: 700; font-size: 1.4rem;">@yield('header_title', 'Control Panel')</h4>
            </div>
            <div style="display: flex; align-items: center; gap: 15px;">
                <div class="text-end d-none d-md-block">
                    <span style="color: #1e293b; font-weight: 700; display: block; font-size: 0.9rem;">Administrator</span>
                    <span style="color: #64748b; font-size: 0.8rem;">Super Admin</span>
                </div>
                <div style="width: 45px; height: 45px; border-radius: 50%; background-color: var(--primary-color); display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 4px 6px rgba(245, 158, 11, 0.3); font-size: 1.2rem;">
                    <i class="fas fa-user-shield"></i>
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