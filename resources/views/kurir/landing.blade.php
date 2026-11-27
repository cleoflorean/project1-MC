<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadi Mitra Kurir - Tani Harvest</title>
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
        body { background: #fff; }
        .wrap { max-width: 1040px; margin: 0 auto; padding: 0 1.25rem; }
        nav.wrap { display: flex; align-items: center; justify-content: space-between; padding-top: 1.25rem; padding-bottom: 1.25rem; }
        nav .login { color: var(--leaf-700); font-weight: 700; text-decoration: none; font-size: .92rem; }
        .btn { display: inline-block; padding: .9rem 1.6rem; border-radius: 8px; background: var(--leaf-700); color: #fff; font-weight: 700; text-decoration: none; }
        .btn:hover { background: var(--leaf-800); }
        a:focus-visible { outline: 3px solid var(--harvest); outline-offset: 3px; }

        .hero { display: grid; grid-template-columns: 1.1fr .9fr; gap: 3rem; align-items: center; padding-top: 3rem; padding-bottom: 4rem; }
        h1 { margin: 0 0 1rem; font-size: clamp(2.1rem, 5vw, 3.4rem); line-height: 1.08; }
        .hero p { margin: 0 0 1.75rem; max-width: 46ch; color: var(--muted); font-size: 1.05rem; }
        .more { margin-left: 1.25rem; color: var(--ink); font-weight: 600; }

        /* Alur antar: petani, kurir, pembeli */
        .path { list-style: none; margin: 0; padding: 1.75rem; background: var(--soft); border-radius: 18px; }
        .path li { position: relative; display: flex; gap: 1rem; padding-bottom: 2rem; }
        .path li:last-child { padding-bottom: 0; }
        .path li:not(:last-child)::after { content: ''; position: absolute; left: 13px; top: 32px; bottom: 4px; border-left: 3px dashed #b8c7b9; }
        .dot { flex: none; width: 29px; height: 29px; border-radius: 50%; border: 7px solid var(--leaf-700); background: #fff; }
        .path li.you .dot { border-color: var(--harvest); }
        .path strong { display: block; }
        .path span.text { color: var(--muted); font-size: .88rem; }

        section { padding: 3.5rem 0; }
        .alt { background: var(--soft); }
        h2 { margin: 0 0 1.75rem; font-size: 1.75rem; }
        .cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; list-style: none; margin: 0; padding: 0; }
        .cards li { background: #fff; border: 1px solid var(--line); border-radius: 12px; padding: 1.25rem; }
        h3 { margin: 0 0 .35rem; font-size: 1.05rem; }
        .cards p { margin: 0; color: var(--muted); font-size: .88rem; }
        .steps { counter-reset: s; }
        .steps li::before { counter-increment: s; content: counter(s); display: grid; place-items: center; width: 34px; height: 34px; margin-bottom: .85rem; border-radius: 50%; background: var(--leaf-700); color: #fff; font-weight: 700; }
        .closing { text-align: center; }
        .closing p { margin: -1rem 0 1.5rem; color: var(--muted); }
        footer { border-top: 1px solid var(--line); padding: 1.5rem; text-align: center; color: var(--muted); font-size: .85rem; }

        @media (max-width: 760px) {
            .hero { grid-template-columns: minmax(0, 1fr); gap: 2rem; padding-top: 1.5rem; padding-bottom: 2.5rem; }
            .hero .btn { display: block; text-align: center; }
            .more { display: block; margin: 1rem 0 0; text-align: center; }
            .cards { grid-template-columns: minmax(0, 1fr); }
            section { padding: 2.5rem 0; }
        }
        @media (prefers-reduced-motion: reduce) { html { scroll-behavior: auto; } }
    </style>
</head>
<body>
<nav class="wrap" aria-label="Utama">
    <span class="brand">
        <svg viewBox="0 0 40 40" aria-hidden="true">
                    <rect width="40" height="40" rx="10" fill="#f0b429"/>
                    <path d="M20 32V17M20 22c-7 0-10-4-10-10 7 0 10 4 10 10Zm0-3c0-6 3-10 10-10 0 6-3 10-10 10Z" fill="none" stroke="#153a22" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
        Tani Harvest
    </span>
    <a class="login" href="{{ route('login') }}">Masuk</a>
</nav>

<main>
    <header class="wrap hero">
        <div>
            <h1>Antar hasil panen, jadi mitra kurir kami</h1>
            <p>Anda yang menghubungkan petani dengan pembeli. Daftar secara online dengan data diri, kendaraan, dan dokumen Anda.</p>
            <a class="btn" href="{{ route('register.kurir') }}">Daftar sebagai kurir</a>
            <a class="more" href="#syarat">Lihat persyaratan</a>
        </div>
        <ol class="path" aria-label="Peran kurir dalam pengantaran">
            <li><span class="dot"></span><span><strong>Petani</strong><span class="text">Menyiapkan hasil panen yang dipesan.</span></span></li>
            <li class="you"><span class="dot"></span><span><strong>Anda, mitra kurir</strong><span class="text">Mengambil pesanan dan mengantarkannya.</span></span></li>
            <li><span class="dot"></span><span><strong>Pembeli</strong><span class="text">Menerima pesanan di alamat tujuan.</span></span></li>
        </ol>
    </header>

    <section class="alt" id="syarat">
        <div class="wrap">
            <h2>Yang perlu Anda siapkan</h2>
            <ul class="cards">
                <li><h3>KTP dan NIK</h3><p>Foto KTP yang jelas serta nomor NIK Anda.</p></li>
                <li><h3>SIM</h3><p>Foto SIM sesuai kendaraan yang Anda pakai.</p></li>
                <li><h3>SKCK</h3><p>Foto Surat Keterangan Catatan Kepolisian.</p></li>
                <li><h3>Kendaraan</h3><p>Sepeda motor, mobil, atau kendaraan antar lainnya.</p></li>
                <li><h3>Nomor WhatsApp</h3><p>Nomor aktif yang bisa dihubungi.</p></li>
                <li><h3>Email</h3><p>Dipakai untuk akun Anda.</p></li>
            </ul>
        </div>
    </section>

    <section>
        <div class="wrap">
            <h2>Cara mendaftar</h2>
            <ol class="cards steps">
                <li><h3>Buat akun</h3><p>Isi username, email, dan kata sandi.</p></li>
                <li><h3>Lengkapi data</h3><p>Masukkan data diri dan jenis kendaraan.</p></li>
                <li><h3>Unggah dokumen</h3><p>Kirim foto KTP, SIM, dan SKCK.</p></li>
            </ol>
        </div>
    </section>

    <section class="alt closing">
        <div class="wrap">
            <h2>Sudah siap mendaftar?</h2>
            <p>Siapkan foto dokumen Anda, lalu isi formulirnya.</p>
            <a class="btn" href="{{ route('register.kurir') }}">Daftar sebagai kurir</a>
        </div>
    </section>
</main>

<footer>Tani Harvest</footer>
</body>
</html>