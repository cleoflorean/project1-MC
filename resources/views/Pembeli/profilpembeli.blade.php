@extends('layouts.app22')

@section('title', 'Profil Saya - B2B Supply')

@section('content')
<link rel="stylesheet" href="{{ asset('profil.css') }}">

<main class="profil-wrapper">
    <header class="profil-header">
        <div>
            <h1>Profil Pembeli B2B - {{ $profil->nama_perusahaan ?? $user->name }}</h1>
            <p class="profil-desc">Kelola informasi identitas dan preferensi pengadaan Anda.</p>
        </div>
        <button class="btn btn-secondary" id="btn-edit-profile">
            <i class="fas fa-pen btn-icon"></i> Edit Profil
        </button>
    </header>

    <div class="dashboard-layout">
        
        <div class="primary-column">
            <div class="card card-spacing">
                <div class="card-header">
                    <h3>Identitas & Status</h3>
                </div>
                <div class="card-body">
                    <div class="identity-box">
                        <div class="profile-avatar avatar-large">
                            {{ substr($user->name, 0, 2) }}
                        </div>
                        <div class="identity-info">
                            <div class="info-group">
                                <span class="info-label">Nama Perusahaan</span>
                                <div class="info-value">{{ $profil->nama_perusahaan ?? 'Belum diatur' }}</div>
                            </div>
                            <div class="info-group">
                                <span class="info-label">Tipe Profil</span>
                                <div class="info-value">{{ $profil->tipe_profil }}</div>
                            </div>
                            <div class="info-group">
                                <span class="info-label">Status Verifikasi</span>
                                <div class="status-verified"><i class="fas fa-circle-check"></i> Terverifikasi</div>
                            </div>
                            <div class="info-group-last">
                                <span class="info-label">Lokasi Domisili</span>
                                <div class="info-value">{{ $profil->lokasi_domisili ?? 'Belum diatur' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Kontak & Logistik</h3>
                </div>
                <div class="card-body">
                    <ul class="contact-list">
                        <li class="contact-item">
                            <i class="fas fa-phone contact-icon"></i>
                            <div>
                                <div class="info-label">Telepon Operasional</div>
                                <div class="contact-text">{{ $profil->telepon ?? 'Belum diatur' }}</div>
                            </div>
                        </li>
                        <li class="contact-item">
                            <i class="fas fa-envelope contact-icon"></i>
                            <div>
                                <div class="info-label">Email Login / Pengadaan</div>
                                <div class="contact-text">{{ $user->email }}</div>
                            </div>
                        </li>
                        <li class="contact-item-last">
                            <i class="fas fa-warehouse contact-icon"></i>
                            <div>
                                <div class="info-label">Alamat Gudang Penerimaan (Titik Bongkar)</div>
                                <div class="contact-text-multi">
                                    {!! nl2br(e($profil->alamat_gudang ?? 'Belum diatur')) !!}
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="sidebar-column">
            <div class="card card-spacing">
                <div class="card-header">
                    <h3>Rekam Jejak Transaksi</h3>
                </div>
                <div class="card-body">
                    <div class="stat-row">
                        <span class="stat-label">Total Kontrak Berhasil</span>
                        <span class="stat-value">{{ $profil->total_kontrak }}</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Estimasi Volume Diserap</span>
                        <span class="stat-value">{{ $profil->estimasi_volume }}</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Supplier Terverifikasi</span>
                        <span class="stat-value">{{ $profil->mitra_terverifikasi }} Mitra</span>
                    </div>
                    <div class="stat-row-last">
                        <span class="stat-label">Rating Kepuasan</span>
                        <span class="stat-rating"><i class="fas fa-star"></i> {{ $profil->rating }}/5</span>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3>Keamanan Akun</h3>
                </div>
                <div class="card-body">
                    <div class="security-row">
                        <span class="stat-label">Kata Sandi</span>
                        <span class="security-password">••••••••</span>
                    </div>
                    
                    <div class="security-row-last">
                        <span class="stat-label">Autentikasi Dua Langkah</span>
                        <div class="toggle-switch" id="toggle-2fa">
                            <div class="toggle-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<script src="{{ asset('profil.js') }}"></script>
@endsection