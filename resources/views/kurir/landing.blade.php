{{-- KURIR --}}
@php
    $syarat = [
        ['t' => 'KTP dan NIK', 'd' => 'Foto KTP yang jelas serta nomor NIK Anda.',
         'icon' => '<rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="11" r="2"/><path d="M6.5 16c.5-1.5 1.7-2 2.5-2s2 .5 2.5 2M14 10h4M14 14h4"/>'],
        ['t' => 'SIM', 'd' => 'Foto SIM sesuai kendaraan yang Anda pakai.',
         'icon' => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="2"/><path d="M12 14v7M10.2 11L4 9M13.8 11L20 9"/>'],
        ['t' => 'SKCK', 'd' => 'Foto Surat Keterangan Catatan Kepolisian.',
         'icon' => '<path d="M12 3l8 3v6c0 4.5-3.2 8-8 9-4.8-1-8-4.5-8-9V6z"/><path d="M9 12l2 2 4-4"/>'],
        ['t' => 'Kendaraan', 'd' => 'Sepeda motor, mobil, atau kendaraan antar lainnya.',
         'icon' => '<path d="M3 7h11v9H3zM14 10h4l3 3v3h-7"/><circle cx="7" cy="17.5" r="1.8"/><circle cx="17" cy="17.5" r="1.8"/>'],
        ['t' => 'Nomor WhatsApp', 'd' => 'Nomor aktif yang bisa dihubungi.',
         'icon' => '<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/>'],
        ['t' => 'Email', 'd' => 'Dipakai untuk akun Anda.',
         'icon' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>'],
    ];

    $langkah = [
        ['t' => 'Buat akun', 'd' => 'Isi username, email, dan kata sandi.', 'v' => ''],
        ['t' => 'Lengkapi data', 'd' => 'Masukkan data diri dan jenis kendaraan.', 'v' => 'tint'],
        ['t' => 'Unggah dokumen', 'd' => 'Kirim foto KTP, SIM, dan SKCK.', 'v' => 'dark'],
    ];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitra Kurir - Tani Harvest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://api.fontshare.com">
    <link rel="preconnect" href="https://cdn.fontshare.com" crossorigin>
    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@1&f[]=cabinet-grotesk@1&display=swap" rel="stylesheet">
    <style>
        :root { --green:#166534; --green-60:#d1fae5; --green-text:#166534; --ink:#14201a; --muted:#55625a; --line:#e3e8e2; --bg:#f6f7f4;
            --amber:#f5b94a; --amber-dark:#b45309; --amber-text:#92400e; --amber-50:#fbefdc; }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; background: var(--bg); color: var(--ink); font-family: 'Satoshi', system-ui, sans-serif; font-size: 17px; line-height: 1.55; }
        h1, h2, h3, .brand, .num { font-family: 'Cabinet Grotesk', 'Satoshi', system-ui, sans-serif; }
        a { color: inherit; text-decoration: none; }
        a:hover { opacity: .88; }
        a:focus-visible { outline: 3px solid var(--amber); outline-offset: 3px; }

        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 10px; min-height: 56px; padding: 0 30px; border-radius: 999px; font-weight: 700; font-size: 17px; }
        .btn-sm { min-height: 44px; padding: 0 22px; font-size: 15px; }
        .btn-brown { background: var(--green); color: #fff; }
        .btn-amber { background: var(--amber); color: var(--ink); }
        .btn-line { border: 1px solid #3b4a41; color: #fff; }

        /* Navigasi */
        .nav-outer { position: sticky; top: 0; z-index: 1000; padding: 16px 24px 0; }
        .nav { max-width: 1120px; margin: 0 auto; background: #fff; border: 1px solid var(--line); border-radius: 28px; padding: 10px 10px 10px 20px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; }
        .brand { display: flex; align-items: center; gap: 10px; font-weight: 800; font-size: 22px; letter-spacing: -.02em; color: var(--green); }
        .brand .tag { font-family: 'Satoshi', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 0; color: var(--green-text); background: var(--amber); padding: 3px 10px; border-radius: 999px; }
        .nav-links { display: flex; flex-wrap: wrap; gap: 28px; font-size: 16px; font-weight: 500; color: var(--muted); }
        .nav-actions { display: flex; align-items: center; gap: 6px; }
        .login { display: inline-flex; align-items: center; min-height: 44px; padding: 0 18px; font-weight: 700; font-size: 15px; color: var(--green-text); }

        /* Hero */
        .hero-outer { padding: 24px 24px 0; }
        .hero { max-width: 1200px; margin: 0 auto; background: var(--ink); border-radius: 40px; padding: 64px 56px; display: flex; flex-wrap: wrap; align-items: center; gap: 56px; }
        .hero-text { flex: 1 1 420px; min-width: 0; display: flex; flex-direction: column; align-items: flex-start; gap: 28px; }
        .eyebrow { display: inline-flex; align-items: center; gap: 8px; padding: 7px 16px 7px 12px; border-radius: 999px; background: rgba(245,185,74,.16); color: var(--amber); font-size: 14px; font-weight: 700; }
        .eyebrow i { width: 8px; height: 8px; border-radius: 999px; background: var(--amber); }
        .hero h1 { margin: 0; font-weight: 800; font-size: clamp(40px, 6vw, 68px); line-height: .98; letter-spacing: -.035em; color: #fff; }
        .hero h1 em { font-style: normal; color: var(--amber); }
        .hero p { margin: 0; max-width: 480px; font-size: 19px; line-height: 1.6; color: #b8c4bb; }
        .actions { display: flex; flex-wrap: wrap; gap: 12px; }

        .hero-visual { flex: 1 1 400px; min-width: 0; position: relative; }
        .map { height: 560px; border-radius: 32px; overflow: hidden; background: #e6f2ea; }
        .map svg { display: block; width: 100%; height: 100%; }
        .float-chip { position: absolute; right: 20px; top: 20px; display: flex; align-items: center; gap: 8px; padding: 8px 16px 8px 12px; border-radius: 999px; background: #fff; color: var(--ink); font-size: 14px; font-weight: 700; box-shadow: 0 8px 24px rgba(0,0,0,.2); }
        .float-chip i { width: 8px; height: 8px; border-radius: 999px; background: var(--amber); }
        .path-card { position: absolute; left: -24px; bottom: 28px; width: 310px; max-width: calc(100% - 8px); background: #fff; color: var(--ink); border-radius: 22px; padding: 20px; box-shadow: 0 20px 48px rgba(0,0,0,.3); }
        .path-label { display: inline-block; margin-bottom: 14px; font-size: 12px; font-weight: 700; color: var(--amber-text); background: var(--amber-50); padding: 4px 10px; border-radius: 999px; }
        .path { list-style: none; margin: 0; padding: 0; }
        .path li { position: relative; display: flex; gap: 14px; padding-bottom: 18px; }
        .path li:last-child { padding-bottom: 0; }
        .path li:not(:last-child)::after { content: ''; position: absolute; left: 7px; top: 20px; bottom: 2px; border-left: 2px dashed #cfd8d0; }
        .dot { flex: none; width: 16px; height: 16px; margin-top: 4px; border-radius: 50%; border: 3px solid var(--green); background: #fff; }
        .path li.you .dot { border-color: var(--amber-dark); background: var(--amber); }
        .path strong { display: block; font-size: 15px; }
        .path .text { color: var(--muted); font-size: 13px; }

        /* Seksi */
        section { padding: 96px 0; }
        .wrap { max-width: 1120px; margin: 0 auto; padding: 0 32px; }
        .band { background: #fff; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
        .kicker { font-size: 15px; font-weight: 700; color: var(--green-text); }
        h2 { margin: 0; font-weight: 800; font-size: clamp(32px, 4.4vw, 52px); line-height: 1.03; letter-spacing: -.03em; }
        .sec-head { max-width: 700px; display: flex; flex-direction: column; gap: 14px; margin-bottom: 48px; }
        .grid { display: flex; flex-wrap: wrap; gap: 20px; list-style: none; margin: 0; padding: 0; }

        .card { flex: 1 1 300px; min-width: 0; display: flex; flex-direction: column; gap: 14px; padding: 32px; background: var(--bg); border: 1px solid var(--line); border-radius: 28px; }
        .card .ic { display: flex; align-items: center; justify-content: center; width: 48px; height: 48px; border-radius: 16px; background: var(--green-60); color: var(--green-text); }
        .card h3 { margin: 0; font-size: 22px; font-weight: 800; letter-spacing: -.015em; }
        .card p { margin: 0; font-size: 16px; line-height: 1.6; color: var(--muted); }

        .step { flex: 1 1 300px; min-width: 0; min-height: 260px; display: flex; flex-direction: column; gap: 14px; padding: 36px; background: #fff; border: 1px solid var(--line); border-radius: 32px; }
        .step .num { font-size: 60px; font-weight: 800; line-height: 1; letter-spacing: -.04em; color: #f3dfbc; }
        .step h3 { margin: 0; font-size: 26px; font-weight: 800; letter-spacing: -.02em; }
        .step p { margin: 0; font-size: 17px; line-height: 1.6; color: var(--muted); }
        .step.tint { background: var(--amber-50); border-color: transparent; }
        .step.tint .num { color: #f0cf97; }
        .step.tint p { color: #5c4a2e; }
        .step.dark { background: var(--ink); border-color: transparent; color: #fff; }
        .step.dark .num { color: var(--amber); }
        .step.dark p { color: #b8c4bb; }

        .closing-outer { padding: 0 24px 96px; }
        .closing { max-width: 1200px; margin: 0 auto; display: flex; flex-direction: column; align-items: center; text-align: center; gap: 22px; padding: 72px 48px; background: var(--ink); color: #fff; border-radius: 40px; }
        .closing h2 { max-width: 700px; font-size: clamp(34px, 5vw, 56px); line-height: 1; }
        .closing p { margin: 0; max-width: 480px; font-size: 19px; line-height: 1.6; color: #b8c4bb; }

        /* footer { background: #fff; border-top: 1px solid var(--line); }
        .foot { max-width: 1120px; margin: 0 auto; padding: 28px 32px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; font-size: 15px; color: var(--muted); }
        .foot strong { font-family: 'Cabinet Grotesk', sans-serif; font-size: 18px; font-weight: 800; color: var(--green); } */

        @media (max-width: 760px) {
            .hero { padding: 40px 24px; border-radius: 32px; gap: 40px; }
            .hero .btn { width: 100%; }
            .map { height: 480px; }
            .path-card { left: 12px; bottom: 16px; }
            section { padding: 64px 0; }
            .wrap, .foot { padding-left: 24px; padding-right: 24px; }
            .closing { padding: 56px 24px; border-radius: 32px; }
            .nav-links { display: none; }
        }
        @media (prefers-reduced-motion: reduce) { html { scroll-behavior: auto; } }
    </style>
</head>

<body>
<div class="nav-outer">
    <nav class="nav" aria-label="Utama">
        <a class="brand" href="{{ url('/') }}">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Tani Harvest Logo" style="height: 40px; width: auto; margin-right: 12px; object-fit: contain;">            
        Tani Harvest
            <span class="tag">Kurir</span>
        </a>
        <div class="nav-links">
            <a href="#syarat">Persyaratan</a>
            <a href="#daftar">Cara mendaftar</a>
            <a href="{{ url('/') }}">Tani Harvest utama</a>
        </div>
        <div class="nav-actions">
            <a class="login" href="{{ route('login') }}">Masuk</a>
            <a class="btn btn-sm btn-brown" href="{{ route('register.kurir') }}">Daftar sebagai kurir</a>
        </div>
    </nav>
</div>

<main>
    <div class="hero-outer">
        <header class="hero">
            <div class="hero-text">
                <h1>Antar hasil panen, <em>jadi mitra kurir kami</em></h1>
                <p>Anda yang menghubungkan petani dengan pembeli. Daftar secara online dengan data diri, kendaraan, dan dokumen Anda.</p>
                <div class="actions">
                    <a class="btn btn-amber" href="{{ route('register.kurir') }}">
                        Daftar sebagai kurir
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    <a class="btn btn-line" href="#syarat">Lihat persyaratan</a>
                </div>
            </div>

            <div class="hero-visual">
                <div class="map">
                    <svg viewBox="0 0 520 600" preserveAspectRatio="xMidYMid slice" role="img" aria-label="Ilustrasi peta rute dari kebun petani ke rumah pembeli">
                        <rect width="520" height="600" fill="#e6f2ea"/>
                        <rect x="-20" y="30" width="170" height="130" rx="20" fill="#cfe5d7" transform="rotate(-6 60 90)"/>
                        <rect x="175" y="-20" width="150" height="160" rx="20" fill="#b9dcc6"/>
                        <rect x="345" y="40" width="190" height="120" rx="20" fill="#cfe5d7"/>
                        <rect x="-10" y="400" width="190" height="220" rx="20" fill="#b9dcc6"/>
                        <rect x="370" y="360" width="170" height="250" rx="20" fill="#cfe5d7"/>
                        <g stroke="#7cc79a" stroke-width="2" stroke-linecap="round" opacity="0.7">
                            <path d="M200 20H300M200 44H300M200 68H300M200 92H300"/>
                            <path d="M20 430H160M20 454H160M20 478H160M20 502H160"/>
                            <path d="M380 70H510M380 94H510M380 118H510"/>
                        </g>
                        <path d="M-10 285 Q130 345 240 315 T540 355" fill="none" stroke="#cfe3f5" stroke-width="34" stroke-linecap="round"/>
                        <circle cx="60" cy="335" r="10" fill="#7cc79a"/>
                        <circle cx="84" cy="352" r="8" fill="#7cc79a"/>
                        <circle cx="250" cy="440" r="10" fill="#7cc79a"/>
                        <circle cx="276" cy="456" r="8" fill="#7cc79a"/>
                        <circle cx="470" cy="250" r="9" fill="#7cc79a"/>
                        <path d="M90 120 C90 260 300 220 300 330 S420 470 430 520" fill="none" stroke="#d5dbd2" stroke-width="30" stroke-linecap="round"/>
                        <path d="M90 120 C90 260 300 220 300 330 S420 470 430 520" fill="none" stroke="#ffffff" stroke-width="24" stroke-linecap="round"/>
                        <path d="M90 120 C90 260 300 220 300 330 S420 470 430 520" fill="none" stroke="#f5b94a" stroke-width="5" stroke-linecap="round" stroke-dasharray="1 11"/>

                        <circle cx="90" cy="120" r="32" fill="#166534" opacity="0.18"/>
                        <circle cx="90" cy="120" r="22" fill="#166534"/>
                        <g transform="translate(74 104)" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 22c0-7 5-11 12-11 0 7-4 12-11 12"/><path d="M10 22l6-6"/>
                        </g>

                        <circle cx="195" cy="236" r="30" fill="#f5b94a" opacity="0.28"/>
                        <circle cx="195" cy="236" r="18" fill="#f5b94a" stroke="#14201a" stroke-width="3"/>
                        <g transform="translate(195 236)" fill="none" stroke="#14201a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="-8" y="-6" width="10" height="9"/><path d="M2 -3H7L9 0V3H2"/>
                            <circle cx="-5" cy="5.5" r="2" fill="#14201a"/><circle cx="6" cy="5.5" r="2" fill="#14201a"/>
                        </g>

                        <circle cx="430" cy="520" r="32" fill="#14201a" opacity="0.14"/>
                        <circle cx="430" cy="520" r="22" fill="#14201a"/>
                        <g transform="translate(430 520)" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M-9 1L0 -8L9 1"/><path d="M-5 -1V9H5V-1"/>
                        </g>
                    </svg>
                </div>

                <div class="float-chip"><i></i>Jemput lalu antar</div>

                <div class="path-card">
                    <span class="path-label">Alur pengantaran</span>
                    <ol class="path" aria-label="Peran kurir dalam pengantaran">
                        <li><span class="dot"></span><span><strong>Petani</strong><span class="text">Menyiapkan hasil panen yang dipesan.</span></span></li>
                        <li class="you"><span class="dot"></span><span><strong>Anda, mitra kurir</strong><span class="text">Mengambil pesanan dan mengantarkannya.</span></span></li>
                        <li><span class="dot"></span><span><strong>Pembeli</strong><span class="text">Menerima pesanan di alamat tujuan.</span></span></li>
                    </ol>
                </div>
            </div>
        </header>
    </div>

    <section class="band" id="syarat" style="margin-top:112px">
        <div class="wrap">
            <div class="sec-head">
                <span class="kicker">Persyaratan</span>
                <h2>Yang perlu Anda siapkan</h2>
            </div>
            <ul class="grid">
                @foreach ($syarat as $s)
                    <li class="card">
                        <span class="ic">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $s['icon'] !!}</svg>
                        </span>
                        <h3>{{ $s['t'] }}</h3>
                        <p>{{ $s['d'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <section id="daftar">
        <div class="wrap">
            <div class="sec-head">
                <span class="kicker">Cara mendaftar</span>
                <h2>Tiga langkah menjadi kurir</h2>
            </div>
            <ol class="grid">
                @foreach ($langkah as $l)
                    <li class="step {{ $l['v'] }}">
                        <span class="num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <h3>{{ $l['t'] }}</h3>
                        <p>{{ $l['d'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <div class="closing-outer">
        <div class="closing">
            <h2>Sudah siap mendaftar?</h2>
            <p>Siapkan foto dokumen Anda, lalu isi formulirnya.</p>
            <a class="btn btn-amber" href="{{ route('register.kurir') }}">Daftar sebagai kurir</a>
        </div>
    </div>
</main>

<footer>
    <footer class="bg-white border-top py-4 text-center text-secondary">
        <div class="container">
            <span class="fw-semibold text-success">Tani Harvest</span>
            <p class="mb-0 mt-1" style="font-size: 0.85rem;">&copy; {{ date('Y') }} Tani Harvest. Hak Cipta Dilindungi.</p>
        </div>
    </footer>
</footer>
</body>
</html>