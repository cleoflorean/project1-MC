@extends('layouts.app22')

@section('title', 'Permintaan Saya - Platform Komoditas')

@section('content')
<main class="main-container" style="max-width: 1000px; margin: 0 auto; padding: 2rem 1rem;">
    
    <header class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1>Daftar Permintaan Anda</h1>
            <p style="color: #64748b;">Pantau rincian spesifikasi kebutuhan dan evaluasi penawaran.</p>
        </div>
        <button class="btn btn-primary" onclick="openModal('formModalRequest')">
            <i class="fas fa-plus"></i> Buat Baru
        </button>
    </header>

    <div class="request-list">
        @forelse($permintaans ?? [] as $item)
            <div class="card" style="margin-bottom: 1rem; padding: 1.5rem; display: flex; gap: 1.5rem; align-items: center;">
                <div style="background: #f1f5f9; padding: 1rem; border-radius: 8px; color: #2e7d32; font-size: 1.5rem;">
                    <i class="fas fa-boxes-stacked"></i>
                </div>
                <div>
                    <h4 style="margin-bottom: 0.25rem;">{{ $item->komoditas }}</h4>
                    <p style="color: #64748b; font-size: 0.9rem;">
                        Volume: {{ number_format($item->volume, 0, ',', '.') }} kg | Target Harga: Rp {{ number_format($item->batas_harga, 0, ',', '.') }}/kg
                    </p>
                </div>
            </div>
        @empty
            <div class="card" style="text-align: center; padding: 4rem 2rem;">
                <i class="fas fa-folder-open" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                <h3 style="margin-bottom: 0.5rem;">Belum Ada Permintaan</h3>
                <p style="color: #64748b; margin-bottom: 1.5rem;">Anda belum membuat permintaan komoditas apapun.</p>
                <button class="btn btn-primary" onclick="openModal('formModalRequest')">
                    Buat Sekarang
                </button>
            </div>
        @endforelse
    </div>

</main>

<div class="modal-overlay" id="formModalRequest" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div class="card" style="width: 100%; max-width: 500px; max-height: 90vh; overflow-y: auto;">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3>Buat Permintaan Pengadaan</h3>
                <p style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">Siarkan spesifikasi Anda ke ekosistem.</p>
            </div>
            <button onclick="closeModal('formModalRequest')" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: #64748b;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="card-body">
            <form action="{{ route('permintaan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Pilih Komoditas</label>
                    <select name="komoditas" class="form-control" required>
                        <option value="">-- Pilih Spesifikasi --</option>
                        <option value="Cabai Merah Keriting">Cabai Merah Keriting</option>
                        <option value="Tomat Sayur Premium">Tomat Sayur Premium</option>
                        <option value="Kentang Granola">Kentang Granola</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Volume (kg)</label>
                    <input type="number" name="volume" class="form-control" placeholder="Contoh: 2500" required>
                </div>
                <div class="form-group">
                    <label>Harga Maksimal (Rp/kg)</label>
                    <input type="number" name="batas_harga" class="form-control" placeholder="Contoh: 30000" required>
                </div>
                <div class="form-group">
                    <label>Batas Akhir Penerimaan</label>
                    <input type="date" name="batas_akhir" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-full">
                    <i class="fas fa-paper-plane"></i> Kirim Permintaan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Script sederhana untuk membuka & menutup form modal
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }
</script>
@endsection