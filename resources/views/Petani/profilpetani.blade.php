@extends('layouts.app')

@section('title', 'Profil Saya - TaniHarvest')

@section('content')
<main class="container-fluid py-4">
    <header class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bold mb-1 text-dark">Profil Petani - {{ $profil->NamaKebun ?? $profil->NamaLengkap ?? $user->name }}</h1>
            <p class="text-muted mb-0">Kelola informasi identitas kebun dan hasil panen Anda.</p>
        </div>
        <button class="btn btn-success d-flex align-items-center" id="btn-edit-profile">
            <i class="fas fa-pen me-2"></i> Edit Profil
        </button>
    </header>

    <div class="row">
        
        <div class="col-lg-8">
            
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="mb-0 fw-bold">Identitas Kebun & Status</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column flex-sm-row align-items-start gap-4">
                        @if(!empty($profil->FotoProfile))
                            <img src="{{ asset('storage/' . $profil->FotoProfile) }}" 
                                 class="rounded-circle flex-shrink-0" 
                                 style="width: 80px; height: 80px; object-fit: cover;" 
                                 alt="Foto Profil">
                        @else
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                                 style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold;">
                                {{ strtoupper(substr($profil->NamaLengkap ?? $user->name, 0, 2)) }}
                            </div>
                        @endif
                        
                        <div class="flex-grow-1 w-100">
                            <div class="row mb-3">
                                <div class="col-sm-4 text-muted">Nama Lengkap</div>
                                <div class="col-sm-8 fw-semibold">{{ $profil->NamaLengkap ?? 'Belum diatur' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 text-muted">Nama Kebun</div>
                                <div class="col-sm-8 fw-semibold">{{ $profil->NamaKebun ?? 'Belum diatur' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 text-muted">Bio / Deskripsi</div>
                                <div class="col-sm-8 fw-semibold">{{ $profil->Bio ?? 'Belum ada deskripsi' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 text-muted">Status Verifikasi</div>
                                <div class="col-sm-8 text-success fw-bold">
                                    <i class="fas fa-circle-check me-1"></i> Terverifikasi
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="mb-0 fw-bold">Kontak & Lokasi</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-start px-4 py-3 border-0">
                            <i class="fas fa-phone text-success mt-1 me-3 fs-5"></i>
                            <div>
                                <div class="text-muted small mb-1">No. Telepon (NoTlp)</div>
                                <div class="fw-semibold">{{ $profil->NoTlp ?? 'Belum diatur' }}</div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-start px-4 py-3 border-0">
                            <i class="fas fa-envelope text-success mt-1 me-3 fs-5"></i>
                            <div>
                                <div class="text-muted small mb-1">Email Akun</div>
                                <div class="fw-semibold">{{ $user->email ?? 'Email tidak ditemukan' }}</div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-start px-4 py-3 border-0">
                            <i class="fas fa-map-marker-alt text-success mt-1 me-3 fs-5"></i>
                            <div>
                                <div class="text-muted small mb-1">Alamat Lengkap</div>
                                <div class="fw-semibold">
                                    {!! nl2br(e($profil->Alamat ?? 'Belum diatur')) !!}
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="mb-0 fw-bold">Rekam Jejak Transaksi</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <span class="text-muted">Total Kontrak Berhasil</span>
                        <span class="fw-bold">0</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <span class="text-muted">Estimasi Panen</span>
                        <span class="fw-bold">0 Kg</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <span class="text-muted">Pembeli Terhubung</span>
                        <span class="fw-bold">0 Mitra</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Rating Kualitas</span>
                        <span class="fw-bold text-warning">
                            <i class="fas fa-star"></i> 0.0/5
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="mb-0 fw-bold">Keamanan Akun</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="text-muted">Kata Sandi</span>
                        <span class="fs-4 lh-1 text-secondary">&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Autentikasi Dua Langkah</span>
                        <div class="form-check form-switch fs-4 mb-0">
                            <input class="form-check-input" type="checkbox" role="switch" id="toggle-2fa">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection