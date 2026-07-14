@extends('layouts.app22')
@section('title', 'Detail Foto Kondisi Barang')

@section('content')
<div class="container" style="padding: 30px; max-width: 800px; margin: 0 auto; font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif; color: #334155;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; margin-bottom: 30px;">
        <div>
            <h1 style="margin: 0; font-size: 1.5rem; font-weight: 700; color: #1e293b; letter-spacing: -0.3px;">Foto Kondisi Barang</h1>
            <p style="margin: 6px 0 0 0; color: #64748b; font-size: 0.95rem;">
                Komoditas: <span style="font-weight: 600; color: #15803d;">{{ $tawar->Komoditas ?? $tawar->NamaTanaman }}</span>
            </p>
        </div>
        <div>
            <a href="javascript:history.back()" style="display: inline-flex; align-items: center; gap: 8px; background: #ffffff; color: #475569; border: 1px solid #cbd5e1; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.85rem; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
                <i class="fas fa-arrow-left" style="font-size: 0.8rem;"></i> Kembali
            </a>
        </div>
    </div>

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        
        <div style="background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px dashed #cbd5e1; display: inline-block; width: 100%;">
            @if($tawar->Gambar)
                <img src="{{ asset($tawar->Gambar) }}" alt="Foto Barang" style="max-width: 100%; height: auto; border-radius: 6px;">
            @else
                <div style="padding: 50px; color: #94a3b8;">
                    <i class="fas fa-image" style="font-size: 3rem; margin-bottom: 10px;"></i>
                    <p>Gambar tidak tersedia</p>
                </div>
            @endif
        </div>

        <div style="margin-top: 25px; text-align: left; background: #f0fdf4; border: 1px solid #bbf7d0; padding: 15px 20px; border-radius: 8px; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <div>
                <span style="font-size: 0.75rem; color: #166534; text-transform: uppercase; font-weight: 700;">Petani Pengirim</span>
                <div style="font-size: 1rem; font-weight: 600; color: #14532d;">
                    {{ $tawar->petani->petaniProfile->NamaLengkap ?? 'Nama Tidak Diketahui' }} 
                    <span style="font-weight: normal; font-size: 0.85rem;">({{ $tawar->petani->username ?? 'Mitra Petani' }})</span>
                </div>
            </div>
            <div>
                <span style="font-size: 0.75rem; color: #166534; text-transform: uppercase; font-weight: 700;">Harga Penawaran</span>
                <div style="font-size: 1rem; font-weight: 600; color: #14532d;">Rp {{ number_format($tawar->HargaTawar, 0, ',', '.') }}</div>
            </div>
            <div>
                <span style="font-size: 0.75rem; color: #166534; text-transform: uppercase; font-weight: 700;">Volume</span>
                <div style="font-size: 1rem; font-weight: 600; color: #14532d;">{{ number_format($tawar->JumlahTawar, 0, ',', '.') }} kg</div>
            </div>
        </div>

    </div>
</div>
@endsection