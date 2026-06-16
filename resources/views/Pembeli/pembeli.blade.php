@extends('layouts.app22')

@section('title', 'Dashboard Pembeli - Platform Komoditas')

@section('content')
<div class="dashboard-container">
    
    <header class="content-header">
        <h1>Selamat Datang Kembali</h1>
        <p>Kelola permintaan pengadaan komoditas dan pantau penawaran dari mitra penyedia secara real-time.</p>
    </header>

    <div class="dashboard-layout">
        
        <div class="primary-column">
            <div class="card">
                <div class="card-header-flex">
                    <h3>Penawaran Terbaru Masuk</h3>
                    <a href="#" class="text-link">Semua Penawaran</a>
                </div>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Penyedia / Vendor</th>
                                <th>Komoditas</th>
                                <th>Kapasitas Sedia</th>
                                <th>Harga Diajukan</th>
                                <th style="text-align: center;">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span class="vendor-name">Gabungan Tani Makmur</span>
                                    <div class="text-muted">Wilayah I (12 km)</div>
                                </td>
                                <td>Cabai Merah Keriting</td>
                                <td>500 kg</td>
                                <td class="vendor-price">Rp 31.500 <span class="text-muted">/kg</span></td>
                                <td style="text-align: center;">
                                    <button class="btn btn-secondary" onclick="terimaPenawaran('Gabungan Tani Makmur')">Terima</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="sidebar-column">
            <div class="card">
                <div class="card-header">
                    <h3>Buat Permintaan Pengadaan</h3>
                    <p class="text-muted" style="font-size: 0.75rem;">Siarkan spesifikasi komoditas Anda ke ekosistem.</p>
                </div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

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

    </div>
</div>
@endsection