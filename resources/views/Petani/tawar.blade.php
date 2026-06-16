@extends('layouts.app')

@section('title', 'Tawarkan Hasil Panen')
@section('page-title', 'Tawarkan Hasil Panen')

@section('content')
<div class="container-fluid">
    <div class="container py-3">
        <div class="justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4 mb-4" style="background: #e8f5e9; border-left: 5px solid #28a745;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-success text-white p-2 rounded-3 me-3">
                                <i class="bi bi-info-circle-fill fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-success mb-1" style="font-size: 14px;">Merespon Permintaan Pasar</h5>
                                <p class="text-muted small mb-0" style="font-size: 13px;">
                                    Anda sedang menawarkan hasil panen untuk komoditas yang dicari oleh pembeli. pastikan kualitas tanamen Anda sesuai standar.
                                </p>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 mt-2">
            @forelse($pengajuanTawar as $tawar)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4 position-relative overflow-hidden bg-white">
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="text-muted d-block" style="font-size: 11px; font-weight: 600;">ID PERMINTAAN</span>
                                <strong class="text-dark small">#{{ $tawar->idMinta }}</strong>
                            </div>
                            
                            @if($tawar->Status == 'Pending')
                                <span class="badge px-3 py-1 rounded-pill text-white" style="background-color: #0f8a5f; font-size: 11px;">Mendesak</span>
                            @elseif($tawar->Status == 'Diterima' || $tawar->Status == 'Disetujui')
                                <span class="badge px-3 py-1 rounded-pill text-white" style="background-color: #28a745; font-size: 11px;">Rutin</span>
                            @else
                                <span class="badge px-3 py-1 rounded-pill text-white" style="background-color: #dc3545; font-size: 11px;">Ditolak</span>
                            @endif
                        </div>

                        @if($tawar->Gambar)
                            <div class="mb-3 rounded-3 overflow-hidden" style="height: 140px;">
                                <img src="{{ asset($tawar->Gambar) }}" class="w-100 h-100 object-fit-cover" alt="{{ $tawar->NamaTanaman }}">
                            </div>
                        @endif

                        <div class="mb-3">
                            <h4 class="fw-bold m-0" style="color: #0f8a5f; font-size: 18px;">{{ $tawar->NamaTanaman }}</h4>
                            <span class="text-muted small" style="font-size: 13px;">{{ $tawar->Komoditas }}</span>
                        </div>

                        <div class="rounded-3 p-3 mb-3 d-flex justify-content-between text-center" style="background-color: #f8f9fa;">
                            <div class="w-50 border-end">
                                <span class="text-muted d-block mb-1" style="font-size: 11px;">Jumlah Tawar</span>
                                <strong class="text-dark" style="font-size: 14px;">{{ $tawar->JumlahTawar }} Kg</strong>
                            </div>
                            <div class="w-50">
                                <span class="text-muted d-block mb-1" style="font-size: 11px;">Harga Tawar</span>
                                <strong class="text-dark" style="font-size: 14px;">Rp{{ number_format($tawar->HargaTawar, 0, ',', '.') }}/kg</strong>
                            </div>
                        </div>

                        <div class="mt-auto pt-2 border-top">
                            <span class="text-muted d-block mb-1" style="font-size: 11px; font-weight: 600;">Catatan Anda:</span>
                            <p class="text-secondary small m-0 text-truncate" title="{{ $tawar->Catatan }}">
                                "{{ $tawar->Catatan }}"
                            </p>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted mb-2">
                        <i class="bi bi-envelope-open fs-1"></i>
                    </div>
                    <h5 class="text-secondary fw-bold">Belum Ada Riwayat Penawaran</h5>
                    <p class="text-muted small">Silakan pilih permintaan pasar pembeli untuk mengirimkan penawaran panen Anda.</p>
                </div>
            @endforelse
        </div>
        </div>
    </div>
</div>
@endsection