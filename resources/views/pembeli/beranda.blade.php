@extends('layouts.app22')

@section('title', 'Beranda - TaniHarvest')

@section('content')
<!-- Hero Section Bootstrap -->
<div class="container py-5 mt-4">
    <div class="row justify-content-center text-center">
        <div class="col-lg-8 col-md-10">
            <!-- Judul Utama -->
            <h1 class="display-5 fw-bold text-dark mb-3">
                Platform Pengadaan Komoditas Pertanian Terpercaya
            </h1>
            
            <!-- Deskripsi -->
            <p class="lead text-secondary mb-4">
                Hubungkan permintaan pengadaan Anda dengan ribuan petani dan penyedia komoditas secara langsung, transparan, dan efisien.
            </p>
            
            <!-- Tombol Aksi -->
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-success btn-lg px-4 fw-bold">Mulai Sekarang</a>
                @endguest
                
                @auth
                    <a href="{{ route('pembeli') }}" class="btn btn-success btn-lg px-4 fw-bold">Ke Dashboard</a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection