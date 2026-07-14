@extends('layouts.app')
@section('content')

@php
    $pesananBaru = $pesanans->filter(function($p) {
        return trim($p->StatusPesanan) === 'Menunggu Verifikasi Admin';
    });
    
    $pesananProses = $pesanans->filter(function($p) {
        return in_array(trim($p->StatusPesanan), ['Petani Menyiapkan Barang', 'Dikirim']);
    });
    
    $pesananSelesai = $pesanans->filter(function($p) {
        return in_array(trim($p->StatusPesanan), ['Pesanan Selesai', 'Selesai']);
    });
@endphp

<div style="background-color: #f5f5f5; min-height: 100vh; padding: 30px 0; font-family: sans-serif;">
    <div class="container">
        
        <h3 style="font-weight: 700; color: #212121; margin-bottom: 20px;">Daftar Pesanan Masuk</h3>

        @if(session('success'))
            <div class="alert alert-success" style="border-radius: 8px;">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <div style="background: white; border-radius: 8px; box-shadow: 0 1px 6px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 30px;">
            
            {{-- NAVIGASI TAB --}}
            <div class="d-flex" style="border-bottom: 1px solid #e0e0e0; overflow-x: auto; white-space: nowrap;">
                <button class="tab-btn active-tab" onclick="openTab(event, 'tabBaru')">
                    Menunggu Admin 
                    @if($pesananBaru->count() > 0)
                        <span style="background: #ef4444; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.7rem; margin-left: 5px;">{{ $pesananBaru->count() }}</span>
                    @endif
                </button>
                <button class="tab-btn" onclick="openTab(event, 'tabProses')">
                    Diproses & Dikirim
                    @if($pesananProses->count() > 0)
                        <span style="background: #f59e0b; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.7rem; margin-left: 5px;">{{ $pesananProses->count() }}</span>
                    @endif
                </button>
                <button class="tab-btn" onclick="openTab(event, 'tabSelesai')">
                    Selesai
                    @if($pesananSelesai->count() > 0)
                        <span style="background: #10b981; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.7rem; margin-left: 5px;">{{ $pesananSelesai->count() }}</span>
                    @endif
                </button>
            </div>

            <div style="padding: 20px;">
                <div id="tabBaru" class="tab-content" style="display: block;">
                    @include('Petani.pesanan-list', ['dataPesanan' => $pesananBaru, 'tipeTab' => 'baru'])
                </div>
                <div id="tabProses" class="tab-content" style="display: none;">
                    @include('Petani.pesanan-list', ['dataPesanan' => $pesananProses, 'tipeTab' => 'proses'])
                </div>
                <div id="tabSelesai" class="tab-content" style="display: none;">
                    @include('Petani.pesanan-list', ['dataPesanan' => $pesananSelesai, 'tipeTab' => 'selesai'])
                </div>
            </div>

        </div>
    </div>
</div>

{{-- POPUP MODAL RATING (DIPANGGIL SECARA DINAMIS) --}}
<div id="ratingModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: white; width: 100%; max-width: 500px; border-radius: 16px; padding: 25px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); position: relative; margin: 0 15px; font-family: 'Segoe UI', system-ui, sans-serif;">
        <span onclick="tutupModalRating()" style="position: absolute; top: 15px; right: 20px; font-size: 1.8rem; cursor: pointer; color: #94a3b8;">&times;</span>
        
        <h4 style="margin: 0 0 5px 0; font-weight: 700; color: #1e293b; font-size: 1.2rem;">Ulasan dari <span id="modalPembeli">Pembeli</span></h4>
        <p style="margin: 0 0 20px 0; font-size: 0.85rem; color: #64748b;">Terima kasih telah menyelesaikan transaksi dengan baik!</p>
        
        <div style="background: #fffbeb; border: 1px solid #fef3c7; border-radius: 10px; padding: 15px; text-align: center; margin-bottom: 20px;">
            <div id="modalBintang" style="font-size: 1.8rem; margin-bottom: 5px;"></div>
            <div id="modalSkor" style="font-weight: 700; color: #b45309; font-size: 1.05rem;">0 / 5.0</div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; font-size: 0.9rem; color: #475569; margin-bottom: 6px;">Pesan Pembeli:</label>
            <div id="modalIsiUlasan" style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px 15px; border-radius: 8px; color: #334155; font-size: 0.95rem; line-height: 1.5; font-style: italic;"></div>
        </div>

        <div id="modalMediaContainer" style="display: none; margin-bottom: 10px;">
            <label style="display: block; font-weight: 600; font-size: 0.9rem; color: #475569; margin-bottom: 6px;">Foto Lampiran:</label>
            <img id="modalImg" src="" style="width: 100%; max-height: 200px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
        </div>
    </div>
</div>

<style>
    .tab-btn { background: none; border: none; padding: 15px 25px; font-size: 0.95rem; font-weight: 600; color: #757575; cursor: pointer; transition: 0.2s; border-bottom: 3px solid transparent; margin-bottom: -1px; outline: none; }
    .tab-btn:hover { color: #00aa5b; }
    .active-tab { color: #00aa5b; border-bottom: 3px solid #00aa5b; }
</style>

<script>
    function openTab(evt, tabName) {
        let i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tab-btn");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active-tab", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active-tab";
    }

    // JAVASCRIPT UNTUK ATUR MODAL POPUPsecara Otomatis
    function bukaModalRating(element) {
        const rating = parseFloat(element.getAttribute('data-rating'));
        const ulasan = element.getAttribute('data-ulasan');
        const media = element.getAttribute('data-media');
        const pembeli = element.getAttribute('data-pembeli');

        document.getElementById('modalPembeli').innerText = pembeli;
        document.getElementById('modalSkor').innerText = rating.toFixed(1) + " / 5.0";
        document.getElementById('modalIsiUlasan').innerText = ulasan ? `"${ulasan}"` : "Pembeli tidak meninggalkan pesan teks.";

        // Render Bintang Mas
        let bintangHtml = '';
        for(let i = 1; i <= 5; i++) {
            if(i <= Math.round(rating)) {
                bintangHtml += '<i class="fas fa-star" style="color: #fbbf24; margin: 0 2px;"></i>';
            } else {
                bintangHtml += '<i class="far fa-star" style="color: #cbd5e1; margin: 0 2px;"></i>';
            }
        }
        document.getElementById('modalBintang').innerHTML = bintangHtml;

        // Cek Foto Lampiran Ulasan
        const imgContainer = document.getElementById('modalMediaContainer');
        const imgTag = document.getElementById('modalImg');
        if (media && media !== '') {
            imgTag.src = media;
            imgContainer.style.display = 'block';
        } else {
            imgContainer.style.display = 'none';
        }

        // Tampilkan Modal
        document.getElementById('ratingModal').style.display = 'flex';
    }

    function tutupModalRating() {
        document.getElementById('ratingModal').style.display = 'none';
    }

    // Klik di luar modal untuk menutup
    window.onclick = function(event) {
        const modal = document.getElementById('ratingModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection