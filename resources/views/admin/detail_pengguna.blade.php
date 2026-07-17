@extends('layouts.admin')

@section('title', 'Detail Akun Pengguna')
@section('header_title', 'Informasi Detail Pengguna')

@section('content')
<div class="container-fluid p-0">
    
    {{-- Tombol Kembali --}}
    <div class="mb-4">
        <a href="{{ route('admin.pengguna') }}" class="btn btn-light border shadow-sm text-secondary fw-semibold">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Pengguna
        </a>
    </div>

    <div class="row">
        {{-- KARTU PROFIL UTAMA --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body text-center p-5">
                    {{-- TAMPILAN FOTO PROFIL (Menggunakan Foto Asli Jika Ada) --}}
                    @if($user->role === 'petani' && $user->petaniProfile && $user->petaniProfile->FotoProfile)
                        <img src="{{ asset($user->petaniProfile->FotoProfile) }}" class="rounded-circle mb-3 shadow-sm border" style="width: 120px; height: 120px; object-fit: cover;">
                    @elseif($user->role === 'pembeli' && $user->pembeliProfile && $user->pembeliProfile->FotoProfile)
                        <img src="{{ asset($user->pembeliProfile->FotoProfile) }}" class="rounded-circle mb-3 shadow-sm border" style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        {{-- Default Inisial Nama jika belum upload foto --}}
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 120px; height: 120px; font-size: 3rem; text-transform: uppercase;">
                            {{ substr($user->username, 0, 2) }}
                        </div>
                    @endif

                    <h4 class="fw-bold text-dark mb-1">
                        @if($user->role === 'petani')
                            {{ $user->petaniProfile->NamaLengkap ?? $user->username }}
                        @elseif($user->role === 'pembeli')
                            {{ $user->pembeliProfile->NamaLengkap ?? $user->username }}
                        @else
                            {{ $user->username }}
                        @endif
                    </h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    @if($user->role === 'admin')
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fs-6">Administrator</span>
                    @elseif($user->role === 'petani')
                        <span class="badge bg-success px-3 py-2 rounded-pill fs-6"><i class="fas fa-tractor me-1"></i> Mitra Petani</span>
                    @else
                        <span class="badge bg-primary px-3 py-2 rounded-pill fs-6"><i class="fas fa-shopping-basket me-1"></i> Pembeli</span>
                    @endif

                    {{-- Menampilkan Bio Ringkas --}}
                    @if($user->role === 'petani' && $user->petaniProfile && $user->petaniProfile->Bio)
                        <p class="text-secondary small mt-4 fst-italic">" {{ $user->petaniProfile->Bio }} "</p>
                    @elseif($user->role === 'pembeli' && $user->pembeliProfile && $user->pembeliProfile->Bio)
                        <p class="text-secondary small mt-4 fst-italic">" {{ $user->pembeliProfile->Bio }} "</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- KARTU INFORMASI SISTEM & PROFIL LENGKAP --}}
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h5 class="m-0 fw-bold text-dark"><i class="fas fa-info-circle text-success me-2"></i> Rincian Informasi Akun</h5>
                </div>
                <div class="card-body p-4">
                    
                    {{-- 1. INFORMASI UTAMA AKUN (SISTEM) --}}
                    <h6 class="fw-bold text-success mb-3"><i class="fas fa-user-cog me-2"></i> Kredensial Sistem</h6>
                    <table class="table table-borderless mb-4">
                        <tbody>
                            <tr>
                                <th class="text-muted">Username</th>
                                <td class="fw-semibold text-dark">: {{ $user->username }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Alamat Email</th>
                                <td class="fw-semibold text-dark">: {{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Tanggal Bergabung</th>
                                <td class="fw-semibold text-dark">: {{ $user->created_at ? $user->created_at->format('d F Y - H:i') : 'Tidak diketahui' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- 2. INFORMASI DATA DIRI SPESIFIK MITRA PETANI --}}
                    @if($user->role === 'petani')
                        <hr class="my-4 text-muted opacity-25">
                        <h6 class="fw-bold text-success mb-3"><i class="fas fa-address-card me-2"></i> Data Diri Profil Petani</h6>
                        <table class="table table-borderless mb-4">
                            <tbody>
                                <tr>
                                    <th class="text-muted w-25">Nama Lengkap</th>
                                    <td class="fw-semibold text-dark">: {{ $user->petaniProfile->NamaLengkap ?? 'Belum diisi' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">No. Telepon / WA</th>
                                    <td class="fw-semibold text-dark">: {{ $user->petaniProfile->NoTlp ?? 'Belum diisi' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Alamat Rumah/Lahan</th>
                                    <td class="fw-semibold text-dark">: {{ $user->petaniProfile->Alamat ?? 'Belum diisi' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- 3. INFORMASI REKENING BANK PETANI --}}
                        <hr class="my-4 text-muted opacity-25">
                        <h6 class="fw-bold text-success mb-3"><i class="fas fa-university me-2"></i> Informasi Rekening Pembayaran</h6>
                        <table class="table table-borderless mb-4">
                            <tbody>
                                <tr>
                                    <th class="text-muted w-25">Nama Bank</th>
                                    <td class="fw-bold text-primary">: {{ $user->petaniProfile->NamaBank ?? 'Belum diatur' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Nomor Rekening</th>
                                    <td class="fw-bold text-dark">: {{ $user->petaniProfile->NoRekening ?? 'Belum diatur' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Nama Pemilik</th>
                                    <td class="fw-semibold text-dark">: {{ $user->petaniProfile->NamaPemilik ?? 'Belum diatur' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif

                    {{-- 4. INFORMASI DATA DIRI SPESIFIK PEMBELI (JIKA BUKAN PETANI) --}}
                    @if($user->role === 'pembeli')
                        <hr class="my-4 text-muted opacity-25">
                        <h6 class="fw-bold text-success mb-3"><i class="fas fa-address-card me-2"></i> Data Diri Profil Pembeli</h6>
                        <table class="table table-borderless mb-4">
                            <tbody>
                                <tr>
                                    <th class="text-muted w-25">Nama Lengkap</th>
                                    <td class="fw-semibold text-dark">: {{ $user->pembeliProfile->NamaLengkap ?? 'Belum diisi' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">No. Telepon</th>
                                    <td class="fw-semibold text-dark">: {{ $user->pembeliProfile->NoTlp ?? 'Belum diisi' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Alamat Pengiriman</th>
                                    <td class="fw-semibold text-dark">: {{ $user->pembeliProfile->Alamat ?? 'Belum diisi' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif

                    <hr class="my-4 text-muted">
                    
                    {{-- AREA AKSI DARURAT ADMIN --}}
                    <h6 class="fw-bold text-danger mb-3"><i class="fas fa-exclamation-triangle me-2"></i> Tindakan Pengawasan (Admin)</h6>
                    
                    @if(session('success'))
                        <div class="alert alert-success fw-bold p-3 rounded-3 shadow-sm" style="font-size: 0.95rem;">
                            {{ session('success') }}
                            <br><small class="text-dark fw-normal mt-1 d-block">Silakan berikan password sementara di atas kepada user. Arahkan user untuk segera menggantinya setelah berhasil Login.</small>
                        </div>
                    @endif

                    <div class="d-flex flex-wrap gap-2">
                        {{-- Tombol Reset Password --}}
                        <form action="{{ route('admin.pengguna.reset', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mereset kata sandi pengguna ini? Password lama tidak akan bisa digunakan lagi.')">
                            @csrf
                            <button type="submit" class="btn btn-outline-warning fw-semibold text-dark">
                                <i class="fas fa-key me-1"></i> Reset Password Sementara
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection