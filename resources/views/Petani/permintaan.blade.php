@extends('layouts.app')

@section('title', 'Cari Permintaan Pasar')
@section('page-title', 'Cari Permintaan Pasar')

@section('content')
{{-- BUNGKUSAN UTAMA: Memastikan konten didorong ke bawah navbar dan tidak merusak layout --}}
<div class="container-fluid pt-3">

    {{-- KOTAK AREA PENCARIAN --}}
    <div class="card shadow-sm border-0 rounded-4" style="background: #fff; margin-top: -20px; margin-bottom: 25px;">
        <div class="card-body p-4">
            <form action="{{ route('permintaan.index') }}" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-md-10">
                        <div class="input-group border rounded-3 overflow-hidden bg-light">
                            <span class="input-group-text bg-light border-0 text-muted ps-3">
                                <i class="bi bi-search"></i>
                            </span>
                            
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100 py-2.5 rounded-3 fw-semibold shadow-sm">
                            <i class="bi bi-search me-2"></i>Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- GRID KARTU PERMINTAAN PASAR --}}
    <div class="row g-4">
        @forelse($permintaan as $item)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 h-100 position-relative hover-card" style="transition: transform 0.2s; background: #fff;">
                    
                    <span class="position-absolute top-0 end-0 bg-success text-white small px-3 py-1 fw-medium" style="border-bottom-left-radius: 14px; border-top-right-radius: 15px; font-size: 11px;">
                        {{ $item->Status ?? 'Dibutuhkan' }}
                    </span>

                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light p-2 rounded-3 me-3 text-success">
                                <i class="bi bi-building fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 15px;">
                                    {{ $item->user->pembeliProfile->nama_toko ?? $item->user->username ?? 'Pembeli Belum Set Nama' }}
                                </h6>
                                <span class="text-muted small" style="font-size: 12px;">
                                    <i class="bi bi-geo-alt-fill me-1"></i> 
                                    {{ $item->user->pembeliProfile->alamat ?? 'Lokasi belum diatur' }}
                                </span>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25 my-3">

                        <div class="mb-4">

                            <h4 class="fw-bold text-success mb-2" style="font-size: 19px;">{{ $item->NamaTanaman }}</h4>

                            <h4 class="text-muted d-block small mb-3" style="font-size: 12px;">{{ $item->Komoditas ?? 'Sayuran' }}</h4> 

                            <div class="row text-center bg-light rounded-3 p-2 g-0">
                                <div class="col-6 border-end">
                                    <span class="text-muted d-block small" style="font-size: 11px;">Jumlah Butuh</span>
                                    <strong class="text-dark d-block mt-1" style="font-size: 14px;">{{ number_format($item->JumlahDibutuhkan, 0, ',', '.') }} Kg</strong>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted d-block small" style="font-size: 11px;">Target Harga</span>
                                    <strong class="text-dark d-block mt-1" style="font-size: 14px;">Rp{{ number_format($item->HargaMaksimal, 0, ',', '.') }}/kg</strong>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center small text-muted mb-4" style="font-size: 12px;">
                            <span><i class="bi bi-calendar-event me-2"></i>Batas Akhir :</span>
                            <span class="fw-semibold text-danger">{{ \Carbon\Carbon::parse($item->BatasTanggal)->format('d M Y') }}</span>
                        </div>
                        
                        <a href="{{ route('tawar.create', [
                            'idMinta' => $item->idPermintaan, 
                            'NamaTanaman' => $item->NamaTanaman, 
                            'Komoditas' => $item->Komoditas
                        ]) }}"
                            class="btn btn-success w-100 py-2.5 rounded-3 fw-semibold shadow-sm text-center text-white text-decoration-none d-block" style="font-size: 13px;">
                            <i class="bi bi-send-fill me-2"></i>Tawarkan Hasil Panen
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted display-5 mb-3"><i class="bi bi-inbox text-success opacity-40"></i></div>
                <h5 class="fw-bold text-dark">Permintaan Tidak Ditemukan</h5>
                <p class="text-muted small">Saat ini tidak ada pembeli yang mencari komoditas tersebut.</p>
            </div>
        @endforelse
    </div>

</div>

{{-- Efek Hover --}}
<style>
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .5rem 1.5rem rgba(40, 167, 69, 0.15) !important;
    }
</style>
@endsection