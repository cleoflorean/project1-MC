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

<!-- MODAL FORM BUAT PERMINTAAN -->
    <div class="modal-overlay" id="formModalRequest" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1050; justify-content: center; align-items: center; padding: 1rem;">
        <div class="card border-0 shadow-lg p-4 text-start" style="width: 100%; max-width: 500px; max-height: 90vh; overflow-y: auto; background: white; border-radius: 16px;">
            
            <!-- Header Modal -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="text-start">
                    <h4 class="fw-bold text-dark m-0" style="font-size: 1.25rem;">Buat Permintaan Pengadaan</h4>
                    <p class="text-secondary m-0" style="font-size: 0.8rem; margin-top: 3px;">Siarkan spesifikasi Anda ke ekosistem petani.</p>
                </div>
                <button type="button" onclick="closeModal('formModalRequest')" style="background: #f1f5f9; border: none; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50%; cursor: pointer; color: #64748b;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Body Form Modal -->
            <form action="{{ route('permintaan.store') }}" method="POST">
                @csrf
                <div class="mb-3 text-start">
                    <label class="form-label fw-semibold text-dark small mb-1">Nama Tanaman</label>
                    <input type="text" name="NamaTanaman" class="form-control py-2" style="border-radius: 8px;" placeholder="Contoh: Cabai Rawit Dewata" required>
                </div>
                <div class="mb-3 text-start">
                    <label class="form-label fw-semibold text-dark small mb-1">Pilih Komoditas</label>
                    <select name="komoditas" class="form-select py-2" style="border-radius: 8px;" required>
                        <option value="">-- Pilih Komoditas --</option>
                        <option value="Tanaman Pangan">Tanaman Pangan (Biji-bijian, Umbi-umbian, Kacang-kacangan)</option>
                        <option value="Hortikultura">Hortikultura (Sayuran, Buah-buahan, Tanaman Obat)</option>
                        <option value="Perkebunan">Perkebunan (Tanaman Industri, Rempah-rempah)</option>
                    </select>
                </div>
                <div class="row g-3 mb-3 text-start">
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark small mb-1">Volume (kg)</label>
                        <input type="number" name="volume" class="form-control py-2" style="border-radius: 8px;" placeholder="Contoh: 2500" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold text-dark small mb-1">Harga Maks (Rp/kg)</label>
                        <input type="number" name="batas_harga" class="form-control py-2" style="border-radius: 8px;" placeholder="Contoh: 30000" required>
                    </div>
                </div>
                <div class="mb-4 text-start">
                    <label class="form-label fw-semibold text-dark small mb-1">Batas Akhir Penerimaan</label>
                    <input type="date" name="batas_akhir" class="form-control py-2" style="border-radius: 8px;" required>
                </div>
                <button type="submit" class="btn btn-success w-100 py-2.5 fw-bold d-flex align-items-center justify-content-center gap-2" style="border-radius: 8px; background-color: #2e7d32; border: none;">
                    <i class="fas fa-paper-plane"></i> Kirim Permintaan
                </button>
            </form>
        </div>
    </div> <!-- END OF MODAL -->

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