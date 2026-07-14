@extends('layouts.app22')

@section('title', 'Permintaan Saya - Platform Komoditas')

@section('content')
<main class="main-container" style="max-width: 1000px; margin: 0 auto; padding: 2rem 1rem;">
    
    <header class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1>Daftar Permintaan Anda</h1>
            <p style="color: #64748b;">Pantau rincian spesifikasi kebutuhan dan evaluasi penawaran.</p>
        </div>
        <button class="btn btn-primary" onclick="openModal('formModalRequest')" style="padding: 0.5rem 1rem; cursor: pointer;">
            <i class="fas fa-plus"></i> Buat Baru
        </button>
    </header>

   <div class="request-list">
        @forelse($permintaans ?? [] as $item)
            @php
                // Cek apakah permintaan ini sudah memiliki penawaran yang disetujui
                $hasApprovedOffer = $item->penawarans->where('Status', 'Setuju')->count() > 0;
                $isExpired = \Carbon\Carbon::parse($item->BatasTanggal)->endOfDay()->isPast();
            @endphp
            
            <div class="card" style="margin-bottom: 1.5rem; padding: 1.5rem; display: flex; gap: 1.5rem; align-items: center; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                
                <div style="flex-grow: 1;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 0.5rem;">
                        <h4 style="margin: 0; font-size: 1.25rem; color: #1e293b;">{{ $item->NamaTanaman }}</h4>
                        <span style="font-size: 0.75rem; padding: 3px 8px; border-radius: 20px; background: {{ $isExpired ? '#fee2e2' : '#dcfce7' }}; color: {{ $isExpired ? '#991b1b' : '#166534' }};">
                            {{ $isExpired ? 'Kadaluarsa' : 'Aktif' }}
                        </span>
                    </div>

                    <p style="color: #64748b; font-size: 0.9rem; margin: 0; line-height: 1.6;">
                        <i class="fas fa-tag"></i> {{ $item->Komoditas }} <br>
                        <i class="fas fa-weight-hanging"></i> Volume: <strong>{{ number_format($item->JumlahDibutuhkan, 0, ',', '.') }} kg</strong> | 
                        <i class="fas fa-money-bill-wave"></i> Harga Maks: <strong>Rp {{ number_format($item->HargaMaksimal, 0, ',', '.') }}/kg</strong><br>
                        <i class="fas fa-calendar-alt"></i> Batas Akhir: <span style="color: {{ $isExpired ? '#dc2626' : 'inherit' }}">{{ \Carbon\Carbon::parse($item->BatasTanggal)->format('d M Y') }}</span>
                    </p>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <a href="{{ route('permintaan.penawaran', $item->idPermintaan) }}" style="background-color: #2e7d32; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-size: 0.9rem; text-align: center; white-space: nowrap;">
                        <i class="fas fa-envelope-open-text" style="margin-right: 5px;"></i> Cek Tawaran
                    </a>
                    
                    {{-- Tombol Hapus: Hanya muncul jika BELUM ADA tawaran yang disetujui[cite: 3] --}}
                    @if(!$hasApprovedOffer)
                        <form action="{{ route('permintaan.destroy', $item->idPermintaan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus permintaan ini?');" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background-color: transparent; color: #dc2626; border: 1px solid #dc2626; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 0.9rem; width: 100%; white-space: nowrap; transition: 0.2s;">
                                <i class="fas fa-trash" style="margin-right: 5px;"></i> Hapus
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        @empty
            <div class="card" style="text-align: center; padding: 4rem 2rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                <i class="fas fa-folder-open" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                <h3 style="margin-bottom: 0.5rem;">Belum Ada Permintaan</h3>
                <p style="color: #64748b; margin-bottom: 1.5rem;">Anda belum membuat permintaan komoditas apapun.</p>
                <button class="btn btn-primary" onclick="openModal('formModalRequest')" style="padding: 0.5rem 1rem; cursor: pointer; background-color: #2e7d32; color: white; border: none; border-radius: 6px;">
                    Buat Sekarang
                </button>
            </div>
        @endforelse
    </div>

</main>

<div class="modal-overlay" id="formModalRequest" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div class="card" style="width: 100%; max-width: 500px; max-height: 90vh; overflow-y: auto; background: white; padding: 20px; border-radius: 8px;">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <div>
                <h3 style="margin: 0;">Buat Permintaan Pengadaan</h3>
                <p style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">Siarkan spesifikasi Anda ke ekosistem.</p>
            </div>
            <button onclick="closeModal('formModalRequest')" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: #64748b;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="card-body">
            <form action="{{ route('permintaan.store') }}" method="POST">
                @csrf
                
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Nama Tanaman</label>
                    <input type="text" name="NamaTanaman" class="form-control" placeholder="Contoh: Cabai Rawit Dewata" required style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Pilih Komoditas</label>
                    <select name="komoditas" class="form-control" required style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
                        <option value="">-- Pilih Spesifikasi --</option>
                        <option value="Sayur">Sayur</option>
                        <option value="Kacang-Kacangan">Kacang-Kacangan</option>
                        <option value="Buah-Buahan">Buah-Buahan</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Volume (kg)</label>
                    <input type="number" name="volume" class="form-control" placeholder="Contoh: 2500" required style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Harga Maksimal (Rp/kg)</label>
                    <input type="number" name="batas_harga" class="form-control" placeholder="Contoh: 30000" required style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Batas Akhir Penerimaan</label>
                    <input type="date" name="batas_akhir" class="form-control" required style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
                </div>

                <button type="submit" class="btn btn-primary btn-full" style="width: 100%; padding: 0.75rem; background: #2e7d32; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; margin-top: 10px;">
                    <i class="fas fa-paper-plane"></i> Kirim Permintaan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }
</script>
@endsection