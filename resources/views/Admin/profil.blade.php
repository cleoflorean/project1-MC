@extends('layouts.admin') {{-- Sesuaikan nama master layout kamu --}}

@section('content')
<div class="container-fluid mt-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-success fw-bold">Pengaturan Rekening Bersama (Escrow)</h5>
                    <small class="text-muted">Rekening ini akan ditampilkan kepada Pembeli saat mereka melakukan pembayaran.</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap Admin <span class="text-danger">*</span></label>
                            <input type="text" name="NamaLengkap" class="form-control @error('NamaLengkap') is-invalid @enderror" 
                                   value="{{ old('NamaLengkap', $profile->NamaLengkap) }}">
                            @error('NamaLengkap') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Bank Penampung <span class="text-danger">*</span></label>
                            <select name="NamaBank" class="form-select @error('NamaBank') is-invalid @enderror">
                                <option value="">-- Pilih Bank --</option>
                                <option value="BCA" {{ (old('NamaBank', $profile->NamaBank) == 'BCA') ? 'selected' : '' }}>BCA</option>
                                <option value="BRI" {{ (old('NamaBank', $profile->NamaBank) == 'BRI') ? 'selected' : '' }}>BRI</option>
                                <option value="Mandiri" {{ (old('NamaBank', $profile->NamaBank) == 'Mandiri') ? 'selected' : '' }}>Mandiri</option>
                                <option value="BNI" {{ (old('NamaBank', $profile->NamaBank) == 'BNI') ? 'selected' : '' }}>BNI</option>
                                <option value="BSI" {{ (old('NamaBank', $profile->NamaBank) == 'BSI') ? 'selected' : '' }}>BSI</option>
                            </select>
                            @error('NamaBank') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="NoRekening" class="form-control @error('NoRekening') is-invalid @enderror" 
                                   value="{{ old('NoRekening', $profile->NoRekening) }}">
                            @error('NoRekening') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Atas Nama Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="NamaPemilik" class="form-control @error('NamaPemilik') is-invalid @enderror" 
                                   value="{{ old('NamaPemilik', $profile->NamaPemilik) }}">
                            @error('NamaPemilik') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <button type="submit" class="btn btn-success px-4">Simpan Rekening</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Informasi Pencairan (Escrow)</h6>
                    <ul class="text-muted small ps-3 mb-0" style="line-height: 1.8;">
                        <li>Pembeli akan transfer ke <strong>rekening di samping</strong>.</li>
                        <li>Dana diamankan oleh Anda (Admin) hingga status pesanan selesai.</li>
                        <li>Pencairan dana ke Petani dilakukan <strong>secara manual</strong> oleh Admin saat menekan tombol "Cairkan ke Petani".</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection