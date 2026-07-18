<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Tani Harvest </title>
    
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
            align-items: flex-start;
            min-height: 100vh;
            color: #2d3748;
            box-sizing: border-box;
        }
        .register-card {
            width: 100%;
            max-width: 480px;
            background: #ffffff;
            padding: 3rem 2.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 10px 25px -5px rgba(46, 125, 50, 0.1);
            border: 1px solid rgba(46, 125, 50, 0.1);
            box-sizing: border-box;
        }
        .register-header {
            margin-bottom: 2.5rem;
            text-align: center;
        }
        .register-header h2 {
            color: #1a202c;
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
        }
        .register-header p {
            color: #718096;
            font-size: 0.95rem;
            margin: 0;
        }
        
        /* Segemented Control */
        .role-wrapper {
            display: flex;
            background: #f8faf9;
            border-radius: 10px;
            padding: 0.35rem;
            margin-bottom: 2rem;
            border: 1px solid #e2e8f0;
        }
        .btn-role {
            flex: 1;
            padding: 0.75rem;
            border: none;
            background: transparent;
            color: #718096;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-role.active {
            background: #2e7d32;
            color: #ffffff;
            box-shadow: 0 2px 4px rgba(46, 125, 50, 0.2);
        }

        /* Form Elements */
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

        /* Buttons */
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
        .btn-secondary { 
            background: #edf2f7;
            color: #4a5568;
        }
        .btn-secondary:hover { background: #e2e8f0; }

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
        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    
    <main class="register-card">
        <div class="register-header">
            <h2>Buat Akun</h2>
            <p>Pilih peran dan lengkapi data Anda</p>
        </div>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                @foreach ($errors->all() as $error) 
                    <p style="margin: 0;">⚠️ {{ $error }}</p> 
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" id="registerForm">
            @csrf
            
            <div class="role-wrapper">
                <button type="button" id="btn-role-pembeli" class="btn-role active" onclick="setRole('pembeli')">Sebagai Pembeli</button>
                <button type="button" id="btn-role-petani" class="btn-role" onclick="setRole('petani')">Sebagai Petani</button>
            </div>
            
            <input type="hidden" name="role" id="input-role" value="pembeli" required>

            <div id="section-login">
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" class="form-input" required placeholder="Masukkan username">
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" required placeholder="contoh@email.com">
                </div>

                <div class="form-group">
                    <label class="form-label">Kata Sandi</label>
                    <input type="password" id="password" name="password" class="form-input" required placeholder="Minimal 8 karakter">
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label">Konfirmasi Kata Sandi</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required placeholder="Ketik ulang kata sandi">
                </div>

                <button type="button" onclick="nextStep()" class="btn-primary">Selanjutnya</button>

                <div class="form-footer">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>
            </div>

            <div id="section-profile" style="display: none;">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" id="NamaLengkap" name="NamaLengkap" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor Telepon (WhatsApp)</label>
                    <input type="text" id="NoWhatsApp" name="NoWhatsApp" class="form-input" required placeholder="08xxxxxxxxxx">
                </div>
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea id="Alamat" name="Alamat" class="form-input" required rows="4" style="resize: vertical;" placeholder="Masukkan alamat lengkap"></textarea>
                </div>
                <div style="display: flex; gap: 0.75rem;">
                    <button type="button" onclick="prevStep()" class="btn-primary btn-secondary" style="width: 30%;">Kembali</button>
                    <button type="submit" id="btnSubmit" class="btn-primary" style="flex: 1;">Daftar Sekarang</button>
                </div>
            </div>
        </form>
    </main>

    <script>
        // Set nilai Role
        function setRole(selectedRole) {
            document.getElementById('input-role').value = selectedRole;

            const btnPembeli = document.getElementById('btn-role-pembeli');
            const btnPetani = document.getElementById('btn-role-petani');

            if (selectedRole === 'pembeli') {
                btnPembeli.classList.add('active');
                btnPetani.classList.remove('active');
            } else {
                btnPetani.classList.add('active');
                btnPembeli.classList.remove('active');
            }
        }

        // Pindah ke Halaman 2 (Profil)
        function nextStep() {
            // Ambil data dan hapus spasi kosong (trim)
            const username = document.getElementById('username').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;

            // Validasi apakah ada yang kosong
            if (!username || !email || !password || !confirm) {
                alert('Harap isi Username, Email, dan Kata Sandi terlebih dahulu!');
                return;
            }

            // Validasi kecocokan password
            if (password !== confirm) {
                alert('Kata sandi dan Konfirmasi Kata Sandi tidak cocok!');
                return;
            }

            // Eksekusi Pindah Tampilan
            document.getElementById('section-login').style.display = 'none';
            document.getElementById('section-profile').style.display = 'block';
        }

        // Kembali ke Halaman 1 (Login)
        function prevStep() {
            document.getElementById('section-login').style.display = 'block';
            document.getElementById('section-profile').style.display = 'none';
        }
    </script>

</body>
</html>