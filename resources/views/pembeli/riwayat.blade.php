@extends('layouts.app22')
@section('title', 'Riwayat Transaksi Saya')

@section('content')
<div class="container" style="padding: 30px; max-width: 1000px; margin: 0 auto; font-family: sans-serif; color: #334155;">
    
    <div style="margin-bottom: 25px;">
        <h1 style="margin: 0; font-size: 1.5rem; font-weight: 700; color: #14532d;">Riwayat Transaksi</h1>
        <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.9rem;">Pantau status pembayaran dan pengiriman komoditas panen Anda di sini.</p>
    </div>

    @php
        $currentStatus = request()->query('status', 'semua');
        
        $filteredRiwayat = $riwayat->filter(function($pesanan) use ($currentStatus) {
            $sudahUpload = !empty($pesanan->BuktiTransfer);
            $statusPesanan = trim($pesanan->StatusPesanan);

            if ($currentStatus == 'belum-bayar') return in_array($statusPesanan, ['Menunggu Pembayaran', 'Belum Bayar']) || !$sudahUpload;
            if ($currentStatus == 'diproses') return $sudahUpload && in_array($statusPesanan, ['Menunggu Verifikasi Admin', 'Petani Menyiapkan Barang']);
            if ($currentStatus == 'dikirim') return $statusPesanan == 'Dikirim';
            if ($currentStatus == 'selesai') return in_array($statusPesanan, ['Pesanan Selesai', 'Selesai']);
            return true; 
        });
    @endphp

    <div style="display: flex; gap: 15px; border-bottom: 2px solid #e2e8f0; margin-bottom: 20px;">
        <a href="?status=semua" class="tab-btn {{ $currentStatus == 'semua' ? 'active-tab' : '' }}">Semua</a>
        <a href="?status=belum-bayar" class="tab-btn {{ $currentStatus == 'belum-bayar' ? 'active-tab' : '' }}">Belum Bayar</a>
        <a href="?status=diproses" class="tab-btn {{ $currentStatus == 'diproses' ? 'active-tab' : '' }}">Diproses</a>
        <a href="?status=dikirim" class="tab-btn {{ $currentStatus == 'dikirim' ? 'active-tab' : '' }}">Dikirim</a>
        <a href="?status=selesai" class="tab-btn {{ $currentStatus == 'selesai' ? 'active-tab' : '' }}">Selesai</a>
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; color: #15803d; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @forelse($filteredRiwayat as $pesanan)
    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
        
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 15px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-store" style="color: #14532d; font-size: 1.1rem;"></i>
                <span style="font-weight: 700; color: #1e293b;">Petani: {{ $pesanan->penawaran?->petani?->username ?? 'Tidak Diketahui' }}</span>
            </div>
            
            <div>
                @php $stat = trim($pesanan->StatusPesanan); @endphp
                @if(in_array($stat, ['Menunggu Pembayaran', 'Belum Bayar']) || empty($pesanan->BuktiTransfer))
                    <span style="color: #ef4444; font-weight: 700; font-size: 0.9rem;"><i class="fas fa-exclamation-circle"></i> Belum Bayar</span>
                @elseif($stat === 'Menunggu Verifikasi Admin')
                    <span style="color: #f59e0b; font-weight: 700; font-size: 0.9rem;"><i class="fas fa-clock"></i> Verifikasi Admin</span>
                @elseif(in_array($stat, ['Pesanan Selesai', 'Selesai']))
                    <span style="color: #14532d; font-weight: 700; font-size: 0.9rem;"><i class="fas fa-check-circle"></i> Pesanan Selesai</span>
                @else
                    <span style="color: #3b82f6; font-weight: 700; font-size: 0.9rem;">{{ $stat }}</span>
                @endif
            </div>
        </div>

        <div style="display: flex; align-items: flex-start; gap: 20px;">
            <div style="width: 80px; height: 80px; border-radius: 8px; border: 1px solid #e2e8f0; overflow: hidden; background: #f8fafc; flex-shrink: 0;">
                @if($pesanan->penawaran?->Gambar)
                    <img src="{{ asset('storage/' . $pesanan->penawaran->Gambar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #cbd5e1;"><i class="fas fa-box fa-2x"></i></div>
                @endif
            </div>
            
            <div style="flex-grow: 1;">
                <h5 style="margin: 0 0 5px 0; font-size: 1.1rem; font-weight: 700; color: #0f172a;">{{ $pesanan->penawaran?->Komoditas ?? 'Komoditas Terhapus' }}</h5>
                <p style="margin: 0; font-size: 0.9rem; color: #64748b;">
                    {{ $pesanan->penawaran?->JumlahTawar ?? 0 }} Kg x Rp {{ number_format($pesanan->penawaran?->HargaTawar ?? 0, 0, ',', '.') }}
                </p>
            </div>
            
            <div style="text-align: right; min-width: 150px; border-left: 1px dashed #e2e8f0; padding-left: 20px;">
                <p style="margin: 0 0 5px 0; font-size: 0.85rem; color: #64748b;">Total Belanja</p>
                <h5 style="margin: 0; font-size: 1.2rem; font-weight: 800; color: #14532d;">Rp {{ number_format($pesanan->TotalBayar, 0, ',', '.') }}</h5>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; padding-top: 15px; border-top: 1px solid #f1f5f9;">
            
            <a href="{{ route('detail', $pesanan->idPembayaran) }}" style="text-decoration: none; background: white; border: 1px solid #cbd5e1; color: #475569; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; transition: 0.2s;">
                Lihat Rincian
            </a>

            @if(in_array(trim($pesanan->StatusPesanan), ['Menunggu Pembayaran', 'Belum Bayar']) || empty($pesanan->BuktiTransfer))
                <a href="{{ route('pembayaran.show', $pesanan->idTawar) }}" style="text-decoration: none; background: #f59e0b; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 6px rgba(245, 158, 11, 0.2);">
                    Bayar Sekarang
                </a>

            @elseif(trim($pesanan->StatusPesanan) === 'Dikirim')
                <div style="display: flex; gap: 10px;">
                    
                    {{-- TOMBOL KOMPLAIN (Mengarah ke rute form) --}}
                    <a href="{{ route('pembeli.komplain.create', $pesanan->idPembayaran) }}" style="text-decoration: none; background: #ef4444; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 6px rgba(239, 68, 68, 0.2); display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-exclamation-triangle"></i> Ada Masalah
                    </a>

                    {{-- TOMBOL PESANAN SELESAI --}}
                    <form action="{{ route('pembeli.pesanan.selesai', $pesanan->idPembayaran) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Pesanan sudah sampai dengan aman? Klik OK untuk menyelesaikannya.')">
                        @csrf
                        <button type="submit" style="background: #14532d; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; cursor: pointer; box-shadow: 0 4px 6px rgba(20, 83, 45, 0.2); display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-check"></i> Pesanan Diterima
                        </button>
                    </form>
                    
                </div>

            @elseif(in_array(trim($pesanan->StatusPesanan), ['Pesanan Selesai', 'Selesai']))
                
                {{-- JIKA SUDAH SELESAI, CEK APAKAH SUDAH DINILAI --}}
                @if(!$pesanan->ulasan)
                    {{-- TOMBOL NILAI MUNCUL --}}
                    <button type="button" onclick="document.getElementById('modalUlasan-{{ $pesanan->idPembayaran }}').style.display='flex'" style="background: #eab308; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; cursor: pointer; box-shadow: 0 4px 6px rgba(234, 179, 8, 0.2);">
                        Nilai Pesanan
                    </button>

                    {{-- MODAL ULASAN (DENGAN UPLOAD MEDIA) --}}
                    <div id="modalUlasan-{{ $pesanan->idPembayaran }}" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 999; align-items: center; justify-content: center;">
                        <div style="background: white; padding: 25px; border-radius: 16px; width: 90%; max-width: 450px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                            <h4 style="margin: 0 0 5px 0; color: #1f2937; font-weight: 700;">Nilai Komoditas</h4>
                            <p style="margin: 0 0 20px 0; font-size: 0.9rem; color: #6b7280;">Beri ulasan dan tambahkan foto/video</p>
                            
                            {{-- FORM ENCTYPE MULTIPART UNTUK FILE --}}
                            <form action="{{ route('pembeli.ulasan', $pesanan->idPembayaran) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                {{-- Bintang --}}
                                <div style="font-size: 2.5rem; color: #e5e7eb; margin-bottom: 20px; display: flex; justify-content: center; gap: 5px; cursor: pointer;">
                                    <i class="fas fa-star star-btn-{{ $pesanan->idPembayaran }}" data-value="1" onclick="setRating({{ $pesanan->idPembayaran }}, 1)"></i>
                                    <i class="fas fa-star star-btn-{{ $pesanan->idPembayaran }}" data-value="2" onclick="setRating({{ $pesanan->idPembayaran }}, 2)"></i>
                                    <i class="fas fa-star star-btn-{{ $pesanan->idPembayaran }}" data-value="3" onclick="setRating({{ $pesanan->idPembayaran }}, 3)"></i>
                                    <i class="fas fa-star star-btn-{{ $pesanan->idPembayaran }}" data-value="4" onclick="setRating({{ $pesanan->idPembayaran }}, 4)"></i>
                                    <i class="fas fa-star star-btn-{{ $pesanan->idPembayaran }}" data-value="5" onclick="setRating({{ $pesanan->idPembayaran }}, 5)"></i>
                                </div>
                                <input type="hidden" name="Rating" id="ratingInput-{{ $pesanan->idPembayaran }}" required>
                                
                                {{-- Text Ulasan --}}
                                <textarea name="Ulasan" rows="3" placeholder="Ceritakan kualitas komoditas ini..." style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; margin-bottom: 15px; font-family: inherit; resize: none;"></textarea>
                                
                                {{-- Upload Media (Ala Shopee) --}}
                                <div style="margin-bottom: 25px; text-align: left;">
                                    <label style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100px; height: 100px; border: 2px dashed #cbd5e1; border-radius: 8px; cursor: pointer; color: #ef4444; background: #fef2f2; transition: 0.2s;">
                                        <i class="fas fa-camera" style="font-size: 1.5rem; margin-bottom: 5px;"></i>
                                        <span style="font-size: 0.75rem; font-weight: 600;">Tambah Foto</span>
                                        <input type="file" name="MediaUlasan" accept="image/*,video/*" style="display: none;" onchange="alert('Media berhasil dipilih!')">
                                    </label>
                                </div>

                                <div style="display: flex; gap: 12px;">
                                    <button type="button" onclick="document.getElementById('modalUlasan-{{ $pesanan->idPembayaran }}').style.display='none'" style="background: #f3f4f6; color: #4b5563; border: none; padding: 12px 0; border-radius: 8px; font-weight: 700; cursor: pointer; flex: 1;">Nanti Saja</button>
                                    <button type="submit" style="background: #ea580c; color: white; border: none; padding: 12px 0; border-radius: 8px; font-weight: 700; cursor: pointer; flex: 1;">Kirim Penilaian</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    {{-- JIKA SUDAH DINILAI --}}
                    <span style="padding: 8px 16px; color: #16a34a; font-weight: 600; font-size: 0.9rem; background: #dcfce7; border-radius: 6px;">
                        <i class="fas fa-star" style="color: #eab308;"></i> Sudah Dinilai
                    </span>
                @endif
            @endif

        </div>
    </div>
    @empty
    <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 12px; border: 1px dashed #cbd5e1;">
        <i class="fas fa-receipt" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 15px;"></i>
        <h5 style="margin: 0 0 5px 0; color: #475569;">Belum Ada Transaksi</h5>
        <p style="margin: 0; color: #94a3b8; font-size: 0.9rem;">Riwayat belanja komoditas Anda akan muncul di sini.</p>
    </div>
    @endforelse

</div>

<style>
    .tab-btn { text-decoration: none; color: #64748b; font-weight: 600; padding: 10px 5px; margin-bottom: -2px; transition: 0.2s; }
    .tab-btn:hover { color: #14532d; }
    .active-tab { color: #14532d; border-bottom: 2px solid #14532d; }
</style>

<script>
    function setRating(id, value) {
        document.getElementById('ratingInput-' + id).value = value;
        let stars = document.querySelectorAll('.star-btn-' + id);
        stars.forEach(s => {
            if (s.getAttribute('data-value') <= value) {
                s.style.color = '#eab308';
                s.style.transform = 'scale(1.1)'; 
            } else {
                s.style.color = '#e5e7eb';
                s.style.transform = 'scale(1)';
            }
        });
    }
</script>
@endsection