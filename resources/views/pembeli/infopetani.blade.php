@extends('layouts.app22')
@section('title', 'Informasi Petani - Tani Harvest')

@section('content')
<div class="container-fluid" style="padding: 20px; max-width: 1200px; margin: 0 auto; font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif; box-sizing: border-box;">

    {{-- BREADCRUMB / KEMBALI --}}
    <div style="margin-bottom: 20px;">
        <a href="{{ url()->previous() }}" style="text-decoration: none; color: #475569; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- PROFIL HEADER --}}
<div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); display: flex; flex-wrap: wrap; overflow: hidden; margin-bottom: 30px;">
    
    {{-- BAGIAN KIRI: FOTO & IDENTITAS --}}
    {{-- Ubah background jadi #ffffff, tambahkan border-right sebagai pemisah --}}
    <div style="flex: 1; min-width: 320px; max-width: 400px; background: #ffffff; border-right: 1px solid #e2e8f0; padding: 24px; display: flex; flex-direction: column; justify-content: center;">
        
        <div style="display: flex; gap: 16px; align-items: center;">
            {{-- Foto Profil --}}
            <div style="position: relative; flex-shrink: 0;">
                @if(!empty($petani->FotoProfil))
                    {{-- Border foto diubah jadi abu-abu terang agar terlihat di atas putih --}}
                    <img src="{{ asset($petani->FotoProfil) }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #e2e8f0;">
                @else
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: #15803d; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; border: 2px solid #e2e8f0;">
                        {{ strtoupper(substr($petani->NamaKebun ?? $petani->NamaLengkap ?? 'P', 0, 1)) }}
                    </div>
                @endif
                <div style="position: absolute; bottom: 0; right: 4px; width: 14px; height: 14px; background: #22c55e; border: 2px solid #ffffff; border-radius: 50%;" title="Aktif"></div>
            </div>

            {{-- Nama & Status --}}
            <div>
                {{-- Warna nama diubah menjadi gelap (#1e293b) --}}
                <h1 style="margin: 0; font-size: 1.3rem; font-weight: 700; color: #1e293b; line-height: 1.2;">
                    {{ $petani->NamaKebun ?? $petani->NamaLengkap ?? 'Nama Petani' }}
                </h1>
                {{-- Warna username diubah menjadi abu-abu medium (#64748b) --}}
                <div style="font-size: 0.85rem; color: #64748b; margin-top: 4px; display: flex; align-items: center; gap: 4px;">
                    <i class="fas fa-user-circle"></i> {{ $petani->user->username ?? 'Username Tidak Tersedia'}}
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN KANAN: STATISTIK & INFO --}}
    <div style="flex: 2; min-width: 350px; background: #ffffff; padding: 30px; display: flex; align-items: center;">
        {{-- Kita gunakan flex container dengan space-between agar rata kiri dan kanan --}}
        <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 30px; width: 100%;">
            
            {{-- KOLOM KIRI (Di dalam bagian kanan): Transaksi & Rating --}}
            <div style="display: flex; flex-direction: column; gap: 16px;">
                {{-- Transaksi Berhasil --}}
                <div style="display: flex; align-items: center; gap: 12px; font-size: 0.95rem;">
                    <i class="fas fa-handshake" style="color: #64748b; font-size: 1.1rem; width: 20px; text-align: center;"></i>
                    <span style="color: #475569;">Transaksi Berhasil:</span>
                    <span style="color: #15803d; font-weight: 600;">{{ $totalKontrak ?? 0 }} Transaksi</span>
                </div>

                {{-- Rating / Penilaian --}}
                <div style="display: flex; align-items: center; gap: 12px; font-size: 0.95rem;">
                    <i class="fas fa-star" style="color: #64748b; font-size: 1.1rem; width: 20px; text-align: center;"></i>
                    <span style="color: #475569;">Penilaian:</span>
                    <span style="color: #15803d; font-weight: 600;">{{ number_format($rataRataRating ?? 0, 1) }} ({{ $totalUlasan ?? 0 }} Ulasan)</span>
                </div>
            </div>

            {{-- KOLOM KANAN (Di dalam bagian kanan): Waktu Bergabung --}}
            <div style="display: flex; flex-direction: column; gap: 16px;">
                {{-- Waktu Bergabung --}}
                <div style="display: flex; align-items: center; gap: 12px; font-size: 0.95rem;">
                    <i class="fas fa-calendar-check" style="color: #64748b; font-size: 1.1rem; width: 20px; text-align: center;"></i>
                    <span style="color: #475569;">Bergabung:</span>
                    <span style="color: #15803d; font-weight: 600;">
                        @if(isset($petani->user->created_at))
                            {{ \Carbon\Carbon::parse($petani->user->created_at)->translatedFormat('d M Y') }}
                        @else
                            -
                        @endif
                    </span>
                </div>
            </div>

        </div>
    </div>
</div>

    {{-- DAFTAR ULASAN PEMBELI --}}
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f5f9; padding-bottom: 16px; margin-bottom: 24px;">
            <h3 style="margin: 0; font-size: 1.2rem; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-comments" style="color: #15803d;"></i> Ulasan Pembeli
            </h3>
            <span style="background: #f0fdf4; color: #15803d; padding: 4px 14px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; border: 1px solid #bbf7d0;">
                {{ $totalUlasan ?? 0 }} Ulasan
            </span>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 20px;">
            @forelse($daftarUlasan as $ulasan)
                <div style="padding-bottom: 20px; border-bottom: 1px dashed #e2e8f0;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; flex-wrap: wrap; gap: 10px;">
                        
                        {{-- Kiri: Profil Pembeli & Bintang --}}
                        <div style="display: flex; gap: 12px; align-items: flex-start;">
                            {{-- Avatar Pembeli --}}
                            <div style="width: 40px; height: 40px; background: #f1f5f9; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-weight: bold; color: #64748b; flex-shrink: 0; border: 1px solid #e2e8f0;">
                                {{ strtoupper(substr($ulasan->pembayaran->penawaran->permintaan->user->username ?? 'P', 0, 1)) }}
                            </div>
                            
                            <div>
                                <h4 style="margin: 0; font-size: 0.95rem; color: #0f172a; font-weight: 700;">
                                    {{ $ulasan->pembayaran->penawaran->permintaan->user->username ?? 'Pembeli Anonim' }}
                                </h4>
                                
                                {{-- Bintang Rating --}}
                                <div style="color: #fbbf24; font-size: 0.85rem; margin-top: 4px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $ulasan->Rating ? 'fas' : 'far' }} fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        
                        {{-- Kanan: Tanggal & Komoditas --}}
                        <div style="text-align: right;">
                            <span style="font-size: 0.8rem; color: #94a3b8; display: block; margin-bottom: 4px;">
                                {{ \Carbon\Carbon::parse($ulasan->created_at)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                    </div>
                    
                    {{-- Teks Komentar --}}
                    <p style="margin: 12px 0 0 52px; font-size: 0.95rem; color: #475569; line-height: 1.6; background: #F8FAFC; padding: 12px 16px; border-radius: 8px; font-style: italic;">
                        {{ $ulasan->Ulasan != '' ? '"'.$ulasan->Ulasan.'"' : '(Pembeli tidak menulis pesan ulasan)' }}
                    </p>

                    {{-- GAMBAR/VIDEO ULASAN (Menyesuaikan dengan nama kolom MediaUlasan) --}}
                    @if($ulasan->MediaUlasan)
                        <div style="margin: 12px 0 0 52px;">
                            @if(\Illuminate\Support\Str::endsWith($ulasan->MediaUlasan, ['.mp4', '.mov']))
                                <video src="{{ asset('storage/' . $ulasan->MediaUlasan) }}" controls style="max-height: 180px; border-radius: 8px; border: 1px solid #E2E8F0;"></video>
                            @else
                                <img src="{{ asset('storage/' . $ulasan->MediaUlasan) }}" alt="Foto Ulasan Pembeli" 
                                     style="max-height: 180px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.05); cursor: pointer;"
                                     onclick="window.open(this.src, '_blank')">
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div style="text-align: center; padding: 40px 20px; background: #f8fafc; border-radius: 8px; border: 2px dashed #cbd5e1;">
                    <i class="far fa-comment-dots" style="font-size: 2rem; color: #cbd5e1; margin-bottom: 12px;"></i>
                    <h4 style="margin: 0 0 8px 0; color: #475569; font-weight: 600;">Belum ada ulasan</h4>
                    <p style="margin: 0; font-size: 0.9rem; color: #94a3b8;">Petani ini belum menerima ulasan dari pembeli.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection