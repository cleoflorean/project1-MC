@extends('layouts.app')

@section('title', 'Tawarkan Hasil Panen')
@section('page-title', 'Tawarkan Hasil Panen')

@section('content')
<div class="container-fluid">
    <div class="container py-3">

        {{-- ================= HEADER & FILTER ================= --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-2 mb-4 gap-3">
            <h5 class="fw-bold text-success mb-0">
                <i class="bi bi-clock-history me-2"></i>Riwayat Penawaran Panen
            </h5>
            
            {{-- Tombol Filter --}}
            <div class="nav-filter-custom d-flex gap-2 p-1 rounded-pill" style="background-color: #f1f5f9; border: 1px solid #e2e8f0; width: fit-content;">
                <button class="btn filter-btn active rounded-pill px-4 py-2" data-filter="pending" style="font-size: 13px; font-weight: 600; border: none;">
                    Pending
                </button>
                <button class="btn filter-btn rounded-pill px-4 py-2 text-secondary" data-filter="setuju" style="font-size: 13px; font-weight: 500; border: none; background: transparent;">
                    Disetujui
                </button>
                <button class="btn filter-btn rounded-pill px-4 py-2 text-secondary" data-filter="tidak setuju" style="font-size: 13px; font-weight: 500; border: none; background: transparent;">
                    Ditolak
                </button>
            </div>
        </div>

        {{-- ================= DAFTAR PENAWARAN ================= --}}
        <div class="row g-4" id="data-container">
            @forelse($pengajuanTawar as $tawar)
                @php
                    // Normalisasi teks status menjadi huruf kecil untuk memudahkan filter JS
                    $statusItem = strtolower($tawar->Status ?? 'pending');
                @endphp

                {{-- Tambahkan class filter-item dan data-status --}}
                <div class="col-12 col-md-6 col-lg-4 filter-item d-none" data-status="{{ $statusItem }}">
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
                {{-- State kosong original jika database memang tidak punya data sama sekali --}}
                <div class="col-12 text-center py-5 filter-item d-none" data-status="empty-db">
                    <div class="text-muted display-5 mb-3"><i class="bi bi-inbox text-success opacity-40"></i></div>
                    <h5 class="fw-bold text-dark">Belum Ada Riwayat Penawaran</h5>
                    <p class="text-muted small">Silakan pilih permintaan pasar pembeli untuk mengirimkan penawaran panen Anda.</p>
                </div>
            @endforelse

            {{-- State Kosong untuk JS (Jika tab di-klik tapi tidak ada datanya) --}}
            <div id="empty-state-filter" class="col-12 text-center py-5 d-none bg-white rounded-4 shadow-sm">
                <div class="text-muted display-5 mb-3"><i class="bi bi-inbox opacity-40"></i></div>
                <h5 class="fw-bold text-dark">Data Penawaran Kosong</h5>
                <p class="text-muted small mb-0" id="empty-state-text">Belum ada penawaran panen dengan status ini.</p>
            </div>

        </div>
    </div>
</div>

{{-- CSS Tambahan --}}
<style>
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .5rem 1.5rem rgba(40, 167, 69, 0.15) !important;
    }
    
    /* Styling khusus saat tombol filter aktif */
    .filter-btn.active {
        background-color: #198754 !important; /* Warna success Bootstrap */
        color: white !important;
        box-shadow: 0 4px 6px -1px rgba(25, 135, 84, 0.2);
    }
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const filterItems = document.querySelectorAll('.filter-item');
    const emptyState = document.getElementById('empty-state-filter');
    const emptyStateText = document.getElementById('empty-state-text');

    function filterCards(statusTarget) {
        let visibleCount = 0;

        filterItems.forEach(item => {
            // Kita skip d-none untuk yg empty dari forelse
            if(item.getAttribute('data-status') === 'empty-db') {
                return;
            }

            const itemStatus = item.getAttribute('data-status');
            
            if (itemStatus === statusTarget) {
                item.classList.remove('d-none');
                visibleCount++;
            } else {
                item.classList.add('d-none');
            }
        });

        // Menampilkan pesan kosong jika tidak ada card yang muncul
        if (visibleCount === 0 && filterItems.length > 0) {
            emptyState.classList.remove('d-none');
            // Ganti nama label agar lebih enak dibaca (Setuju jadi Disetujui, Tidak Setuju jadi Ditolak)
            let statusLabel = statusTarget;
            if(statusTarget === 'setuju') statusLabel = 'disetujui';
            if(statusTarget === 'tidak setuju') statusLabel = 'ditolak';
            
            emptyStateText.textContent = `Belum ada riwayat penawaran yang ${statusLabel}.`;
        } else {
            emptyState.classList.add('d-none');
        }
    }

    // 1. Tampilkan status Pending secara otomatis saat pertama buka web
    filterCards('pending');

    // 2. Klik pada tombol filter
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Reset style semua tombol
            filterBtns.forEach(b => {
                b.classList.remove('active');
                b.classList.add('text-secondary');
                b.style.background = 'transparent';
            });

            // Set style untuk tombol yang sedang diklik
            this.classList.add('active');
            this.classList.remove('text-secondary');

            // Ambil data-filter ('pending', 'setuju', atau 'tidak setuju') dan eksekusi
            const target = this.getAttribute('data-filter');
            filterCards(target);
        });
    });
});
</script>
@endpush