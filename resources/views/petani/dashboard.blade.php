@extends('layouts.app')

@section('title', 'Dashboard Petani')
@section('page-title', 'Dashboard Petani')

@section('content')


{{-- BARIS 2: PERMINTAAN & PENGAJUAN TAWAR --}}
<div class="row g-4 align-items-stretch">

    {{-- KOLOM KIRI: PERMINTAAN TERBARU --}}
    <div class="col-12 col-lg-7">
        <div class="card border-0 h-100 p-4" style="border-radius: 16px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03); background-color: #fff;">
        
        {{-- Header Card --}}
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                <i class="bi bi-geo-alt-fill text-danger"></i> Permintaan Terbaru
            </h6>
        </div>

        {{-- List Permintaan --}}
        <div class="d-flex flex-column gap-3">
            @forelse($permintaanTerdekat as $req)
                <div class="px-4 py-3" style="background-color: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                    
                    {{-- BAGIAN ATAS: Nama, Volume (Kecil), dan Badge --}}
                    <div class="d-flex flex-column align-items-start mb-3">
                        <div class="d-flex align-items-baseline gap-2 mb-1">
                            <h6 class="fw-bold text-dark mb-0 text-capitalize" style="font-size: 18px;">
                                {{ $req->NamaTanaman }}
                            </h6>
                            <span class="text-muted" style="font-size: 13px;">
                                {{ number_format($req->JumlahDibutuhkan, 0, ',', '.') }} kg
                            </span>
                        </div>
                        <span class="badge" style="background-color: #d1fae5; color: #059669; border-radius: 20px; font-size: 10px; padding: 4px 12px; font-weight: 500;">
                            Aktif
                        </span>
                    </div>

                    {{-- BAGIAN BAWAH: Detail Memanjang Kiri - Kanan --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pt-3" style="border-top: 1px dashed #cbd5e1; font-size: 13px;">
                        
                        {{-- Info Kiri ( Harga Maks, Batas) --}}
                        <div class="d-flex align-items-center flex-wrap gap-4">
                            <div class="text-muted">
                                <i class="bi bi-cash text-success me-1"></i> Harga Maks: 
                                <span class="fw-bold text-success">Rp {{ number_format($req->HargaMaksimal, 0, ',', '.') }}/kg</span>
                            </div>
                            <div class="text-muted">
                                <i class="bi bi-clock text-success me-1"></i> Batas Waktu :
                                <span class="fw-bold text-success">{{ \Carbon\Carbon::parse($req->BatasTanggal)->translatedFormat('d M Y') }}
                            </div>
                            
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-4 text-muted">Belum ada permintaan pasar terbaru.</div>
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
                                    {{ $tawar->permintaan->NamaTanaman }}
                                </div>
                                <div class="tc-tawar-pasar text-muted" style="font-size: 12px;">
                                    <i class="bi bi-shop me-1"></i> 
                                    {{ $tawar->permintaan->user->profile->NamaLengkap ?? $tawar->permintaan->user->username ?? 'Toko Pembeli' }}
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