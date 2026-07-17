@extends('layouts.app')

@section('title', 'Dashboard Petani')
@section('page-title', 'Dashboard Petani')

@section('content')

{{-- BARIS 1: KARTU STATISTIK RINGKASAN --}}
<div class="row g-4 mb-4">

    {{-- Kartu: Total Penawaran Diajukan --}}
    {{-- <div class="col-12 col-md-6 col-xl-4">
        <div class="tc-card tc-stat-card">
            <div class="tc-stat-icon tc-stat-icon--biru">
                <i class="bi bi-tags-fill"></i>
            </div>
            <div class="tc-stat-body">
                <div class="tc-stat-number">{{ $dashboard['pengajuan_tawar'] }}</div>
                <div class="tc-stat-label">Total Penawaran</div>
            </div>
        </div>
    </div> --}}

    {{-- Kartu: Dalam Pengiriman --}}
    {{-- <div class="col-12 col-md-6 col-xl-4">
        <div class="tc-card tc-stat-card">
            <div class="tc-stat-icon tc-stat-icon--oranye">
                <i class="bi bi-truck"></i>
            </div>
            <div class="tc-stat-body">
                <div class="tc-stat-number">{{ $dashboard['dalam_pengiriman'] }}</div>
                <div class="tc-stat-label">Dalam Pengiriman</div>
            </div>
        </div>
    </div> --}}

    {{-- Kartu: Status Panen (Dikosongkan sesuai kesepakatan) --}}
    {{-- <div class="col-12 col-md-6 col-xl-4">
        <div class="tc-card tc-stat-card">
            <div class="tc-stat-icon tc-stat-icon--hijau">
                <i class="bi bi-basket3-fill"></i>
            </div>
            <div class="tc-stat-body">
                <div class="tc-stat-number">{{ $dashboard['menuju_panen'] }}</div>
                <div class="tc-stat-label">Jadwal Panen</div>
            </div>
        </div>
    </div> --}}
</div>

{{-- BARIS 2: PERMINTAAN & PENGAJUAN TAWAR --}}
<div class="row g-4 align-items-stretch">

    {{-- Permintaan Terdekat (Dari Pembeli) --}}
    <div class="col-12 col-lg-7">
        <div class="tc-card h-100">
            <div class="tc-card-header">
                <h6 class="tc-card-title">
                    <i class="bi bi-geo-alt-fill me-2 text-danger"></i> Permintaan Terbaru
                </h6>
                <a href="{{ route('petani.permintaan.index') }}" class="tc-link-kecil">Lihat Semua</a>
            </div>
            <div class="tc-card-body p-0">
                @forelse($permintaanTerdekat as $req)
                    <div class="tc-req-item" style="padding: 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                        <div class="tc-req-info" style="display: flex; gap: 15px; align-items: center;">
                            <div class="tc-req-detail">
                                <div class="tc-req-komoditas fw-bold text-success mb-1">
                                    {{ $req->NamaTanaman }}
                                </div>
                                <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">
                                    <i class="bi bi-box me-1"></i> {{ number_format($req->JumlahDibutuhkan, 0, ',', '.') }} Kg | 
                                    <i class="bi bi-geo-alt me-1"></i>{{ $req->user->pembeliProfile->Alamat ?? 'Lokasi tidak diketahui' }}
                                </div>
                                <div class="tc-req-deadline text-danger" style="font-size: 12px;">
                                    <i class="bi bi-clock me-1"></i> Batas: {{ \Carbon\Carbon::parse($req->BatasTanggal)->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="tc-req-harga text-end">
                            <div class="fw-bold mb-2">Rp{{ number_format($req->HargaMaksimal, 0, ',', '.') }}/kg</div>
                        </div>
                    </div>
                @empty
                    <div class="tc-empty-state py-5 text-center text-muted">
                        <i class="bi bi-shop display-4 opacity-50 mb-3"></i>
                        <p>Belum ada permintaan pasar terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Pengajuan Tawar Petani --}}
    <div class="col-12 col-lg-5">
        <div class="tc-card h-100">
            <div class="tc-card-header">
                <h6 class="tc-card-title">
                    <i class="bi bi-tags-fill me-2 text-warning"></i>
                    Riwayat Penawaran Anda
                </h6>
                <a href="{{ route('tawar.index') }}" class="tc-link-kecil">
                    Lihat Semua
                </a>
            </div>
            <div class="tc-card-body p-0">
                @forelse($pengajuanTawar as $tawar)
                    <div class="tc-tawar-item" style="padding: 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                        <div class="tc-tawar-info" style="display: flex; gap: 15px; align-items: center;">
                            <div class="tc-req-image">
                                @if($tawar->Gambar)
                                    <img src="{{ asset($tawar->Gambar) }}" alt="Gambar Tanaman" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                                @else
                                    <div style="width: 50px; height: 50px; border-radius: 8px; background: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="tc-tawar-text">
                                <div class="tc-tawar-komoditas fw-bold text-dark mb-1"> 
                                    {{ $tawar->NamaTanaman }}
                                </div>
                                <div class="tc-tawar-pasar text-muted" style="font-size: 12px;">
                                    <i class="bi bi-shop me-1"></i> 
                                    {{ $tawar->permintaan->user->pembeliProfile->NamaLengkap ?? $tawar->permintaan->user->username ?? 'Toko Pembeli' }}
                                </div>
                                <div class="tc-tawar-harga text-success mt-1" style="font-size: 13px; font-weight: 600;"> 
                                    Rp{{ number_format($tawar->HargaTawar, 0, ',', '.') }}/kg
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge {{ $tawar->Status == 'Pending' ? 'bg-warning text-dark' : ($tawar->Status == 'Diterima' ? 'bg-success' : 'bg-secondary') }}" style="border-radius: 4px; padding: 5px 10px;">
                                {{ $tawar->Status }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="tc-empty-state py-5 text-center text-muted">
                        <i class="bi bi-tags display-4 opacity-50 mb-3"></i>
                        <p>Belum ada penawaran yang Anda ajukan.</p>
                        <a href="{{ route('petani.permintaan.index') }}" class="btn btn-outline-success btn-sm mt-2">
                            Cari Permintaan
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Script grafik dihapus sementara untuk menghindari error JS, 
    // karena kita belum mengirim data array grafik dari controller.
</script>
@endpush