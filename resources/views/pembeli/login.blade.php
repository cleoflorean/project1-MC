<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tani Harvest</title>
    
    <link rel="stylesheet" href="{{ asset('/login.css') }}">
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <h2>Login ke Sistem</h2>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            {{-- Input Role (Dibiarkan sesuai bawaan Anda) --}}
            <input type="hidden" name="role" id="roleInput" value="pembeli">

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="contoh@email.com">
            </div>

            <div class="form-group">
                {{-- Memposisikan Label Sandi dan Link Lupa Sandi Sejajar --}}
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                    <label for="password" style="margin: 0;">Kata Sandi</label>
                    
                    {{-- LINK KE SISTEM LUPA SANDI YANG BARU --}}
                    <a href="{{ route('lupa-sandi') }}" style="font-size: 0.85rem; color: #2e7d32; text-decoration: none; font-weight: 600; transition: 0.2s;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                        Lupa kata sandi?
                    </a>
                </div>
                <input type="password" id="password" name="password" required placeholder="Masukkan kata sandi">
            </div>

            {{-- Pesan Error Validasi --}}
            @if($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- TOMBOL MASUK UTAMA --}}
            <button type="submit" class="btn-submit" style="margin-top: 20px; width: 100%; cursor: pointer;">Masuk</button>
            
            {{-- TOMBOL / LINK DAFTAR (Opsional) --}}
            <div style="text-align: center; margin-top: 15px; font-size: 0.9rem; color: #555;">
                Belum punya akun? 
                <a href="{{ route('register') }}" style="color: #2e7d32; font-weight: bold; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                    Daftar di sini
                </a>
            </div>
        </form>
    </div>

    <script src="{{ asset('/login.js') }}"></script>
</body>
</html>