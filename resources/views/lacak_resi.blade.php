@extends('layouts.app22')
@section('title', 'Lacak Resi Pengiriman - Tani Harvest')

@section('content')
<div style="background-color: #f8fafc; min-height: 85vh; padding: 40px 15px;">
    <div style="max-width: 680px; margin: 0 auto;">
        
        {{-- HEADER LACAK RESI --}}
        <div class="text-center mb-4">
            <span class="badge bg-success-subtle text-success border border-success fw-bold px-3 py-1 rounded-pill mb-2">
                <i class="fas fa-truck-fast me-1"></i> Logistik Kurir Internal
            </span>
            <h2 class="fw-bold text-dark">Lacak Resi Pengiriman</h2>
            <p class="text-secondary small">Pantau posisi paket hasil panen Anda mulai dari kebun petani, gudang transit drop point, hingga tiba di rumah.</p>
        </div>

        {{-- FORM INPUT RESI --}}
        <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 mb-4 bg-white">
            <form action="{{ route('lacak.resi') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted ps-3">
                        <i class="fas fa-barcode fs-5"></i>
                    </span>
                    <input type="text" name="resi" class="form-control form-control-lg border-start-0 border-end-0 ps-1" placeholder="Masukkan Nomor Resi (contoh: TH-202611...)" value="{{ request('resi') }}" required style="font-size: 1rem;">
                    <button class="btn btn-success fw-bold px-4" type="submit">
                        <i class="fas fa-search me-1"></i> Lacak
                    </button>
                </div>
            </form>
        </div>

        {{-- HASIL PELACAKAN --}}
        @if($noResi && $pengiriman)
            @php
                $penawaran = $pengiriman->penawaran;
                $permintaan = $penawaran->permintaan ?? null;
                $komoditas = $permintaan->komoditas ?? null;
                $petani = $penawaran->petani ?? null;
                $pembeli = $permintaan->user ?? null;
                $trackings = $pengiriman->tracking;
            @endphp

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
                {{-- Header Status --}}
                <div class="p-3 p-md-4 bg-success text-white">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <div class="text-white-50 small">Nomor Resi Pengiriman:</div>
                            <h4 class="fw-bold mb-0 text-white">{{ $pengiriman->no_resi }}</h4>
                        </div>
                        <span class="badge bg-white text-success fw-bold px-3 py-2 rounded-pill fs-7 shadow-sm">
                            {{ $pengiriman->StatusPesanan }}
                        </span>
                    </div>
                </div>

                {{-- Detail Barang & Pengirim/Penerima --}}
                <div class="p-3 p-md-4 border-bottom bg-light">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <div class="small text-muted mb-1"><i class="fas fa-seedling text-success me-1"></i> Komoditas:</div>
                            <div class="fw-bold text-dark">{{ $komoditas->namatanaman ?? 'Komoditas Pertanian' }} ({{ number_format($penawaran->JumlahTawar, 0, ',', '.') }} Kg)</div>
                            <div class="small text-muted mt-1">Armada: <strong>Kurir Internal Tani Harvest</strong></div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="small text-muted mb-1"><i class="fas fa-user-check text-primary me-1"></i> Penerima:</div>
                            <div class="fw-bold text-dark">{{ $pembeli->profile->NamaLengkap ?? $pembeli->username ?? 'Pembeli' }}</div>
                            <div class="small text-muted text-truncate">{{ $pembeli->profile->Alamat ?? 'Alamat tujuan' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Timeline Perjalanan / Tracking --}}
                <div class="p-3 p-md-4">
                    <h6 class="fw-bold text-dark mb-4 pb-2 border-bottom">
                        <i class="fas fa-route text-success me-2"></i>Perjalanan Paket
                    </h6>

                    <div style="position: relative; padding-left: 20px; border-left: 2px solid #e2e8f0; margin-left: 10px;">
                        @forelse($trackings as $index => $t)
                            <div style="position: relative; margin-bottom: 25px;">
                                {{-- Bulatan Timeline --}}
                                <div style="position: absolute; left: -27px; top: 2px; width: 14px; height: 14px; border-radius: 50%; background: {{ $loop->last ? '#16a34a' : '#94a3b8' }}; border: 2px solid #ffffff; box-shadow: 0 0 0 2px {{ $loop->last ? '#16a34a' : '#94a3b8' }};"></div>
                                
                                <div class="d-flex flex-wrap justify-content-between align-items-baseline gap-1">
                                    <strong class="text-dark fs-6">{{ $t->status_log }}</strong>
                                    <span class="text-muted small">
                                        {{ \Carbon\Carbon::parse($t->waktu_scan)->translatedFormat('d M Y, H:i') }} WIB
                                    </span>
                                </div>

                                @if($t->dropPoint)
                                    <div class="small text-secondary mt-1">
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $t->dropPoint->nama_titik }} ({{ $t->dropPoint->kota }})
                                    </div>
                                @endif

                                @if($t->catatan)
                                    <p class="small text-muted mb-1 mt-1 fst-italic">"{{ $t->catatan }}"</p>
                                @endif

                                @if($t->foto_bukti)
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $t->foto_bukti) }}" target="_blank" class="d-inline-flex align-items-center gap-2 p-1 border rounded bg-light text-decoration-none small text-success fw-semibold">
                                            <img src="{{ asset('storage/' . $t->foto_bukti) }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                            <span><i class="fas fa-image me-1"></i> Bukti Foto</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted small mb-0">Belum ada riwayat pemindaian lokasi.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        @elseif($noResi && !$pengiriman)
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-white">
                <i class="fas fa-circle-exclamation text-warning fs-1 mb-3"></i>
                <h5 class="fw-bold text-dark">Nomor Resi Tidak Ditemukan</h5>
                <p class="text-secondary small mb-0">Nomor resi <strong>"{{ $noResi }}"</strong> belum terdaftar atau salah ketik. Pastikan memasukkan nomor resi yang sesuai.</p>
            </div>
        @endif

    </div>
</div>
@endsection
