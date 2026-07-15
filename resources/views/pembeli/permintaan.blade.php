@extends('layouts.app22')

@section('title', 'Permintaan Saya - Platform Komoditas')

@section('content')
<main class="container py-4" style="max-width: 1000px;">
    
    <!-- HEADER -->
    <header class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div class="text-start">
            <h1 class="h3 fw-bold text-dark mb-1">Daftar Permintaan Anda</h1>
            <p class="text-secondary mb-0" style="font-size: 0.95rem;">Pantau rincian spesifikasi kebutuhan dan evaluasi penawaran.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <!-- DROPDOWN FILTER -->
            <select id="filterStatus" class="form-select fw-semibold" style="border-radius: 8px; width: auto;" onchange="filterRequests(this.value)">
                <option value="all">Semua Status</option>
                <option value="active">Aktif</option>
                <option value="expired">Kadaluarsa</option>
            </select>

            <button class="btn btn-success d-flex align-items-center gap-2 px-4 py-2 fw-semibold" onclick="openModal('formModalRequest')" style="border-radius: 8px; background-color: #2e7d32; white-space: nowrap;">
                <i class="fas fa-plus"></i> Buat Baru
            </button>
        </div>
    </header>

    <!-- DAFTAR KARTU PERMINTAAN -->
    <div class="request-list">
        @forelse($permintaans ?? [] as $item)
            @php
                $hasApprovedOffer = $item->penawarans->where('Status', 'Setuju')->count() > 0;
                $isExpired = \Carbon\Carbon::parse($item->BatasTanggal)->endOfDay()->isPast();
            @endphp
            
            <!-- KARTU UTAMA: Tambahkan class 'request-card' dan data-status -->
            <div class="card request-card border-0 shadow-sm rounded-3 p-4 mb-3 text-start" data-status="{{ $isExpired ? 'expired' : 'active' }}">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
                    
                    <!-- SISI KIRI (INFORMASI SPESIFIKASI) -->
                    <div class="flex-grow-1 text-start">
                        <!-- Judul dan Badge Status -->
                        <div class="d-flex align-items-center gap-2 mb-3 text-start">
                            <h4 class="m-0 fw-bold text-dark" style="font-size: 1.25rem;">{{ $item->NamaTanaman }}</h4>
                            <span class="badge {{ $isExpired ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} px-2.5 py-1" style="font-size: 0.75rem; font-weight: 600; border-radius: 6px;">
                                {{ $isExpired ? 'Kadaluarsa' : 'Aktif' }}
                            </span>
                        </div>

                        <!-- Grid Spesifikasi -->
                        <div class="row g-2 text-secondary text-start" style="font-size: 0.9rem;">
                            <div class="col-12 col-md-6">
                                <i class="fas fa-tag text-success me-2" style="width: 18px;"></i>
                                Komoditas: <strong class="text-dark">{{ $item->Komoditas }}</strong>
                            </div>
                            <div class="col-12 col-md-6">
                                <i class="fas fa-money-bill-wave text-success me-2" style="width: 18px;"></i>
                                Harga Maks: <strong class="text-success">Rp {{ number_format($item->HargaMaksimal, 0, ',', '.') }}/kg</strong>
                            </div>
                            <div class="col-12 col-md-6">
                                <i class="fas fa-weight-hanging text-success me-2" style="width: 18px;"></i>
                                Volume: <strong class="text-dark">{{ number_format($item->JumlahDibutuhkan, 0, ',', '.') }} kg</strong>
                            </div>
                            <div class="col-12 col-md-6">
                                <i class="fas fa-calendar-alt text-success me-2" style="width: 18px;"></i>
                                Batas Akhir: <strong class="{{ $isExpired ? 'text-danger' : 'text-dark' }}">{{ \Carbon\Carbon::parse($item->BatasTanggal)->format('d M Y') }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- SISI KANAN (TOMBOL AKSI) -->
                    <div class="d-flex flex-column gap-2 text-center" style="min-width: 180px;">
                        <a href="{{ route('permintaan.penawaran', $item->idPermintaan) }}" class="btn btn-success fw-bold py-2 d-flex align-items-center justify-content-center gap-2" style="background-color: #2e7d32; border-radius: 8px; font-size: 0.9rem;">
                            <i class="fas fa-envelope-open-text"></i> Cek Tawaran
                        </a>
                        
                        @if(!$hasApprovedOffer)
                            <form action="{{ route('permintaan.destroy', $item->idPermintaan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus permintaan ini?');" class="m-0 w-100">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger fw-bold py-2 w-100 d-flex align-items-center justify-content-center gap-2" style="border-radius: 8px; font-size: 0.9rem;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            </div>
        @empty
            <!-- JIKA DATA KOSONG -->
            <div class="text-center py-5 px-3 bg-white border rounded-3 shadow-sm">
                <i class="fas fa-folder-open text-muted mb-3" style="font-size: 3.5rem;"></i>
                <h4 class="fw-bold text-dark">Belum Ada Permintaan</h4>
                <p class="text-secondary mb-4">Anda belum membuat permintaan komoditas apapun saat ini.</p>
                <button class="btn btn-success px-4 py-2 fw-semibold" onclick="openModal('formModalRequest')" style="border-radius: 8px; background-color: #2e7d32;">
                    Buat Sekarang
                </button>
            </div>
        @endforelse
    </div>

</main>

<!-- MODAL TETAP SAMA SEPERTI SEBELUMNYA ... -->
<!-- (Kode Modal disembunyikan agar tidak kepanjangan, tidak ada yang diubah) -->

<script>
    // Script Modal
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    // Script Filter
    function filterRequests(status) {
        const cards = document.querySelectorAll('.request-card');
        
        cards.forEach(card => {
            if (status === 'all') {
                // Tampilkan semua
                card.style.display = 'block';
            } else {
                // Cocokkan data-status dengan dropdown value
                if (card.getAttribute('data-status') === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            }
        });
    }
</script>
@endsection