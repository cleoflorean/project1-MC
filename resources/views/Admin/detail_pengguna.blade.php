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
                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px; font-size: 2.5rem; text-transform: uppercase;">
                        {{ substr($user->username, 0, 2) }}
                    </div>
                    <h4 class="fw-bold text-dark mb-1">{{ $user->username }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    @if($user->role === 'admin')
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fs-6">Administrator</span>
                    @elseif($user->role === 'petani')
                        <span class="badge bg-success px-3 py-2 rounded-pill fs-6"><i class="fas fa-tractor me-1"></i> Mitra Petani</span>
                    @else
                        <span class="badge bg-primary px-3 py-2 rounded-pill fs-6"><i class="fas fa-shopping-basket me-1"></i> Pembeli</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- KARTU INFORMASI SISTEM --}}
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h5 class="m-0 fw-bold text-dark"><i class="fas fa-info-circle text-success me-2"></i> Informasi Akun</h5>
                </div>
                <div class="card-body p-4">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th class="text-muted w-25">ID Pengguna</th>
                                <td class="fw-bold text-dark">: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</td>
                            </tr>
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
                            <tr>
                                <th class="text-muted">Status Keamanan</th>
                                <td class="fw-semibold text-dark">: <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif (Verified)</span></td>
                            </tr>
                        </tbody>
                    </table>

                    <hr class="my-4 text-muted">
                    
                    {{-- AREA AKSI DARURAT ADMIN --}}
                    <h6 class="fw-bold text-danger mb-3"><i class="fas fa-exclamation-triangle me-2"></i> Tindakan Pengawasan (Admin)</h6>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-danger fw-semibold" onclick="alert('Fitur blokir sedang dalam pengembangan.')">
                            <i class="fas fa-ban me-1"></i> Suspend / Blokir Akun
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection