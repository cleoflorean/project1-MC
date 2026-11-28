@extends('layouts.kurir')
@section('title', 'Dashboard Kurir - Tani Harvest')

@section('content')
<div class="container py-4">

    {{-- HEADER SAMBUTAN --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="fas fa-id-badge text-success me-2"></i>Dashboard Kurir
            </h3>
            <p class="text-secondary mb-0">Kelola rute penjemputan dari petani, update check-in drop point, dan serah terima ke pembeli.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('lacak.resi') }}" class="btn btn-outline-success rounded-pill fw-semibold shadow-sm">
                <i class="fas fa-barcode me-1"></i> Cek Nomor Resi
            </a>
        </div>
    </div>

    {{-- KARTU STATISTIK --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card-custom p-3 border-start border-4 border-primary">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Total Ditugaskan</div>
                        <div class="fs-3 fw-bold text-dark">{{ $totalTugas }}</div>
                    </div>
                    <div class="bg-primary-subtle text-primary rounded-circle p-3">
                        <i class="fas fa-boxes-packing fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card-custom p-3 border-start border-4 border-warning">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Dalam Perjalanan / Transit</div>
                        <div class="fs-3 fw-bold text-dark">{{ $sedangDiantar }}</div>
                    </div>
                    <div class="bg-warning-subtle text-warning rounded-circle p-3">
                        <i class="fas fa-route fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card-custom p-3 border-start border-4 border-success">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Terkirim / Selesai</div>
                        <div class="fs-3 fw-bold text-dark">{{ $selesai }}</div>
                    </div>
                    <div class="bg-success-subtle text-success rounded-circle p-3">
                        <i class="fas fa-circle-check fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABS PENGIRIMAN --}}
    <div class="card-custom overflow-hidden mb-4">
        <ul class="nav nav-tabs px-3 pt-3 bg-light border-bottom" id="kurirTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold text-dark" id="tugas-tab" data-bs-toggle="tab" data-bs-target="#tugas-pane" type="button" role="tab">
                    <i class="fas fa-truck-ramp-box me-1 text-primary"></i> Tugas Aktif Saya
                    <span class="badge bg-primary rounded-pill ms-1">{{ $pengirimanSaya->filter(fn($p) => !in_array($p->StatusPesanan, ['Pesanan Selesai', 'Selesai']))->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold text-dark" id="tersedia-tab" data-bs-toggle="tab" data-bs-target="#tersedia-pane" type="button" role="tab">
                    <i class="fas fa-hand-holding-box me-1 text-warning"></i> Paket Siap Dijemput
                    @if($paketTersedia->count() > 0)
                        <span class="badge bg-warning text-dark rounded-pill ms-1">{{ $paketTersedia->count() }}</span>
                    @endif
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold text-dark" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai-pane" type="button" role="tab">
                    <i class="fas fa-check-double me-1 text-success"></i> Riwayat Pengiriman Selesai
                    <span class="badge bg-secondary rounded-pill ms-1">{{ $selesai }}</span>
                </button>
            </li>
        </ul>

        <div class="tab-content p-3 p-md-4" id="kurirTabContent">
            
            {{-- TAB 1: TUGAS SAYA AKTIF --}}
            <div class="tab-pane fade show active" id="tugas-pane" role="tabpanel">
                @php
                    $tugasAktif = $pengirimanSaya->filter(fn($p) => !in_array($p->StatusPesanan, ['Pesanan Selesai', 'Selesai']));
                @endphp

                @forelse($tugasAktif as $item)
                    @php
                        $penawaran = $item->penawaran;
                        $permintaan = $penawaran->permintaan ?? null;
                        $komoditas = $permintaan->komoditas ?? null;
                        $petani = $penawaran->petani ?? null;
                        $pembeli = $permintaan->user ?? null;
                        $lastTracking = $item->tracking->last();
                    @endphp

                    <div class="card border rounded-3 p-3 mb-3 shadow-sm bg-white">
                        <div class="d-flex flex-wrap align-items-center justify-content-between border-bottom pb-2 mb-3 gap-2">
                            <div>
                                <span class="badge bg-success-subtle text-success border border-success fw-bold px-2 py-1">
                                    <i class="fas fa-barcode me-1"></i> Resi: {{ $item->no_resi ?? 'Belum terbit' }}
                                </span>
                                <span class="text-muted ms-2 small">
                                    <i class="fas fa-clock me-1"></i> {{ $item->created_at->translatedFormat('d M Y, H:i') }}
                                </span>
                            </div>
                            <div>
                                <span class="badge bg-primary px-3 py-1 rounded-pill">
                                    {{ $item->StatusPesanan }}
                                </span>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center">
                            {{-- Info Komoditas --}}
                            <div class="col-12 col-md-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 border overflow-hidden bg-light d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; flex-shrink: 0;">
                                        @if($penawaran->Gambar)
                                            <img src="{{ asset($penawaran->Gambar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="fas fa-leaf text-success fs-3"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1">{{ $komoditas->namatanaman ?? 'Komoditas Pertanian' }}</h6>
                                        <div class="text-secondary small">Volume: <strong>{{ number_format($penawaran->JumlahTawar, 0, ',', '.') }} Kg</strong></div>
                                        <div class="text-success fw-bold small">Rp {{ number_format($item->pembayaran->TotalBayar ?? ($penawaran->HargaTawar * $penawaran->JumlahTawar), 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Rute Pengiriman (Petani -> Pembeli) --}}
                            <div class="col-12 col-md-5">
                                <div class="small">
                                    <div class="mb-1 text-truncate">
                                        <i class="fas fa-location-dot text-danger me-1"></i>
                                        <strong class="text-dark">Petani:</strong> {{ $petani->profile->NamaLengkap ?? $petani->username ?? 'Petani' }}
                                        <span class="text-muted">({{ $petani->profile->Alamat ?? 'Alamat asal belum diisi' }})</span>
                                    </div>
                                    <div class="text-truncate">
                                        <i class="fas fa-flag-checkered text-success me-1"></i>
                                        <strong class="text-dark">Tujuan:</strong> {{ $pembeli->profile->NamaLengkap ?? $pembeli->username ?? 'Pembeli' }}
                                        <span class="text-muted">({{ $pembeli->profile->Alamat ?? 'Alamat tujuan belum diisi' }})</span>
                                    </div>
                                    @if($lastTracking)
                                        <div class="mt-2 text-primary fw-semibold small bg-light p-2 rounded">
                                            <i class="fas fa-info-circle me-1"></i> Status Terakhir: {{ $lastTracking->status_log }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Tombol Tindakan --}}
                            <div class="col-12 col-md-3 text-md-end">
                                <a href="{{ route('kurir.pengiriman.detail', $item->idPengiriman) }}" class="btn btn-success fw-bold w-100 rounded-pill shadow-sm py-2">
                                    <i class="fas fa-location-arrow me-1"></i> Kelola & Update
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-box-open text-muted fs-1 mb-3"></i>
                        <h6 class="fw-bold text-dark">Tidak ada tugas pengiriman yang aktif saat ini.</h6>
                        <p class="text-secondary small">Silakan periksa tab "Paket Siap Dijemput" untuk mengambil tugas baru.</p>
                    </div>
                @endforelse
            </div>

            {{-- TAB 2: PAKET TERSEDIA UNTUK DIAMBIL --}}
            <div class="tab-pane fade" id="tersedia-pane" role="tabpanel">
                @forelse($paketTersedia as $item)
                    @php
                        $penawaran = $item->penawaran;
                        $permintaan = $penawaran->permintaan ?? null;
                        $komoditas = $permintaan->komoditas ?? null;
                        $petani = $penawaran->petani ?? null;
                        $pembeli = $permintaan->user ?? null;
                    @endphp

                    <div class="card border rounded-3 p-3 mb-3 shadow-sm bg-white">
                        <div class="row g-3 align-items-center">
                            <div class="col-12 col-md-5">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 border overflow-hidden bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; flex-shrink: 0;">
                                        <i class="fas fa-seedling text-success fs-3"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1">{{ $komoditas->namatanaman ?? 'Komoditas' }}</h6>
                                        <div class="text-secondary small">Volume: <strong>{{ number_format($penawaran->JumlahTawar, 0, ',', '.') }} Kg</strong></div>
                                        <div class="badge bg-warning text-dark">Siap Dijemput dari Petani</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="small">
                                    <div><i class="fas fa-user text-muted me-1"></i> <strong>Petani:</strong> {{ $petani->profile->NamaLengkap ?? $petani->username }}</div>
                                    <div class="text-muted text-truncate"><i class="fas fa-map-pin me-1"></i> {{ $petani->profile->Alamat ?? 'Jawa Barat' }}</div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3 text-md-end">
                                <form action="{{ route('kurir.pengiriman.ambil', $item->idPengiriman) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary fw-bold w-100 rounded-pill shadow-sm py-2">
                                        <i class="fas fa-hand-holding me-1"></i> Ambil Paket Ini
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-check-circle text-success fs-1 mb-3"></i>
                        <h6 class="fw-bold text-dark">Semua paket telah ditugaskan!</h6>
                        <p class="text-secondary small">Belum ada paket baru dari petani yang menunggu penjemputan.</p>
                    </div>
                @endforelse
            </div>

            {{-- TAB 3: RIWAYAT SELESAI --}}
            <div class="tab-pane fade" id="selesai-pane" role="tabpanel">
                @php
                    $riwayatSelesai = $pengirimanSaya->filter(fn($p) => in_array($p->StatusPesanan, ['Pesanan Selesai', 'Selesai', 'Menunggu Pesanan Diterima']));
                @endphp

                @forelse($riwayatSelesai as $item)
                    @php
                        $penawaran = $item->penawaran;
                        $permintaan = $penawaran->permintaan ?? null;
                        $komoditas = $permintaan->komoditas ?? null;
                    @endphp

                    <div class="card border rounded-3 p-3 mb-3 bg-light">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <span class="badge bg-secondary me-2">Resi: {{ $item->no_resi }}</span>
                                <strong class="text-dark">{{ $komoditas->namatanaman ?? 'Komoditas' }}</strong>
                                <span class="text-muted ms-2 small">({{ number_format($penawaran->JumlahTawar, 0, ',', '.') }} Kg)</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success-subtle text-success fw-bold px-3 py-1 rounded-pill">
                                    <i class="fas fa-check me-1"></i> {{ $item->StatusPesanan }}
                                </span>
                                <a href="{{ route('kurir.pengiriman.detail', $item->idPengiriman) }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                                    Lihat Riwayat
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-check text-muted fs-1 mb-3"></i>
                        <h6 class="fw-bold text-dark">Belum ada riwayat pengiriman selesai.</h6>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

</div>
@endsection
