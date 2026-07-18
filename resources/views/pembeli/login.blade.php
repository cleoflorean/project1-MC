<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Tani Harvest</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        body {
            background-color: #f4f7f5;
            background-image: 
                radial-gradient(at 0% 0%, rgba(46, 125, 50, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(46, 125, 50, 0.05) 0px, transparent 50%);
            margin: 0;
            padding: 3rem 1rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #2d3748;
            box-sizing: border-box;
        }
        .login-card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            padding: 3rem 2.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 10px 25px -5px rgba(46, 125, 50, 0.1);
            border: 1px solid rgba(46, 125, 50, 0.1);
            box-sizing: border-box;
        }
        .login-header {
            margin-bottom: 2.5rem;
            text-align: center;
        }
        .login-header h2 {
            color: #1a202c;
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
        }
        .login-header p {
            color: #718096;
            font-size: 0.95rem;
            margin: 0;
        }
        
        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #4a5568;
            font-size: 0.875rem;
        }
        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid #cbd5e0;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #2d3748;
            box-sizing: border-box;
            background: #ffffff;
            transition: all 0.2s;
            font-family: inherit;
        }
        .form-input:focus {
            outline: none;
            border-color: #2e7d32;
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.15);
        }

        .btn-primary {
            width: 100%;
            padding: 0.875rem;
            background: #2e7d32;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 1rem;
        }
        .btn-primary:hover { background: #1b5e20; }

        .form-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.9rem;
            color: #718096;
        }
        .form-footer a {
            color: #2e7d32;
            text-decoration: none;
            font-weight: 600;
        }
        .form-footer a:hover { text-decoration: underline; }

        .forgot-password {
            font-size: 0.875rem;
            color: #2e7d32;
            text-decoration: none;
            font-weight: 600;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }

        .alert-error {
            background: #fff5f5;
            color: #c53030;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #fed7d7;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        .alert-success {
            background: #f0fff4;
            color: #2f855a;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #c6f6d5;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <main class="login-card">
        <div class="login-header">
            <h2>Masuk</h2>
            <p>Akses akun Tani Harvest Anda</p>
        </div>

        @if($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif
        
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="hidden" name="role" value="pembeli">

            <div class="form-group">
                <label class="form-label" for="email">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" required placeholder="contoh@email.com">
            </div>

            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 0.375rem;">
                    <label class="form-label" for="password" style="margin: 0;">Kata Sandi</label>
                    <a href="{{ route('lupa-sandi') }}" class="forgot-password">Lupa sandi?</a>
                </div>
                <input type="password" id="password" name="password" class="form-input" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn-primary">Masuk</button>
            
            <div class="form-footer">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        </form>
    </main>

</body>
</html>