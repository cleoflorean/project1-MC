@extends('layouts.app')

@section('title', 'Cari Permintaan Pasar')
@section('page-title', 'Cari Permintaan Pasar')

@section('content')
<div class="container-fluid pt-3">

    {{-- ================= SECTION 1: PERMINTAAN AKTIF ================= --}}
    <h5 class="fw-bold text-success mb-3">
        <i class="bi bi-patch-check-fill me-2"></i>Permintaan Pasar Terbuka
    </h5>
    
    <div class="row g-4 mb-5">
        @forelse($permintaanAktif as $item)
            @php
                $isExpired = \Carbon\Carbon::parse($item->BatasTanggal)->endOfDay()->isPast();
            @endphp
            
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 h-100 position-relative hover-card" style="transition: transform 0.2s; background: #fff;">
                    
                    <span class="position-absolute top-0 end-0 px-3 py-1 fw-medium bg-success text-white small" style="border-bottom-left-radius: 14px; border-top-right-radius: 15px; font-size: 11px;">
                        {{ $item->Status ?? 'Dibutuhkan' }}
                    </span>

                    <div class="card-body p-4 pt-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light p-2 rounded-3 me-3 text-success">
                                <i class="bi bi-shop fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 15px;">
                                    {{ $item->user->pembeliProfile->NamaLengkap ?? $item->user->username ?? 'Pembeli' }}
                                </h6>
                                <span class="text-muted small" style="font-size: 12px;">
                                    <i class="bi bi-geo-alt-fill me-1 text-danger"></i> 
                                    {{ $item->user->pembeliProfile->Alamat ?? 'Lokasi belum diatur' }}
                                </span>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25 my-3">

                        <div class="mb-4">
                            <h4 class="fw-bold text-success mb-1" style="font-size: 19px;">{{ $item->NamaTanaman }}</h4>
                            <span class="badge bg-light text-secondary border mb-3">{{ $item->Komoditas ?? 'Sayuran' }}</span> 

                            <div class="row text-center bg-light rounded-3 p-2 g-0 border border-light-subtle">
                                <div class="col-6 border-end">
                                    <span class="text-muted d-block small" style="font-size: 11px;">Volume Butuh</span>
                                    <strong class="text-dark d-block mt-1" style="font-size: 14px;">{{ number_format($item->JumlahDibutuhkan, 0, ',', '.') }} Kg</strong>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted d-block small" style="font-size: 11px;">Harga Maks</span>
                                    <strong class="text-dark d-block mt-1" style="font-size: 14px;">Rp{{ number_format($item->HargaMaksimal, 0, ',', '.') }}<small class="text-muted fw-normal">/kg</small></strong>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center small text-muted mb-4" style="font-size: 12px;">
                            <span><i class="bi bi-clock-history me-1"></i>Batas Akhir:</span>
                            <span class="fw-bold text-dark">
                                {{ \Carbon\Carbon::parse($item->BatasTanggal)->format('d M Y') }}
                            </span>
                        </div>
                        
                        <a href="{{ route('tawar.create', ['idMinta' => $item->idPermintaan, 'NamaTanaman' => $item->NamaTanaman, 'Komoditas' => $item->Komoditas]) }}"
                            class="btn btn-success w-100 py-2.5 rounded-3 fw-semibold shadow-sm text-center text-white text-decoration-none d-block">
                            <i class="bi bi-send-fill me-2"></i>Tawarkan Hasil Panen
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-4 bg-white rounded-4 shadow-sm border border-light-subtle">
                <h6 class="text-muted mb-0 py-2">Belum ada permintaan pasar yang aktif saat ini.</h6>
            </div>
        @endforelse
    </div>


    {{-- ================= SECTION 2: PERMINTAAN KADALUARSA ================= --}}
    <div class="border-top pt-4 mt-5">
        <h5 class="fw-bold text-secondary mb-1">Riwayat Permintaan </h5>
        <p class="text-muted small mb-4">Daftar kebutuhan komoditas sebelumnya yang masanya telah berakhir.</p>
    </div>

    <div class="row g-4">
        @forelse($permintaanKadaluarsa as $item)
            {{-- opacity-70 ditambahkan agar tampilan kartu terlihat redup / menandakan barang sudah habis --}}
            <div class="col-12 col-md-6 col-lg-4 style-expired-card" style="opacity: 0.7;">
                <div class="card shadow-sm border-0 rounded-4 h-100 position-relative bg-white">
                    
                    <span class="position-absolute top-0 end-0 px-3 py-1 fw-medium bg-danger text-white small" style="border-bottom-left-radius: 14px; border-top-right-radius: 15px; font-size: 11px;">
                        Kadaluarsa
                    </span>

                    <div class="card-body p-4 pt-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light p-2 rounded-3 me-3 text-secondary">
                                <i class="bi bi-shop fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 15px;">
                                    {{ $item->user->pembeliProfile->NamaLengkap ?? $item->user->username ?? 'Pembeli' }}
                                </h6>
                                <span class="text-muted small" style="font-size: 12px;">
                                    <i class="bi bi-geo-alt-fill me-1 text-danger"></i> 
                                    {{ $item->user->pembeliProfile->Alamat ?? 'Lokasi belum diatur' }}
                                </span>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25 my-3">

                        <div class="mb-4">
                            <h4 class="fw-bold text-secondary mb-1" style="font-size: 19px;">{{ $item->NamaTanaman }}</h4>
                            <span class="badge bg-light text-secondary border mb-3">{{ $item->Komoditas ?? 'Sayuran' }}</span> 

                            <div class="row text-center bg-light rounded-3 p-2 g-0 border border-light-subtle">
                                <div class="col-6 border-end">
                                    <span class="text-muted d-block small" style="font-size: 11px;">Volume Butuh</span>
                                    <strong class="text-muted d-block mt-1" style="font-size: 14px;">{{ number_format($item->JumlahDibutuhkan, 0, ',', '.') }} Kg</strong>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted d-block small" style="font-size: 11px;">Harga Maks</span>
                                    <strong class="text-muted d-block mt-1" style="font-size: 14px;">Rp{{ number_format($item->HargaMaksimal, 0, ',', '.') }}<small class="text-muted fw-normal">/kg</small></strong>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center small text-muted mb-4" style="font-size: 12px;">
                            <span><i class="bi bi-clock-history me-1"></i>Batas Akhir:</span>
                            <span class="fw-bold text-danger">
                                {{ \Carbon\Carbon::parse($item->BatasTanggal)->format('d M Y') }}
                            </span>
                        </div>
                        
                        <button class="btn btn-secondary w-100 py-2.5 rounded-3 fw-semibold border-0 text-white" style="font-size: 13px; cursor: not-allowed;" disabled>
                            <i class="bi bi-x-circle me-2"></i>Waktu Telah Habis
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-4 bg-light rounded-4 border">
                <span class="text-muted small">Tidak ada riwayat permintaan lama.</span>
            </div>
        @endforelse
    </div>

</div>

{{-- Efek Hover khusus kartu aktif --}}
<style>
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .5rem 1.5rem rgba(40, 167, 69, 0.15) !important;
    }
</style>
@endsection