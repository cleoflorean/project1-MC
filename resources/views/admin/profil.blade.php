@extends('layouts.admin') {{-- Sesuaikan nama master layout kamu --}}

@section('content')
{{-- UBAH DI SINI: px-0, mt-0, dan tambahan margin-top negatif untuk menarik ke atas --}}
<div class="container-fluid px-0 mt-0 mb-5" style="margin-top: -10px;">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-3" role="alert">
            <i class="fas fa-check-circle me-2"></i><strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- BAGIAN KIRI: FORM PENGATURAN --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="border-radius: 8px; overflow: hidden;">
                {{-- Header --}}
                <div class="card-header py-3" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <h5 class="mb-1" style="font-size: 1.05rem; font-weight: 600; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-wallet" style="color: #15803d;"></i> Pengaturan Rekening Pencairan
                    </h5>
                    <small style="color: #64748b; margin-left: 28px;">Rekening ini akan ditampilkan kepada Pembeli saat mereka melakukan pembayaran.</small>
                </div>
                
                {{-- Body --}}
                <div class="card-body p-4">
                    <form action="{{ route('admin.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- 1. Nama Lengkap Admin (Paling Atas) --}}
                        <div class="mb-4">
                            <label style="font-size: 0.9rem; font-weight: 500; color: #334155; margin-bottom: 8px;">Nama Lengkap Admin <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-color: #cbd5e1;">
                                    <i class="fas fa-id-badge text-muted" style="width: 20px; text-align: center;"></i>
                                </span>
                                <input type="text" name="NamaLengkap" class="form-control border-start-0 ps-0 @error('NamaLengkap') is-invalid @enderror" 
                                       value="{{ old('NamaLengkap', $profile->NamaLengkap) }}" style="border-color: #cbd5e1; color: #475569;">
                            </div>
                            @error('NamaLengkap') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- 2. Bank dan Nomor Rekening (Sejajar) --}}
                        <div class="row g-3 mb-4">
                            {{-- Nama Bank --}}
                            <div class="col-md-6">
                                <label style="font-size: 0.9rem; font-weight: 500; color: #334155; margin-bottom: 8px;">Nama Bank / E-Wallet <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0" style="border-color: #cbd5e1;">
                                        <i class="fas fa-university text-muted" style="width: 20px; text-align: center;"></i>
                                    </span>
                                    <select name="NamaBank" class="form-select border-start-0 ps-0 @error('NamaBank') is-invalid @enderror" style="border-color: #cbd5e1; color: #475569;">
                                        <option value="">-- Pilih Bank --</option>
                                        <option value="BCA" {{ (old('NamaBank', $profile->NamaBank) == 'BCA') ? 'selected' : '' }}>BCA</option>
                                        <option value="BRI" {{ (old('NamaBank', $profile->NamaBank) == 'BRI') ? 'selected' : '' }}>BRI</option>
                                        <option value="Mandiri" {{ (old('NamaBank', $profile->NamaBank) == 'Mandiri') ? 'selected' : '' }}>Mandiri</option>
                                        <option value="BNI" {{ (old('NamaBank', $profile->NamaBank) == 'BNI') ? 'selected' : '' }}>BNI</option>
                                        <option value="BSI" {{ (old('NamaBank', $profile->NamaBank) == 'BSI') ? 'selected' : '' }}>BSI</option>
                                    </select>
                                </div>
                                @error('NamaBank') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Nomor Rekening --}}
                            <div class="col-md-6">
                                <label style="font-size: 0.9rem; font-weight: 500; color: #334155; margin-bottom: 8px;">Nomor Rekening / E-Wallet <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0" style="border-color: #cbd5e1;">
                                        <span style="color: #94a3b8; font-weight: bold; width: 20px; text-align: center;">#</span>
                                    </span>
                                    <input type="text" name="NoRekening" class="form-control border-start-0 ps-0 @error('NoRekening') is-invalid @enderror" 
                                           value="{{ old('NoRekening', $profile->NoRekening) }}" placeholder="Contoh: 1234567890" style="border-color: #cbd5e1; color: #475569;">
                                </div>
                                @error('NoRekening') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        
                        {{-- 3. Atas Nama Rekening --}}
                        <div class="mb-4">
                            <label style="font-size: 0.9rem; font-weight: 500; color: #334155; margin-bottom: 8px;">Atas Nama (Pemilik Rekening) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-color: #cbd5e1;">
                                    <i class="fas fa-user-circle text-muted" style="width: 20px; text-align: center;"></i>
                                </span>
                                <input type="text" name="NamaPemilik" class="form-control border-start-0 ps-0 @error('NamaPemilik') is-invalid @enderror" 
                                       value="{{ old('NamaPemilik', $profile->NamaPemilik) }}" placeholder="Sesuai dengan buku tabungan" style="border-color: #cbd5e1; color: #475569;">
                            </div>
                            @error('NamaPemilik') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- 4. Kotak Konfirmasi Keamanan --}}
                        <div style="background-color: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
                            <h6 style="margin: 0 0 8px 0; color: #1e293b; font-size: 0.95rem; display: flex; align-items: center; gap: 8px; font-weight: 600;">
                                <i class="fas fa-shield-alt" style="color: #64748b;"></i> Konfirmasi Keamanan
                            </h6>
                            <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 16px;">
                                Untuk menyimpan perubahan rekening, mohon masukkan password akun Anda.
                            </p>
                            
                            <div class="input-group" style="max-width: 400px;">
                                <span class="input-group-text bg-white border-end-0" style="border-color: #cbd5e1;">
                                    <i class="fas fa-lock text-muted" style="width: 20px; text-align: center;"></i>
                                </span>
                                <input type="password" name="password" class="form-control border-start-0 ps-0" 
                                       placeholder="Masukkan password saat ini..." style="border-color: #cbd5e1; color: #475569;">
                            </div>
                            @error('password') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>

                        {{-- Tombol Simpan --}}
                        <button type="submit" class="btn text-white fw-bold" style="background-color: #15803d; padding: 8px 24px; border-radius: 6px;">
                            <i class="fas fa-save me-2"></i> Simpan Rekening
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: INFORMASI ESCROW --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0" style="border-radius: 8px; background-color: #f8fafc;">
                <div class="card-body p-4">
                    <h6 style="color: #0f172a; font-size: 1rem; font-weight: 700; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-info-circle text-success"></i> Informasi Pencairan
                    </h6>
                    <ul style="color: #475569; font-size: 0.9rem; margin: 0; padding-left: 20px; line-height: 1.8;">
                        <li class="mb-2">Pembeli akan transfer ke <strong>rekening di samping</strong> untuk pembayaran.</li>
                        <li class="mb-2">Dana diamankan oleh Anda (Admin) hingga status pesanan dinyatakan selesai.</li>
                        <li>Pencairan dana ke Petani dilakukan <strong>secara manual</strong> oleh Admin saat menekan tombol "Cairkan ke Petani".</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CSS Tambahan --}}
<style>
    .input-group .form-control:focus, .input-group .form-select:focus {
        box-shadow: none;
        border-color: #cbd5e1;
    }
</style>
@endsection