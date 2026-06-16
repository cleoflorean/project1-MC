<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun B2B</title>
    
    <style>
        body {
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .register-card {
            width: 100%;
            max-width: 450px;
            background: #ffffff;
            padding: 2.5rem 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            box-sizing: border-box;
            margin: 2rem;
        }
        .register-header h2 {
            text-align: center;
            color: #1f2937;
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            margin-top: 0;
        }
        .register-header p {
            text-align: center;
            color: #6b7280;
            font-size: 0.95rem;
            margin-top: 0;
            margin-bottom: 2rem;
        }
        
        /* Tombol Role (Pembeli/Petani) */
        .role-wrapper {
            display: flex;
            background: #f3f4f6;
            border-radius: 8px;
            padding: 5px;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 10;
        }
        .btn-role {
            flex: 1;
            padding: 12px;
            border: none;
            background: transparent;
            color: #6b7280;
            border-radius: 6px;
            font-weight: bold;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-role.active {
            background: #2e7d32;
            color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Input Form */
        .form-group { margin-bottom: 1.2rem; }
        .form-label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
        }
        .form-input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #1f2937;
            box-sizing: border-box;
            background: #f9fafb;
            transition: border-color 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: #2e7d32;
            background: #ffffff;
        }

        /* Tombol Utama */
        .btn-primary {
            width: 100%;
            padding: 14px;
            background: #2e7d32;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 0.5rem;
            position: relative;
            z-index: 10;
        }
        .btn-primary:hover { background: #1b5e20; }
        .btn-secondary { background: #9ca3af; }
        .btn-secondary:hover { background: #6b7280; }
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
                    <input type="password" id="password" name="password" class="form-input" required placeholder="Minimal 6 karakter">
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label">Konfirmasi Kata Sandi</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required placeholder="Ketik ulang kata sandi">
                </div>

                <button type="button" onclick="nextStep()" class="btn-primary">Selanjutnya ➡️</button>
            </div>

            <div id="section-profile" style="display: none;">
                <div class="form-group">
                    <label class="form-label">Nama Toko / Nama Lengkap</label>
                    <input type="text" id="nama_toko" name="nama_toko" value="{{ old('nama_toko') }}" class="form-input" required placeholder="Nama bisnis Anda">
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Telepon (WhatsApp)</label>
                    <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" class="form-input" required placeholder="08xxxxxxxxxx">
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea id="alamat" name="alamat" class="form-input" required rows="4" style="resize: vertical; font-family: inherit;" placeholder="Masukkan alamat lengkap"></textarea>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="button" onclick="prevStep()" class="btn-primary btn-secondary" style="flex: 1;">⬅️ Kembali</button>
                    <button type="submit" id="btnSubmit" class="btn-primary" style="flex: 2;">Daftar Sekarang</button>
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