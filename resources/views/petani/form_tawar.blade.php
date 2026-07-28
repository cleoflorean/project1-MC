@extends('layouts.app')

@section('title', 'Tawarkan Hasil Panen')
@section('page-title', 'Tawarkan Hasil Panen')

@section('content')
<div class="container-fluid">

    {{-- Header & Tombol Kembali --}}
    <div class="d-flex align-items-center mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-3 btn-sm rounded-circle">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h4 class="fw-bold mb-0 text-dark">Buat Penawaran Panen</h4>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mb-4 rounded-4 shadow-sm">
            <h6 class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Gagal Mengirim Penawaran:</h6>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Utama Penawaran --}}
    <form action="{{ route('tawar.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    {{-- Menggabungkan ketangguhan request() dengan kemudahan variabel Controller --}}
    <input type="hidden" name="idMinta" value="{{ $idMinta ?? request()->query('idMinta') }}">

        <div class="row g-4">
            
            {{-- SISI KIRI: Detail Informasi Penawaran (col-lg-8) --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-success mb-3"><i class="bi bi-file-earmark-text me-2"></i>Detail Informasi Penawaran</h6>
                        
                        <div class="row g-3">
                            {{-- Nama Tanaman (SEKARANG DI SEBELAH KIRI / READONLY) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Nama Tanaman</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-flower1"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 fw-bold text-success" name="NamaTanaman" 
                                           value="{{ request()->query('NamaTanaman') }}" readonly>
                                </div>
                                <div class="form-text text-muted" style="font-size: 11px;">Nama tanaman dikunci otomatis mengikuti permintaan pembeli.</div>
                            </div>

                            {{-- Kategori Komoditas (SEKARANG DI SEBELAH KANAN / READONLY) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Komoditas</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-grid-3x3-gap-fill"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 fw-bold text-dark" name="Komoditas" 
                                           value="{{ request()->query('Komoditas') }}" readonly>
                                </div>
                                <div class="form-text text-muted" style="font-size: 11px;">Komoditas dikunci otomatis sesuai kategori permintaan pasar.</div>
                            </div>

                            {{-- Jumlah Tawar --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Jumlah yang Ditawarkan</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('JumlahTawar') is-invalid @enderror" 
                                           id="JumlahTawar" name="JumlahTawar" placeholder="Contoh: 50" min="1" required>
                                    <span class="input-group-text bg-light">Kg</span>
                                </div>
                                @error('JumlahTawar')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Harga Tawar --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Harga Penawaran</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('HargaTawar') is-invalid @enderror" 
                                           name="HargaTawar" placeholder="Contoh: 5000" min="1" required>
                                    <span class="input-group-text bg-light">/kg</span>
                                </div>
                                @error('HargaTawar')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Catatan --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Catatan Tambahan</label>
                                <textarea class="form-control @error('Catatan') is-invalid @enderror" 
                                          name="Catatan" rows="4" placeholder="Tulis rincian kondisi barang atau info penyerahan..." required></textarea>
                                @error('Catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2 justify-content-end mb-5">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4 rounded-3">Batal</a>
                    <button type="submit" id="btnKirim" class="btn btn-success px-5 rounded-3 fw-semibold">
                        <i class="bi bi-megaphone-fill me-2"></i>Kirim Penawaran
                    </button>
                </div>
            </div>

            {{-- SISI KANAN: Upload Foto --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-success mb-3"><i class="bi bi-image me-2"></i>Foto Komoditas</h6>
                        
                        <div class="border {{ $errors->has('Gambar') ? 'border-danger' : '' }} rounded-3 p-4 text-center bg-light" 
                             id="dropZone" style="cursor: pointer; border-style: dashed !important;">
                            <i class="bi bi-camera-fill text-muted fs-1 mb-2"></i>
                            <p class="mb-1 text-dark fw-semibold small">Klik untuk unggah foto</p>
                            <span class="text-muted d-block small" style="font-size: 11px;">Format JPG/PNG (Maks. 2MB)</span>
                            
                            <input type="file" class="form-control d-none" id="Gambar" name="Gambar" accept="image/*">
                        </div>

                        @error('Gambar')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
    // Trigger Unggah Foto
    document.getElementById('dropZone').addEventListener('click', function() {
        document.getElementById('Gambar').click();
    });

    document.getElementById('Gambar').addEventListener('change', function() {
        if(this.files.length > 0) {
            document.querySelector('#dropZone p').innerText = this.files[0].name;
            document.querySelector('#dropZone i').className = "bi bi-check-circle-fill text-success fs-1 mb-2";
        }
    });
</script>
@endsection