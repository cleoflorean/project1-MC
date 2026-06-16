<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Agrimart</title>
    
    <link rel="stylesheet" href="{{ asset('/login.css') }}">
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <h2>login ke Sistem</h2>
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
            </div>

            @if($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" class="btn-submit">Masuk</button>
        </form>
    </div>

    <script src="{{ asset('/login.js') }}"></script>
</body>
</html>