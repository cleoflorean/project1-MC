@extends('layouts.app')
@section('title', 'Daftar Ulasan Pembeli')

@section('content')
<div style="background-color: #F8FAFC; min-height: 100vh; padding-bottom: 60px; font-family: sans-serif; color: #0F172A;">
    
    {{-- HEADER KEMBALI --}}
    <div style="max-width: 768px; margin: 0 auto; padding: 32px 20px 24px 20px;">
        <a href="{{ route('petani.profil') }}" style="display: inline-flex; align-items: center; gap: 12px; color: #475569; text-decoration: none; font-size: 1rem; font-weight: 500; transition: 0.3s;">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Profil Saya
        </a>
    </div>

    <div style="max-width: 768px; margin: 0 auto; padding: 0 20px;">
        
        <div style="background: #FFFFFF; border-radius: 16px; padding: 25px; border: 1px solid #E2E8F0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <h3 style="margin: 0 0 20px 0; font-weight: 700; color: #1e293b; border-bottom: 2px solid #F1F5F9; padding-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-star" style="color: #fbbf24;"></i> Semua Ulasan dari Pembeli
            </h3>
            
            <div>
                @forelse($daftarUlasan as $ul)
                    <div style="border-bottom: 1px solid #E2E8F0; padding-bottom: 20px; margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <strong style="color: #334155; font-size: 1rem;">
                                {{ $ul->pembayaran->penawaran->permintaan->user->username ?? 'Pembeli Anonim' }}
                            </strong>
                            <small style="color: #94a3b8; font-weight: 500;">{{ $ul->created_at->format('d M Y') }}</small>
                        </div>
                        
                        <div style="color: #fbbf24; font-size: 0.9rem; margin-bottom: 10px;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $ul->Rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                        
                        <p style="color: #475569; font-size: 0.95rem; line-height: 1.6; margin: 0 0 12px 0; background: #F8FAFC; padding: 12px 16px; border-radius: 8px; font-style: italic;">
                            {{ $ul->Ulasan != '' ? '"'.$ul->Ulasan.'"' : '(Pembeli tidak menulis pesan ulasan)' }}
                        </p>
                        
                        @if($ul->MediaUlasan)
                            <div style="margin-top: 10px;">
                                @if(\Illuminate\Support\Str::endsWith($ul->MediaUlasan, ['.mp4', '.mov']))
                                    <video src="{{ asset('storage/' . $ul->MediaUlasan) }}" controls style="max-height: 180px; border-radius: 8px; border: 1px solid #E2E8F0;"></video>
                                @else
                                    <img src="{{ asset('storage/' . $ul->MediaUlasan) }}" style="max-height: 180px; border-radius: 8px; border: 1px solid #E2E8F0; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <div style="text-align: center; padding: 50px 0;">
                        <i class="far fa-comment-dots" style="font-size: 4rem; color: #CBD5E1; margin-bottom: 15px; display: block;"></i>
                        <p style="color: #64748b; font-size: 1rem; margin: 0;">Belum ada ulasan yang masuk dari pembeli.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection