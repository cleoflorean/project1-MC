@extends('layouts.app')

@section('title', 'Tawarkan Hasil Panen')
@section('page-title', 'Tawarkan Hasil Panen')

@section('content')
<div class="container-fluid">
    <div class="container py-3">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4 mt-2">
            @forelse($pengajuanTawar as $tawar)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 rounded-4 h-100 position-relative hover-card" style="transition: transform 0.2s; background: #fff;">

                        {{-- Badge Status di pojok kanan atas --}}
                        @if($tawar->Status == 'Pending')
                            <span class="position-absolute top-0 end-0 text-white small px-3 py-1 fw-medium" style="background-color: #ffc107; border-bottom-left-radius: 14px; border-top-right-radius: 15px; font-size: 11px;">Pending</span>
                        @elseif($tawar->Status == 'Setuju')
                            <span class="position-absolute top-0 end-0 text-white small px-3 py-1 fw-medium" style="background-color: #28a745; border-bottom-left-radius: 14px; border-top-right-radius: 15px; font-size: 11px;">Disetujui</span>
                        @elseif($tawar->Status == 'Tidak Setuju')
                            <span class="position-absolute top-0 end-0 text-white small px-3 py-1 fw-medium" style="background-color: #dc3545; border-bottom-left-radius: 14px; border-top-right-radius: 15px; font-size: 11px;">Ditolak</span>
                        @else
                            <span class="position-absolute top-0 end-0 text-white small px-3 py-1 fw-medium" style="background-color: #6c757d; border-bottom-left-radius: 14px; border-top-right-radius: 15px; font-size: 11px;">{{ $tawar->Status }}</span>
                        @endif

                        <div class="card-body p-4">

                            {{-- Info Pembeli --}}
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-light p-2 rounded-3 me-3 text-success">
                                    <i class="bi bi-building fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 15px;">
                                        {{ $tawar->permintaan->user->pembeliProfile->NamaLengkap ?? $tawar->permintaan->user->username ?? 'Penawaran Panen' }}
                                    </h6>
                                    <span class="text-muted small" style="font-size: 12px;">
                                        <i class="bi bi-geo-alt-fill me-1"></i>
                                        {{ $tawar->permintaan->user->pembeliProfile->Alamat ?? 'Lokasi belum diatur' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Foto Jika Ada --}}
                            @if($tawar->Gambar)
                                <div class="mb-3 rounded-3 overflow-hidden" style="height: 140px;">
                                    <img src="{{ asset($tawar->Gambar) }}" class="w-100 h-100 object-fit-cover" alt="{{ $tawar->NamaTanaman }}">
                                </div>
                            @endif

                            <hr class="text-muted opacity-25 my-3">

                            <div class="mb-4">
                                <h4 class="fw-bold text-success mb-2" style="font-size: 19px;">{{ $tawar->NamaTanaman }}</h4>
                                <h4 class="text-muted d-block small mb-3" style="font-size: 12px;">{{ $tawar->Komoditas }}</h4>

                                <div class="row text-center bg-light rounded-3 p-2 g-0">
                                    <div class="col-6 border-end">
                                        <span class="text-muted d-block small" style="font-size: 11px;">Jumlah Tawar</span>
                                        <strong class="text-dark d-block mt-1" style="font-size: 14px;">{{ $tawar->JumlahTawar }} Kg</strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted d-block small" style="font-size: 11px;">Harga Tawar</span>
                                        <strong class="text-dark d-block mt-1" style="font-size: 14px;">Rp{{ number_format($tawar->HargaTawar, 0, ',', '.') }}/kg</strong>
                                    </div>
                                </div>
                            </div>

                            {{-- Tenggat Waktu --}}
                            @if($tawar->permintaan && $tawar->permintaan->BatasTanggal)
                                <div class="d-flex justify-content-between align-items-center small text-muted mb-3" style="font-size: 12px;">
                                    <span><i class="bi bi-calendar-event me-2"></i>Batas Akhir :</span>
                                    <span class="fw-semibold text-danger">
                                        {{ \Carbon\Carbon::parse($tawar->permintaan->BatasTanggal)->format('d M Y') }}
                                    </span>
                                </div>
                            @endif

                            {{-- Catatan --}}
                            <div class="pt-2 border-top mb-3">
                                <span class="text-muted d-block mb-1" style="font-size: 11px; font-weight: 600;">Catatan Anda:</span>
                                <p class="text-secondary small m-0 text-truncate" title="{{ $tawar->Catatan }}">"{{ $tawar->Catatan }}"</p>
                            </div>

                            {{-- Tombol Aksi --}}
                            @if($tawar->Status == 'Pending')
                                <form action="{{ route('tawar.destroy', $tawar->idTawar) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin membatalkan dan menghapus penawaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100 btn-sm rounded-3">
                                        <i class="bi bi-trash me-1"></i> Batalkan Penawaran
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted display-5 mb-3"><i class="bi bi-inbox text-success opacity-40"></i></div>
                    <h5 class="fw-bold text-dark">Belum Ada Riwayat Penawaran</h5>
                    <p class="text-muted small">Silakan pilih permintaan pasar pembeli untuk mengirimkan penawaran panen Anda.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection