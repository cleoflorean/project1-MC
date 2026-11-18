<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kurir Logistik - Tani Harvest')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome & Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
        }
        .navbar-kurir {
            background: linear-gradient(135deg, #166534 0%, #15803d 100%);
            box-shadow: 0 4px 15px rgba(22, 101, 52, 0.2);
        }
        .badge-kurir {
            background-color: #fef08a;
            color: #854d0e;
            font-weight: 700;
            font-size: 0.72rem;
            padding: 4px 8px;
            border-radius: 6px;
            letter-spacing: 0.5px;
        }
        .card-custom {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card-custom:hover {
            box-shadow: 0 8px 16px rgba(0,0,0,0.08);
        }
        .timeline-step {
            position: relative;
            padding-left: 28px;
            margin-bottom: 22px;
        }
        .timeline-step:last-child {
            margin-bottom: 0;
        }
        .timeline-step::before {
            content: '';
            position: absolute;
            left: 7px;
            top: 14px;
            bottom: -16px;
            width: 2px;
            background: #cbd5e1;
        }
        .timeline-step:last-child::before {
            display: none;
        }
        .timeline-dot {
            position: absolute;
            left: 0;
            top: 2px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #22c55e;
            border: 3px solid #ffffff;
            box-shadow: 0 0 0 2px #22c55e;
        }
    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- NAVBAR KURIR --}}
    <nav class="navbar navbar-expand-lg navbar-dark navbar-kurir py-2 sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('kurir.dashboard') }}">
                <span class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="fas fa-truck-fast fs-5"></i>
                </span>
                <div>
                    <span class="d-block lh-1 text-white fs-5">Tani Harvest</span>
                    <small class="text-white-50 fs-7" style="font-size: 0.75rem;">Logistik & Kurir Internal</small>
                </div>
            </a>

            <div class="d-flex align-items-center gap-3">
                <div class="d-none d-sm-block text-end text-white">
                    <div class="fw-bold fs-6">{{ auth()->user()->username ?? 'Petugas Kurir' }}</div>
                    <span class="badge-kurir text-uppercase">Kurir Internal</span>
                </div>

                <a href="{{ route('lacak.resi') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1">
                    <i class="fas fa-search me-1"></i> Lacak Resi
                </a>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-light text-danger fw-bold rounded-pill px-3 py-1 shadow-sm">
                        <i class="fas fa-sign-out-alt me-1"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- ALERTS --}}
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2" role="alert">
                <i class="fas fa-check-circle fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2" role="alert">
                <i class="fas fa-exclamation-circle fs-5"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    {{-- MAIN CONTENT --}}
    <main class="flex-grow-1 pb-5">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-white border-top py-3 mt-auto text-center text-muted small">
        <div class="container">
            &copy; {{ date('Y') }} <strong>Tani Harvest</strong> - Sistem Pengiriman & Tracking Kurir Internal
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
