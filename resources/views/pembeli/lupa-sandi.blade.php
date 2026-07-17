<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - Tani Harvest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> body { background-color: #f4f7f6; font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="d-flex align-items-center justify-content-center py-5 min-vh-100">

    <div class="card border-0 shadow-sm rounded-4" style="max-width: 500px; width: 100%;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px; font-size: 2rem;">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4 class="fw-bold text-dark m-0">Pemulihan Akun</h4>
                <p class="text-muted small mt-1">Sandi baru akan dikirimkan ke nomor WhatsApp yang terdaftar pada profil Anda.</p>
            </div>

            {{-- NOTIFIKASI --}}
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('lupa-sandi.kirim') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small">Username atau Email Akun Anda</label>
                    <input type="text" name="username_atau_email" class="form-control p-2.5" placeholder="Masukkan username atau email" value="{{ old('username_atau_email') }}" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success fw-bold py-2.5 rounded-3">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Permintaan
                    </button>
                    <a href="{{ route('login') }}" class="btn btn-light fw-semibold py-2.5 text-secondary border text-center text-decoration-none rounded-3">
                        Kembali ke Login
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>