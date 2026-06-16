@extends('layouts.app')

@section('title', 'Dashboard Petani')
@section('page-title', 'Dashboard Petani')

@section('content')

{{-- BARIS 1: KARTU STATISTIK RINGKASAN 3 kartu: Jenis Panen | Permintaan Baru | Dalam Pengiriman --}}
<div class="row g-4 mb-4">

    {{-- Kartu: Jumlah Jenis Panen Aktif --}}
    <div class="col-12 col-md-6 col-xl-4">
        <div class="tc-card tc-stat-card">
            <div class="tc-stat-icon tc-stat-icon--hijau">
                <i class="bi bi-basket3-fill"></i>
            </div>
            <div class="tc-stat-body">
                <div class="tc-stat-number">{{ $jumlahJenisPanen }}</div>
                <div class="tc-stat-label">Jenis Panen</div>
            </div>
        </div>
    </div>

    {{-- Kartu: Permintaan Baru (7 hari terakhir) --}}
    <div class="col-12 col-md-6 col-xl-4">
        <div class="tc-card tc-stat-card">
            <div class="tc-stat-icon tc-stat-icon--biru">
                <i class="bi bi-shop"></i>
            </div>
            <div class="tc-stat-body">
                <div class="tc-stat-number">{{ $permintaanBaru }}</div>
                <div class="tc-stat-label">Permintaan Baru</div>
            </div>
        </div>
    </div>

    {{-- Kartu: Panen Dalam Pengiriman --}}
    <div class="col-12 col-md-6 col-xl-4">
        <div class="tc-card tc-stat-card">
            <div class="tc-stat-icon tc-stat-icon--oranye">
                <i class="bi bi-truck"></i>
            </div>
            <div class="tc-stat-body">
                <div class="tc-stat-number">{{ $dalamPengiriman }}</div>
                <div class="tc-stat-label">Dalam Pengiriman</div>
            </div>
        </div>
    </div>
</div>

{{-- BARIS 2: PERMINTAAN & PENGAJUAN TAWAR --}}
<div class="row g-4 align-items-stretch">

    {{-- Permintaan Terdekat --}}
    <div class="col-12 col-lg-7">
        <div class="tc-card h-100">
            <div class="tc-card-header">
                <h6 class="tc-card-title">
                    <i class="bi bi-geo-alt-fill me-2 text-danger"></i> Permintaan Terdekat
                </h6>
                <a href="#" class="tc-link-kecil">Lihat Semua</a>
            </div>
            <div class="tc-card-body p-0">
                @forelse($permintaanTerdekat as $req)
                    <div class="tc-req-item">
                        <div class="tc-req-info">

                            <div class="tc-req-image">
                                <img src="{{ asset($req->Gambar) }}" alt="{{  $req->komoditas }}">
                            </div>

                            <div class="tc-req-komoditas">
                                {{ $req->komoditas }}
                            </div>
                            <div class="tc-req-detail">
                                <span>
                                    <i class="bi bi-box"></i>
                                    {{ number_format($req->jumlah_butuh) }} Kg
                                </span>
                                <span>
                                    <i class="bi bi-geo"></i>
                                    {{ $req->jarak_km ?? '-' }} km
                                </span>
                                <span class="tc-req-deadline">
                                    <i class="bi bi-clock"></i>
                                    Deadline:
                                    {{ \Carbon\Carbon::parse($req->deadline)->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="tc-req-harga">
                            <div>Rp{{ number_format($req->harga_per_kg, 0, ',', '.') }}/kg</div>
                            <a href="{{ route('tawar.create', $req->id) }}" class="tc-btn-primary-sm">Tawar</a>
                        </div>
                    </div>
                @empty
                    <div class="tc-empty-state py-4">
                        <i class="bi bi-shop"></i>
                        <p>Belum ada permintaan yang sesuai komoditas Anda</p>
                        <a href="{{ route('panen.create') }}" class="tc-btn-sm">Tambah Data Panen</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Pengajuan Tawar di Pasar --}}
    <div class="col-12 col-lg-5">
        <div class="tc-card h-100">
            <div class="tc-card-header">
                <h6 class="tc-card-title">
                    <i class="bi bi-tags-fill me-2 text-warning"></i>
                    Pengajuan Tawar di Pasar
                </h6>
                <a href="{{ route('tawar.index') }}"class="tc-link-kecil">
                    Lihat Semua
                </a>
            </div>
            <div class="tc-card-body">
                @forelse($pengajuanTawar as $tawar)
                    <div class="tc-tawar-item">
                        <div class="tc-tawar-info">
                            <div class="tc-req-image">
                                <img src="{{ asset($tawar->Gambar ?? 'upload/penawaran/default.png') }}" alt="{{  $tawar->NamaTanaman ?? 'Tanaman'}}">
                            </div>

                            <div class="tc-tawar-text">
                                <div class="tc-tawar-komoditas"> 
                                    {{ $tawar->nama_tanaman ?? 'Komoditas' }}</div>
                                <div class="tc-tawar-pasar">
                                    <i class="bi bi-shop"></i> 
                                    {{ optional($tawar->pasar)->nama ?? '-' }}
                                </div>
                            </div>
                            
                        </div>
                            <div class="tc-tawar-harga"> Rp{{ number_format($tawar->harga_per_kg, 0, ',', '.') }}/kg
                            </div>
                            <span class="tc-badge-status tc-badge-status--{{ $tawar->status ?? 'aktif' }}">
                                {{ ucfirst($tawar->status ?? 'aktif') }}
                            </span>
                    </div>
                @empty
                    <div class="tc-empty-state">
                        <i class="bi bi-tags"></i>
                        <p>Belum ada penawaran aktif</p>
                        <a href="{{ route('pasar.index') }}" class="tc-btn-sm">
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
/**
 * Render grafik sparkline pendapatan 7 hari terakhir
 * menggunakan SVG murni tanpa library eksternal.
 */
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('chartPendapatan');
    if (!container) return;

    // Ambil data dari atribut data-
    const values = JSON.parse(container.dataset.values || '[]');
    const labels = JSON.parse(container.dataset.labels || '[]');

    if (values.length === 0) {
        container.innerHTML = '<p class="text-muted text-center small">Belum ada data</p>';
        return;
    }

    // Hitung dimensi dan skala
    const w = 280, h = 80, pad = 10;
    const maxVal = Math.max(...values, 1);
    const minVal = Math.min(...values, 0);
    const range  = maxVal - minVal || 1;

    // Hitung koordinat titik-titik grafik
    const points = values.map((v, i) => {
        const x = pad + (i / (values.length - 1)) * (w - pad * 2);
        const y = h - pad - ((v - minVal) / range) * (h - pad * 2);
        return [x, y];
    });

    // Buat path SVG dari titik-titik
    const pathD = points.map((p, i) => (i === 0 ? 'M' : 'L') + p[0] + ',' + p[1]).join(' ');

    // Buat area di bawah grafik (fill)
    const areaD = pathD
        + ` L${points[points.length-1][0]},${h-pad} L${points[0][0]},${h-pad} Z`;

    // Render SVG ke dalam container
    container.innerHTML = `
        <svg viewBox="0 0 ${w} ${h}" class="tc-sparkline">
            <path class="tc-sparkline-area" d="${areaD}"/>
            <path d="${pathD}"/>
            ${points.map((p, i) => `
                <circle cx="${p[0]}" cy="${p[1]}" r="3"
                    fill="var(--tc-primary)" stroke="#fff" stroke-width="1.5">
                    <title>${labels[i]}: Rp${Number(values[i]).toLocaleString('id-ID')}</title>
                </circle>
            `).join('')}
        </svg>
    `;
});
</script>
@endpush
