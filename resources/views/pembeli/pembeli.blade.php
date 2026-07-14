@extends('layouts.app22')

@section('title', 'Dashboard Pembeli')

@section('content')
<div class="dashboard-container" style="padding: 20px;">
    
    <header class="content-header" style="margin-bottom: 2rem;">
        <h1>Selamat Datang Kembali</h1>
        <p>Kelola permintaan pengadaan dan pantau penawaran secara real-time.</p>
    </header>

    <div class="dashboard-layout" style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        
        <div class="primary-column">
            <div class="card">
                <div class="card-header-flex" style="padding: 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between;">
                    <h3>Penawaran Terbaru Masuk</h3>
                </div>
                <div class="table-container" style="padding: 15px;">
                    <table class="data-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #ddd;">
                                <th style="padding: 10px; text-align: left;">Nama</th>
                                <th style="padding: 10px; text-align: left;">Komoditas</th>
                                <th style="padding: 10px; text-align: left;">Kapasitas</th>
                                <th style="padding: 10px; text-align: left;">Harga</th>
                                <th style="padding: 10px; text-align: left;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penawarans ?? [] as $tawar)
                                <tr style="border-bottom: 1px solid #eee;">
                                    <td style="padding: 10px;">
                                        <strong>{{ $tawar->petani?->petaniProfile?->NamaLengkap ?? $tawar->petani?->username ?? 'Petani Tidak Diketahui' }}</strong><br>
                                        <small style="color: #666;">📝 {{ $tawar->permintaan->NamaTanaman ?? 'Permintaan #'.$tawar->idMinta }}</small>
                                    </td>
                                    <td style="padding: 10px;">{{ $tawar->permintaan->Komoditas ?? '-' }}</td>
                                    <td style="padding: 10px;">{{ number_format($tawar->JumlahTawar, 0, ',', '.') }} kg</td>
                                    <td style="padding: 10px; font-weight: 600; color: #2e7d32;">Rp {{ number_format($tawar->HargaTawar, 0, ',', '.') }}</td>
                                    <td style="padding: 10px;">
                                        @php
                                            $bg = $tawar->Status === 'Pending' ? '#fff3cd' : ($tawar->Status === 'Setuju' ? '#d4edda' : '#f8d7da');
                                            $color = $tawar->Status === 'Pending' ? '#856404' : ($tawar->Status === 'Setuju' ? '#155724' : '#721c24');
                                        @endphp
                                        <span style="background-color: {{ $bg }}; color: {{ $color }}; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 500;">
                                            {{ $tawar->Status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="padding: 30px; text-align: center; color: #888;">
                                        <i class="fas fa-inbox" style="font-size: 2rem; color: #ddd; margin-bottom: 10px;"></i><br>
                                        Belum ada penawaran masuk untuk permintaan Anda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="sidebar-column">
            <div class="card" style="padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
                <h3 style="margin-bottom: 15px;">Buat Permintaan Pengadaan</h3>
                
                @if(session('success'))
                    <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('permintaan.store') }}" method="POST">
                    @csrf
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px;">Nama Tanaman</label>
                        <input type="text" name="NamaTanaman" class="form-control" style="width: 100%; padding: 8px;" placeholder="Contoh: Cabai Rawit" required>
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px;">Komoditas</label>
                        <select name="komoditas" class="form-control" style="width: 100%; padding: 8px;" required>
                            <option value="">-- Pilih --</option>
                            <option value="Sayur">Sayur</option>
                            <option value="Kacang-Kacangan">Kacang-Kacangan</option>
                            <option value="Buah-Buahan">Buah-Buahan</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px;">Volume (kg)</label>
                        <input type="number" name="volume" class="form-control" style="width: 100%; padding: 8px;" placeholder="2500" required>
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px;">Harga Maksimal (Rp)</label>
                        <input type="number" name="batas_harga" class="form-control" style="width: 100%; padding: 8px;" placeholder="30000" required>
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px;">Batas Tanggal</label>
                        <input type="date" name="batas_akhir" class="form-control" style="width: 100%; padding: 8px;" required>
                    </div>

                    <button type="submit" style="width: 100%; padding: 10px; background: #2e7d32; color: white; border: none; border-radius: 5px; cursor: pointer;">
                        Kirim Permintaan
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection