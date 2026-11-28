@extends('layouts.app22')

@section('title', 'Beranda - Tani Harvest')

@php
$commodities = ['Cabai', 'Tomat', 'Bawang merah', 'Padi dan beras', 'Jagung', 'Kopi', 'Sayur hijau', 'Buah'];
$compare = [
    ['a' => 'Penjual memasang barang', 'b' => 'Pembeli menyebut kebutuhan'],
    ['a' => 'Pembeli mencari dan membandingkan', 'b' => 'Petani yang mengirim penawaran'],
    ['a' => 'Beli atau tidak', 'b' => 'Setujui atau tolak tiap penawaran'],
    ['a' => 'Dikirim lewat ekspedisi umum', 'b' => 'Kurir marketplace jemput dan antar'],
];
@endphp

@section('content')
<div style="width:100%;background:#f6f7f4;color:#14201a;font-family:'Satoshi',system-ui,sans-serif;font-size:17px;line-height:1.55;overflow-x:hidden">
    <section style="padding:56px 0 56px">
    <div style="max-width:1120px;margin:0 auto;padding:0 32px;box-sizing:border-box;display:flex;flex-wrap:wrap;align-items:center;gap:56px">
      <div style="flex:1 1 460px;min-width:0;display:flex;flex-direction:column;gap:28px;align-items:flex-start">
        
        <h1 class="d" style="margin:0;font-weight:800;font-size:clamp(20px,6vw,60px);line-height:0.98;letter-spacing:-0.035em">Sebut kebutuhan Anda, <span style="color:#166534">petani yang menawarkan.</span></h1>
        <p style="margin:0;font-size:19px;line-height:1.6;color:#55625a;max-width:500px">Ajukan kebutuhan komoditas, terima penawaran dari petani, lalu setujui yang paling cocok. Kurir Tani Harvest menjemput dan mengantar langsung ke Anda.</p>
        <div style="display:flex;flex-wrap:wrap;gap:12px">
          <a href="{{ route('register') }}" style="display:inline-flex;align-items:center;justify-content:center;gap:10px;min-height:56px;padding:0 30px;border-radius:999px;background:#166534;color:#ffffff;font-weight:700;font-size:17px">
            <span>Ajukan Kebutuhan</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </a>
          <a href="{{ route('register') }}" style="display:inline-flex;align-items:center;justify-content:center;min-height:56px;padding:0 30px;border-radius:999px;background:#ffffff;color:#14201a;border:1px solid #cfd8d0;font-weight:700;font-size:17px">Saya Petani</a>
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:10px 24px;font-size:15px;font-weight:500;color:#55625a;margin-top:4px">
          <span style="display:inline-flex;align-items:center;gap:8px"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#166534" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12l4 4 10-10"/></svg>Langsung dari petani</span>
          <span style="display:inline-flex;align-items:center;gap:8px"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#166534" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12l4 4 10-10"/></svg>Setujui atau tolak penawaran</span>
          <span style="display:inline-flex;align-items:center;gap:8px"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#166534" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12l4 4 10-10"/></svg>Kurir jemput dan antar</span>
        </div>
      </div>

      <div style="flex:1 1 420px;min-width:0;position:relative">
        <div style="border-radius:36px;overflow:hidden;height:580px;background:#f9f1dc">
          <svg viewBox="0 0 520 600" width="100%" height="100%" preserveAspectRatio="xMidYMid slice" role="img" aria-label="Ilustrasi perkebunan bertingkat dengan peti cabai, tomat, dan kubis">
            <rect width="520" height="600" fill="#f9f1dc"/>
            <circle cx="392" cy="150" r="96" fill="#f5b94a" opacity="0.28"/>
            <circle cx="392" cy="150" r="60" fill="#f5b94a"/>
            <path d="M0 300 Q130 232 260 282 T520 252 L520 600 L0 600Z" fill="#cfe5d7"/>
            <path d="M0 372 Q150 292 300 350 T520 330 L520 600 L0 600Z" fill="#7cc79a"/>
            <g fill="none" stroke="#1f8a49" stroke-width="3" stroke-linecap="round" opacity="0.4">
              <path d="M0 392 Q150 312 300 370 T520 350"/>
              <path d="M0 412 Q150 332 300 390 T520 370"/>
              <path d="M0 432 Q150 352 300 410 T520 390"/>
            </g>
            <g fill="#0f4224">
              <rect x="57" y="345" width="6" height="18"/><circle cx="60" cy="336" r="17"/>
              <rect x="92.5" y="335" width="5" height="14"/><circle cx="95" cy="328" r="13"/>
              <rect x="232.5" y="331" width="5" height="14"/><circle cx="235" cy="324" r="13"/>
              <rect x="262" y="338" width="6" height="16"/><circle cx="265" cy="330" r="15"/>
            </g>
            <path d="M0 452 Q140 392 280 440 T520 420 L520 600 L0 600Z" fill="#166534"/>
            <g fill="none" stroke="#1f8a49" stroke-width="3" stroke-linecap="round">
              <path d="M0 474 Q140 414 280 462 T520 442"/>
              <path d="M0 496 Q140 436 280 484 T520 464"/>
              <path d="M0 518 Q140 458 280 506 T520 486"/>
            </g>
            <path d="M0 548 Q200 520 520 546 L520 600 L0 600Z" fill="#0f4224"/>

            <g stroke="#c0392b" stroke-width="9" stroke-linecap="round" fill="none">
              <path d="M58 522 Q74 498 98 506"/>
              <path d="M82 526 Q100 498 124 506"/>
              <path d="M104 526 Q122 502 146 512"/>
              <path d="M66 514 Q84 492 108 498"/>
            </g>
            <g fill="#e2503a">
              <circle cx="228" cy="512" r="15"/>
              <circle cx="256" cy="508" r="15"/>
              <circle cx="284" cy="512" r="15"/>
              <circle cx="308" cy="516" r="13"/>
            </g>
            <g fill="#3b6d11">
              <ellipse cx="228" cy="498" rx="6" ry="2.5"/>
              <ellipse cx="256" cy="494" rx="6" ry="2.5"/>
              <ellipse cx="284" cy="498" rx="6" ry="2.5"/>
            </g>
            <g fill="#97c459">
              <circle cx="386" cy="508" r="17"/>
              <circle cx="420" cy="506" r="17"/>
              <circle cx="454" cy="510" r="17"/>
            </g>
            <g fill="none" stroke="#c0dd97" stroke-width="2.5" stroke-linecap="round">
              <path d="M374 508 Q386 494 398 508"/>
              <path d="M408 506 Q420 492 432 506"/>
              <path d="M442 510 Q454 496 466 510"/>
            </g>

            <g>
              <rect x="40" y="520" width="120" height="58" rx="6" fill="#c98a4b"/>
              <rect x="200" y="520" width="120" height="58" rx="6" fill="#c98a4b"/>
              <rect x="360" y="520" width="120" height="58" rx="6" fill="#c98a4b"/>
            </g>
            <g stroke="#a86a30" stroke-width="3" stroke-linecap="round">
              <path d="M46 540H154M46 558H154"/>
              <path d="M206 540H314M206 558H314"/>
              <path d="M366 540H474M366 558H474"/>
            </g>
          </svg>
        </div>

        <div style="position:absolute;right:20px;top:20px;background:#ffffff;border-radius:999px;padding:8px 16px 8px 12px;display:flex;align-items:center;gap:8px;font-size:14px;font-weight:700;box-shadow:0 8px 24px rgba(20,32,26,0.12)">
          <span style="width:8px;height:8px;border-radius:999px;background:#f5b94a"></span>
          Dijemput kurir Tani Harvest
        </div>

        <div style="position:absolute;left:-24px;bottom:28px;width:290px;max-width:calc(100% - 8px);box-sizing:border-box;background:#ffffff;border-radius:22px;padding:18px;box-shadow:0 20px 48px rgba(20,32,26,0.18);display:flex;flex-direction:column;gap:12px">
          <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
            <span style="font-size:12px;font-weight:700;color:#166534;background:#e6f2ea;padding:4px 10px;border-radius:999px">Penawaran baru</span>
            <span style="font-size:12px;color:#55625a">Contoh tampilan</span>
          </div>
          <div>
            <div class="d" style="font-size:20px;font-weight:800;letter-spacing:-0.01em">Cabai merah keriting</div>
            <div style="font-size:14px;color:#55625a">Pak Asep, Lembang · 50 kg</div>
          </div>
          <div class="d" style="font-size:22px;font-weight:800;color:#166534">Rp 38.000<span style="font-size:14px;font-weight:500;color:#55625a;font-family:'Satoshi',sans-serif">/kg</span></div>
          <div style="display:flex;gap:8px">
            <button type="button" style="flex:1;min-height:44px;border:0;border-radius:999px;background:#166534;color:#ffffff;font-family:inherit;font-size:14px;font-weight:700;cursor:pointer">Setujui</button>
            <button type="button" style="flex:1;min-height:44px;border:1px solid #cfd8d0;border-radius:999px;background:#ffffff;color:#14201a;font-family:inherit;font-size:14px;font-weight:700;cursor:pointer">Tolak</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="cara-kerja" style="padding:40px 0 96px">
    <div style="max-width:1120px;margin:0 auto;padding:0 32px;box-sizing:border-box;display:flex;flex-direction:column;gap:48px">
      <div style="max-width:700px;display:flex;flex-direction:column;gap:14px">
        <span style="font-size:15px;font-weight:700;color:#166534">Cara kerja</span>
        <h2 class="d" style="margin:0;font-weight:800;font-size:clamp(32px,4.4vw,52px);line-height:1.03;letter-spacing:-0.03em">Empat langkah dari kebutuhan sampai di tangan Anda</h2>
      </div>
      <div style="display:flex;flex-wrap:wrap;gap:20px">

        <div style="flex:1 1 440px;min-width:0;background:#ffffff;border:1px solid #e3e8e2;border-radius:32px;padding:36px;box-sizing:border-box;display:flex;flex-direction:column;gap:16px;min-height:300px">
          <div class="d" style="font-weight:800;font-size:60px;line-height:1;letter-spacing:-0.04em;color:#cfe5d7">01</div>
          <div class="d" style="font-size:26px;font-weight:800;letter-spacing:-0.02em">Ajukan kebutuhan</div>
          <div style="font-size:17px;line-height:1.6;color:#55625a;max-width:440px">Tulis jenis komoditas, jumlah, spesifikasi, dan harga yang Anda harapkan.</div>
          <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:auto;padding-top:8px">
            <span style="padding:7px 14px;border-radius:999px;background:#e6f2ea;color:#166534;font-size:14px;font-weight:700">Cabai merah</span>
            <span style="padding:7px 14px;border-radius:999px;background:#f1f3ef;font-size:14px;font-weight:500">50 kg</span>
            <span style="padding:7px 14px;border-radius:999px;background:#f1f3ef;font-size:14px;font-weight:500">Kirim ke Bandung</span>
          </div>
        </div>

        <div style="flex:1 1 440px;min-width:0;background:#e6f2ea;border-radius:32px;padding:36px;box-sizing:border-box;display:flex;flex-direction:column;gap:16px;min-height:300px">
          <div class="d" style="font-weight:800;font-size:60px;line-height:1;letter-spacing:-0.04em;color:#a9d3b8">02</div>
          <div class="d" style="font-size:26px;font-weight:800;letter-spacing:-0.02em">Petani menawarkan</div>
          <div style="font-size:17px;line-height:1.6;color:#3f5247;max-width:440px">Petani yang memiliki barangnya mengirim penawaran sesuai permintaan Anda.</div>
          <div style="display:flex;align-items:center;gap:10px;margin-top:auto;padding-top:8px">
            <span style="display:flex">
              <span style="width:36px;height:36px;border-radius:999px;background:#166534;color:#ffffff;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;border:2px solid #e6f2ea">A</span>
              <span style="width:36px;height:36px;border-radius:999px;background:#f5b94a;color:#14201a;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;border:2px solid #e6f2ea;margin-left:-10px">R</span>
              <span style="width:36px;height:36px;border-radius:999px;background:#14201a;color:#ffffff;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;border:2px solid #e6f2ea;margin-left:-10px">S</span>
            </span>
            <span style="font-size:15px;font-weight:700;color:#166534">Penawaran masuk dari beberapa petani</span>
          </div>
        </div>

        <div style="flex:1 1 440px;min-width:0;background:#ffffff;border:1px solid #e3e8e2;border-radius:32px;padding:36px;box-sizing:border-box;display:flex;flex-direction:column;gap:16px;min-height:300px">
          <div class="d" style="font-weight:800;font-size:60px;line-height:1;letter-spacing:-0.04em;color:#cfe5d7">03</div>
          <div class="d" style="font-size:26px;font-weight:800;letter-spacing:-0.02em">Setujui atau tolak</div>
          <div style="font-size:17px;line-height:1.6;color:#55625a;max-width:440px">Bandingkan kualitas dan harga, setujui yang cocok, tolak yang tidak sesuai.</div>
          <div style="display:flex;gap:8px;margin-top:auto;padding-top:8px;max-width:300px">
            <button type="button" style="flex:1;min-height:44px;border:0;border-radius:999px;background:#166534;color:#ffffff;font-family:inherit;font-size:14px;font-weight:700;cursor:pointer">Setujui</button>
            <button type="button" style="flex:1;min-height:44px;border:1px solid #cfd8d0;border-radius:999px;background:#ffffff;color:#14201a;font-family:inherit;font-size:14px;font-weight:700;cursor:pointer">Tolak</button>
          </div>
        </div>

        <div style="flex:1 1 440px;min-width:0;background:#166534;color:#ffffff;border-radius:32px;padding:36px;box-sizing:border-box;display:flex;flex-direction:column;gap:16px;min-height:300px">
          <div class="d" style="font-weight:800;font-size:60px;line-height:1;letter-spacing:-0.04em;color:#1f8a49">04</div>
          <div class="d" style="font-size:26px;font-weight:800;letter-spacing:-0.02em">Kurir jemput dan antar</div>
          <div style="font-size:17px;line-height:1.6;color:#cfe5d7;max-width:440px">Kurir Tani Harvest menjemput dari petani dan mengantar langsung ke alamat Anda.</div>
          <div style="display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin-top:auto;padding-top:8px;font-size:14px;font-weight:700">
            <span style="padding:7px 14px;border-radius:999px;background:rgba(255,255,255,0.14)">Kebun petani</span>
            <span aria-hidden="true">→</span>
            <span style="padding:7px 14px;border-radius:999px;background:#f5b94a;color:#14201a">Kurir</span>
            <span aria-hidden="true">→</span>
            <span style="padding:7px 14px;border-radius:999px;background:rgba(255,255,255,0.14)">Alamat Anda</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section style="background:#ffffff;border-top:1px solid #e3e8e2;border-bottom:1px solid #e3e8e2;padding:96px 0">
    <div style="max-width:1120px;margin:0 auto;padding:0 32px;box-sizing:border-box;display:flex;flex-wrap:wrap;gap:56px;align-items:flex-start">
      <div style="flex:1 1 320px;min-width:0;display:flex;flex-direction:column;gap:16px">
        <span style="font-size:15px;font-weight:700;color:#166534">Yang berbeda</span>
        <h2 class="d" style="margin:0;font-weight:800;font-size:clamp(32px,4.4vw,52px);line-height:1.03;letter-spacing:-0.03em">Pembeli memulai, bukan penjual</h2>
        <p style="margin:0;font-size:18px;line-height:1.6;color:#55625a;max-width:380px">Di Tani Harvest, kebutuhan datang lebih dulu. Petani menyesuaikan penawarannya dengan apa yang benar-benar dicari.</p>
      </div>
      <div style="flex:1.4 1 460px;min-width:0;border:1px solid #e3e8e2;border-radius:28px;overflow:hidden">
        <div style="display:flex;flex-wrap:wrap;background:#f6f7f4;font-size:14px;font-weight:700">
          <div style="flex:1 1 200px;padding:16px 24px;color:#55625a">Marketplace pada umumnya</div>
          <div style="flex:1 1 200px;padding:16px 24px;color:#166534;background:#e6f2ea">Tani Harvest</div>
        </div>
        @foreach ($compare as $r)
          <div style="display:flex;flex-wrap:wrap;border-top:1px solid #e3e8e2;font-size:16px">
            <div style="flex:1 1 200px;padding:18px 24px;color:#55625a">{{ $r['a'] }}</div>
            <div style="flex:1 1 200px;padding:18px 24px;font-weight:500;background:#f3f9f5">{{ $r['b'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section id="peran" style="padding:96px 0 40px">
    <div style="max-width:1120px;margin:0 auto;padding:0 32px;box-sizing:border-box;display:flex;flex-direction:column;gap:48px">
      <div style="max-width:700px;display:flex;flex-direction:column;gap:14px">
        <span style="font-size:15px;font-weight:700;color:#166534">Untuk siapa</span>
        <h2 class="d" style="margin:0;font-weight:800;font-size:clamp(32px,4.4vw,52px);line-height:1.03;letter-spacing:-0.03em">Satu platform, dua sisi yang bertemu</h2>
      </div>
      <div style="display:flex;flex-wrap:wrap;gap:20px">
        <div style="flex:1 1 440px;min-width:0;background:#166534;color:#ffffff;border-radius:32px;padding:40px;box-sizing:border-box;display:flex;flex-direction:column;gap:20px">
          <div class="d" style="font-size:34px;font-weight:800;letter-spacing:-0.025em">Pembeli</div>
          <div style="display:flex;flex-direction:column;gap:10px;font-size:17px;color:#cfe5d7">
            <span>Ajukan kebutuhan kapan pun diperlukan.</span>
            <span>Terima beberapa penawaran dari petani.</span>
            <span>Setujui atau tolak sesuai kecocokan.</span>
          </div>
          <a href="#" style="display:inline-flex;align-items:center;justify-content:center;align-self:flex-start;min-height:52px;padding:0 26px;border-radius:999px;background:#ffffff;color:#166534;font-weight:700;font-size:16px;margin-top:12px">Daftar sebagai Pembeli</a>
        </div>
        <div style="flex:1 1 440px;min-width:0;background:#e6f2ea;border-radius:32px;padding:40px;box-sizing:border-box;display:flex;flex-direction:column;gap:20px">
          <div class="d" style="font-size:34px;font-weight:800;letter-spacing:-0.025em">Petani</div>
          <div style="display:flex;flex-direction:column;gap:10px;font-size:17px;color:#3f5247">
            <span>Lihat permintaan yang masuk dari pembeli.</span>
            <span>Kirim penawaran untuk hasil tani yang Anda miliki.</span>
            <span>Barang dijemput kurir langsung dari lokasi Anda.</span>
          </div>
          <a href="#" style="display:inline-flex;align-items:center;justify-content:center;align-self:flex-start;min-height:52px;padding:0 26px;border-radius:999px;background:#166534;color:#ffffff;font-weight:700;font-size:16px;margin-top:12px">Daftar sebagai Petani</a>
        </div>
      </div>
    </div>
  </section>

  <section style="padding:20px 0 96px">
    <div style="max-width:1120px;margin:0 auto;padding:0 32px;box-sizing:border-box">
      <div style="background:#f5b94a;color:#14201a;border-radius:36px;padding:48px;box-sizing:border-box;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:32px">
        <div style="flex:1 1 400px;min-width:0;display:flex;flex-direction:column;gap:14px">
          <span style="font-size:15px;font-weight:700">Kurir Tani Harvest</span>
          <h2 class="d" style="margin:0;font-weight:800;font-size:clamp(30px,3.8vw,44px);line-height:1.04;letter-spacing:-0.03em">Menjemput dari kebun, mengantar sampai tujuan</h2>
          <p style="margin:0;font-size:17px;line-height:1.6;max-width:520px">Kurir punya halaman dan pendaftaran sendiri karena alur kerjanya berbeda dari pembeli dan petani.</p>
        </div>
        <a href="{{ route('kurir.landing') }}" style="display:inline-flex;align-items:center;justify-content:center;gap:10px;min-height:56px;padding:0 30px;border-radius:999px;background:#14201a;color:#ffffff;font-weight:700;font-size:17px">
          <span>Buka Halaman Kurir</span>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      </div>
    </div>
  </section>

    
</div>

<!-- Hero Section -->
{{-- <section class="hero-section position-relative overflow-hidden">
    <div class="container position-relative z-index-1">
        <div class="row align-items-center justify-content-center min-vh-75 py-5">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 fw-extrabold text-dark mb-4 animate-fade-in-up" style="animation-delay: 0.2s; letter-spacing: -1px;">
                    Dapatkan Komoditas Pertanian Terbaik <span class="text-gradient">Langsung dari Petani</span>
                </h1>
                <p class="lead text-secondary mb-5 px-lg-5 animate-fade-in-up" style="animation-delay: 0.3s; font-size: 1.25rem;">
                    Buat permintaan produk yang Anda butuhkan, dan biarkan ribuan petani memberikan penawaran terbaik mereka. Transparan, efisien, dan menguntungkan untuk bisnis Anda.
                </p>
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 animate-fade-in-up" style="animation-delay: 0.4s;">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-premium btn-lg px-5 py-3 fw-bold rounded-pill shadow-sm">
                            Buat Permintaan Sekarang <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="#cara-kerja" class="btn btn-outline-dark btn-lg px-5 py-3 fw-bold rounded-pill">
                            Pelajari Cara Kerja
                        </a>
                    @endguest
                    
                    @auth
                        <a href="{{ route('pembeli') }}" class="btn btn-premium btn-lg px-5 py-3 fw-bold rounded-pill shadow-sm">
                            Ke Dashboard <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
</section>

<!-- Cara Kerja Section -->
<section id="cara-kerja" class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark">Cara Kerja yang Mudah</h2>
            <p class="text-secondary">Tiga langkah sederhana untuk memenuhi kebutuhan pasokan Anda.</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Step 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="step-card h-100 p-5 bg-white rounded-4 shadow-sm text-center position-relative">
                    <div class="step-number">1</div>
                    <div class="icon-box bg-success-subtle text-success rounded-circle mb-4 mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-edit fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Buat Permintaan</h4>
                    <p class="text-secondary mb-0">Tentukan jenis komoditas, jumlah, spesifikasi, dan harga yang Anda harapkan.</p>
                </div>
            </div>
            
            <!-- Step 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="step-card h-100 p-5 bg-white rounded-4 shadow-sm text-center position-relative">
                    <div class="step-number">2</div>
                    <div class="icon-box bg-success-subtle text-success rounded-circle mb-4 mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-comments-dollar fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Terima Penawaran</h4>
                    <p class="text-secondary mb-0">Petani akan melihat permintaan Anda dan mengirimkan penawaran harga terbaik mereka.</p>
                </div>
            </div>
            
            <!-- Step 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="step-card h-100 p-5 bg-white rounded-4 shadow-sm text-center position-relative">
                    <div class="step-number">3</div>
                    <div class="icon-box bg-success-subtle text-success rounded-circle mb-4 mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-handshake fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Pilih & Transaksi</h4>
                    <p class="text-secondary mb-0">Bandingkan kualitas dan harga, pilih penawaran yang paling sesuai, lalu selesaikan transaksi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Bottom -->
<section class="cta-bottom py-5 bg-white">
    <div class="container py-5">
        <div class="cta-box bg-dark text-white rounded-5 p-5 text-center position-relative overflow-hidden shadow-lg" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <div class="position-relative z-index-1">
                <h2 class="display-6 fw-bold mb-3 text-white">Siap Mendapatkan Pasokan Terbaik?</h2>
                <p class="lead mb-4 text-white-50">Bergabunglah dengan ribuan pembeli lainnya di Tani Harvest.</p>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-premium btn-lg px-5 py-3 fw-bold rounded-pill">
                        Daftar Gratis Sekarang
                    </a>
                @else
                    <a href="{{ route('permintaan.index') }}" class="btn btn-premium btn-lg px-5 py-3 fw-bold rounded-pill">
                        Lihat Permintaan Saya
                    </a>
                @endguest
            </div>
            <!-- Decorative circle -->
            <div class="cta-circle"></div>
        </div>
    </div>
</section> --}}
@endsection