@extends('layouts.app22')

@section('title', 'Beranda - Agrimart')

@section('content')
<div class="hero-section">
    <div class="hero-text">
        <h1>Platform Pengadaan Komoditas Pertanian Terpercaya</h1>
        <p>Hubungkan permintaan pengadaan Anda dengan ribuan petani dan penyedia komoditas secara langsung, transparan, dan efisien.</p>
        @guest
            <a href="{{ route('login') }}" class="btn btn-primary btn-large">Mulai Sekarang</a>
        @endguest
        @auth
            <a href="{{ route('pembeli') }}" class="btn btn-primary btn-large">Ke Dashboard</a>
        @endauth
    </div>
</div>
@endsection