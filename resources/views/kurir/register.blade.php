<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Mitra Kurir - Tani Harvest</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --leaf-900:#153a22; --leaf-700:#2e7d32; --leaf-800:#1b5e20; --harvest:#f0b429; --soft:#f5f7f5; --ink:#1c2a21; --muted:#5d6b61; --line:#dbe2db; --danger:#b42318; }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; background: var(--soft); color: var(--ink); font-family: 'Plus Jakarta Sans', sans-serif; line-height: 1.55; }
        h1, h2, h3, legend { font-family: 'Bricolage Grotesque', 'Plus Jakarta Sans', sans-serif; }
        .brand { display: inline-flex; align-items: center; gap: .65rem; font-weight: 700; color: var(--leaf-900); text-decoration: none; }
        .brand svg { width: 34px; height: 34px; }

        .content { max-width: 760px; margin: 0 auto; padding: 2rem 1.25rem 3rem; }
        .content-head { text-align: center; margin-bottom: 1.75rem; }
        h1 { font-size: 2rem; line-height: 1.2; margin: 1.25rem 0 .4rem; }
        .content-head p { margin: 0; color: var(--muted); font-size: .93rem; }

        .route { display: grid; grid-template-columns: repeat(4, 1fr); list-style: none; margin: 0 0 1.5rem; padding: 0; }
        .route li { position: relative; }
        .route li:not(:last-child)::after { content: ''; position: absolute; top: 15px; left: calc(50% + 22px); width: calc(100% - 44px); border-top: 2px dashed #c3cfc3; }
        .route a { display: flex; flex-direction: column; align-items: center; gap: .35rem; color: var(--ink); text-decoration: none; font-weight: 600; font-size: .82rem; }
        .stop { width: 32px; height: 32px; display: grid; place-items: center; background: #fff; border: 2px solid #c3cfc3; border-radius: 50%; }
        .route li.done .stop { background: var(--leaf-700); border-color: var(--leaf-700); color: #fff; }
        .route li.done::after { border-top: 2px solid var(--leaf-700); }

        .alert { background: #fef3f2; border: 1px solid #fecdca; color: var(--danger); padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: .9rem; }
        .alert ul { margin: .35rem 0 0; padding-left: 1.1rem; }

        /* Tiap bagian formulir */
        fieldset { margin: 0 0 1.25rem; padding: 1.75rem; min-width: 0; background: #fff; border: 1px solid var(--line); border-radius: 14px; scroll-margin-top: 1rem; }
        legend { float: left; width: 100%; padding: 0; margin: 0; font-size: 1.15rem; font-weight: 700; }
        .section-note { clear: both; margin: 0 0 1.25rem; padding-top: .15rem; font-size: .85rem; color: var(--muted); }
        .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.1rem 1rem; align-items: start; }
        .full { grid-column: 1 / -1; }

        .label { display: block; margin-bottom: .4rem; font-weight: 600; font-size: .85rem; }
        .input { display: block; width: 100%; height: 48px; padding: 0 .9rem; border: 1px solid var(--line); border-radius: 8px; background: #fff; color: var(--ink); font: inherit; font-size: 1rem; -webkit-appearance: none; appearance: none; }
        textarea.input { height: auto; padding: .75rem .9rem; resize: vertical; }
        .input::placeholder { color: #8b978e; font-size: .92rem; }
        .input:focus { outline: none; border-color: var(--leaf-700); box-shadow: 0 0 0 3px rgba(46,125,50,.18); }
        .input.is-invalid { border-color: var(--danger); }
        .hint { display: block; margin-top: .35rem; font-size: .78rem; color: var(--muted); }
        .error { display: block; margin-top: .35rem; font-size: .8rem; color: var(--danger); }

        .password { position: relative; }
        .password .input { padding-right: 5rem; }
        .toggle { position: absolute; right: .35rem; top: 50%; transform: translateY(-50%); border: 0; background: none; color: var(--leaf-700); font: inherit; font-size: .8rem; font-weight: 600; cursor: pointer; padding: .5rem; }

        .choices { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem; }
        .choice { display: flex; align-items: center; gap: .5rem; height: 48px; padding: 0 .8rem; border: 1px solid var(--line); border-radius: 8px; font-size: .9rem; cursor: pointer; }
        .choice input { accent-color: var(--leaf-700); margin: 0; }
        .choice:has(input:checked) { border-color: var(--leaf-700); background: #eef7ee; font-weight: 600; }

        /* Unggah dokumen */
        .uploads { clear: both; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem; }
        .drop {
            position: relative;
            min-height: 160px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            padding: 1rem;
            border: 2px dashed #b8c7b9;
            border-radius: 12px;
            background: #f8faf8;
            text-align: center;
            overflow: hidden;
        }
        .drop:hover, .drop:focus-within { border-color: var(--leaf-700); background: #eef7ee; }
        .drop:focus-within { box-shadow: 0 0 0 3px rgba(46, 125, 50, .18); }
        .drop.filled { border-style: solid; border-color: var(--leaf-700); }
        .drop input { position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2; }
        .drop svg { width: 30px; height: 30px; color: var(--leaf-700); }
        .drop img { width: 100%; height: 90px; object-fit: cover; border-radius: 6px; }
        .drop img[hidden], .drop.filled svg { display: none; }
        .drop b { font-size: .88rem; }
        .drop small { max-width: 100%; font-size: .76rem; color: var(--muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        .actions { margin-top: 1.5rem; }
        .submit {
            width: 100%;
            padding: .95rem;
            border: 0;
            border-radius: 8px;
            background: var(--leaf-700);
            color: #fff;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
        }
        .submit:hover { background: var(--leaf-800); }
        .submit:disabled { opacity: .7; cursor: wait; }
        .submit:focus-visible, .toggle:focus-visible, .route a:focus-visible { outline: 3px solid var(--harvest); outline-offset: 2px; }
        .login { text-align: center; margin: 1.25rem 0 0; font-size: .9rem; color: var(--muted); }
        .login a { color: var(--leaf-700); font-weight: 700; }

        @media (max-width: 620px) {
            .content { padding: 1.25rem 1rem 2rem; }
            h1 { font-size: 1.55rem; }
            .route a { font-size: .74rem; }
            fieldset { padding: 1.25rem 1rem; }
            .grid, .uploads { grid-template-columns: minmax(0, 1fr); }
            /* Kotak unggah menjadi baris ringkas di HP */
            .drop { display: grid; grid-template-columns: 56px minmax(0, 1fr); gap: 0 .85rem; min-height: 80px; text-align: left; align-content: center; }
            .drop svg, .drop img { grid-row: 1 / 3; align-self: center; justify-self: center; }
            .drop img { width: 56px; height: 56px; }
        }
        @media (prefers-reduced-motion: reduce) { html { scroll-behavior: auto; } }
    </style>
</head>
<body>
<main class="content">
        <header class="content-head">
            <a class="brand" href="{{ route('kurir.landing') }}">
                <svg viewBox="0 0 40 40" aria-hidden="true">
                    <rect width="40" height="40" rx="10" fill="#f0b429"/>
                    <path d="M20 32V17M20 22c-7 0-10-4-10-10 7 0 10 4 10 10Zm0-3c0-6 3-10 10-10 0 6-3 10-10 10Z" fill="none" stroke="#153a22" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Tani Harvest
            </a>
            <h1>Bergabung sebagai mitra kurir</h1>
            <p>Siapkan foto KTP, SIM, dan SKCK yang jelas. Semua kolom wajib diisi.</p>
        </header>

        <nav aria-label="Tahapan pengisian">
            <ol class="route">
                <li data-step="akun"><a href="#akun"><span class="stop">1</span>Akun</a></li>
                <li data-step="diri"><a href="#diri"><span class="stop">2</span>Data diri</a></li>
                <li data-step="kendaraan"><a href="#kendaraan"><span class="stop">3</span>Kendaraan</a></li>
                <li data-step="dokumen"><a href="#dokumen"><span class="stop">4</span>Dokumen</a></li>
            </ol>
        </nav>

        @if ($errors->any())
            <div class="alert" role="alert">
                <strong>Pendaftaran belum terkirim. Periksa data berikut, lalu unggah ulang foto dokumen.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.kurir.post') }}" method="POST" enctype="multipart/form-data" id="registerKurirForm">
            @csrf
            <input type="hidden" name="role" value="kurir">

            <fieldset id="akun">
                <legend>Akun</legend>
                <p class="section-note">Dipakai untuk masuk ke aplikasi.</p>
                <div class="grid">
                    <div>
                        <label class="label" for="username">Username</label>
                        <input type="text" id="username" name="username" class="input @error('username') is-invalid @enderror" required autocomplete="username" placeholder="Masukkan username" value="{{ old('username') }}">
                        @error('username') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="label" for="email">Alamat email</label>
                        <input type="email" id="email" name="email" class="input @error('email') is-invalid @enderror" required autocomplete="email" placeholder="contoh@email.com" value="{{ old('email') }}">
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="label" for="password">Kata sandi</label>
                        <div class="password">
                            <input type="password" id="password" name="password" class="input @error('password') is-invalid @enderror" required minlength="8" autocomplete="new-password" placeholder="Minimal 8 karakter">
                            <button type="button" class="toggle" data-target="password">Lihat</button>
                        </div>
                        @error('password') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="label" for="password_confirmation">Konfirmasi kata sandi</label>
                        <div class="password">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="input" required autocomplete="new-password" placeholder="Ketik ulang kata sandi">
                            <button type="button" class="toggle" data-target="password_confirmation">Lihat</button>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset id="diri">
                <legend>Data diri</legend>
                <p class="section-note">Isi sesuai KTP, dengan nomor WhatsApp yang aktif.</p>
                <div class="grid">
                    <div class="full">
                        <label class="label" for="NamaLengkap">Nama lengkap</label>
                        <input type="text" id="NamaLengkap" name="NamaLengkap" class="input @error('NamaLengkap') is-invalid @enderror" required autocomplete="name" placeholder="Sesuai KTP" value="{{ old('NamaLengkap') }}">
                        @error('NamaLengkap') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="label" for="NIK">NIK</label>
                        <input type="text" id="NIK" name="NIK" class="input @error('NIK') is-invalid @enderror" required maxlength="20" inputmode="numeric" placeholder="Nomor pada KTP" value="{{ old('NIK') }}">
                        @error('NIK') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="label" for="NoWhatsApp">Nomor WhatsApp</label>
                        <input type="tel" id="NoWhatsApp" name="NoWhatsApp" class="input @error('NoWhatsApp') is-invalid @enderror" required autocomplete="tel" placeholder="08xxxxxxxxxx" value="{{ old('NoWhatsApp') }}">
                        @error('NoWhatsApp') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="label" for="tanggal_lahir">Tanggal lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="input @error('tanggal_lahir') is-invalid @enderror" required max="{{ date('Y-m-d') }}" value="{{ old('tanggal_lahir') }}">
                        @error('tanggal_lahir') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div role="radiogroup" aria-labelledby="gender-label">
                        <span class="label" id="gender-label">Jenis kelamin</span>
                        <div class="choices">
                            <label class="choice"><input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin') === 'L' ? 'checked' : '' }} required> Laki-laki</label>
                            <label class="choice"><input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin') === 'P' ? 'checked' : '' }} required> Perempuan</label>
                        </div>
                        @error('jenis_kelamin') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="full">
                        <label class="label" for="Alamat">Alamat lengkap</label>
                        <textarea id="Alamat" name="Alamat" class="input @error('Alamat') is-invalid @enderror" required rows="3" autocomplete="street-address" placeholder="Jalan, RT/RW, kelurahan, kecamatan, kota">{{ old('Alamat') }}</textarea>
                        @error('Alamat') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </fieldset>

            <fieldset id="kendaraan">
                <legend>Kendaraan</legend>
                <p class="section-note">Kendaraan yang akan Anda pakai untuk mengantar.</p>
                <div class="grid">
                    <div class="full">
                        <label class="label" for="jenis_kendaraan">Jenis kendaraan</label>
                        <input type="text" id="jenis_kendaraan" name="jenis_kendaraan" class="input @error('jenis_kendaraan') is-invalid @enderror" required list="daftar-kendaraan" placeholder="Sepeda motor, mobil, dll." value="{{ old('jenis_kendaraan') }}">
                        <datalist id="daftar-kendaraan">
                            <option value="Sepeda motor"></option>
                            <option value="Mobil pikap"></option>
                            <option value="Mobil boks"></option>
                        </datalist>
                        @error('jenis_kendaraan') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </fieldset>

            <fieldset id="dokumen">
                <legend>Dokumen</legend>
                <p class="section-note">Pastikan tulisan terbaca dan foto tidak terpotong.</p>
                <div class="uploads">
                    @foreach (['foto_ktp' => 'Foto KTP', 'foto_sim' => 'Foto SIM', 'foto_skck' => 'Foto SKCK'] as $field => $label)
                        <div>
                            <label class="drop">
                                <input type="file" name="{{ $field }}" required accept="image/*">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 16V4m0 0L7 9m5-5 5 5M4 15v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3"/></svg>
                                <img alt="Pratinjau {{ $label }}" hidden>
                                <b>{{ $label }}</b>
                                <small>Pilih atau seret gambar</small>
                            </label>
                            @error($field) <span class="error">{{ $message }}</span> @enderror
                        </div>
                    @endforeach
                </div>
            </fieldset>

            <div class="actions">
                <button type="submit" class="submit">Kirim pendaftaran</button>
                <p class="login">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
            </div>
        </form>
</main>

<script>
    (function () {
        const form = document.getElementById('registerKurirForm');
        const password = document.getElementById('password');
        const confirmation = document.getElementById('password_confirmation');
        const button = form.querySelector('.submit');

        // Tandai tahap yang sudah lengkap pada tahapan
        function updateRoute() {
            confirmation.setCustomValidity(
                confirmation.value && confirmation.value !== password.value ? 'Konfirmasi kata sandi tidak sama.' : ''
            );
            form.querySelectorAll('fieldset').forEach(function (section) {
                const complete = Array.from(section.querySelectorAll('input, textarea'))
                    .every(function (field) { return field.validity.valid; });
                document.querySelector('[data-step="' + section.id + '"]').classList.toggle('done', complete);
            });
        }

        // Tampilkan atau sembunyikan kata sandi
        document.querySelectorAll('.toggle').forEach(function (toggle) {
            toggle.addEventListener('click', function () {
                const input = document.getElementById(toggle.dataset.target);
                const hidden = input.type === 'password';
                input.type = hidden ? 'text' : 'password';
                toggle.textContent = hidden ? 'Tutup' : 'Lihat';
            });
        });

        // Pratinjau foto dokumen
        document.querySelectorAll('.drop').forEach(function (drop) {
            const input = drop.querySelector('input');
            const image = drop.querySelector('img');
            const note = drop.querySelector('small');

            input.addEventListener('change', function () {
                const file = input.files[0];
                if (image.src) URL.revokeObjectURL(image.src);
                drop.classList.toggle('filled', Boolean(file));
                image.hidden = !file;
                if (file) image.src = URL.createObjectURL(file);
                else image.removeAttribute('src');
                note.textContent = file ? file.name : 'Pilih atau seret gambar';
            });
        });

        form.addEventListener('input', updateRoute);
        form.addEventListener('change', updateRoute);

        // Cegah pengiriman ganda saat foto sedang diunggah
        form.addEventListener('submit', function () {
            button.disabled = true;
            button.textContent = 'Mengirim...';
        });
        window.addEventListener('pageshow', function () {
            button.disabled = false;
            button.textContent = 'Kirim pendaftaran';
            updateRoute();
        });
    })();
</script>
</body>
</html>