<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TaniHarvest</title>
    
    <link rel="stylesheet" href="{{ asset('/login.css') }}">
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <h2>Login ke Sistem</h2>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <input type="hidden" name="role" id="roleInput" value="pembeli">

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="contoh@email.com">
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" required placeholder="Masukkan kata sandi">
                
                {{-- Tambahan Link Lupa Password --}}
                <div style="text-align: center; margin-top: 8px;">
                    <a href="mailto:admin@taniharvest.com" style="font-size: 0.85rem; color: #2e7d32; text-decoration: none; font-weight: 500; transition: 0.2s;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                        Lupa password? Lapor ke admin
                    </a>
                </div>
            </div>

            @if($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Margin top ditambahkan sedikit agar tidak terlalu menempel dengan link lupa password --}}
            <button type="submit" class="btn-submit" style="margin-top: 15px;">Masuk</button>
        </form>
    </div>

    <script src="{{ asset('/login.js') }}"></script>
</body>
</html>