@extends('layouts.app22')
@section('title', 'Pembayaran')

@section('content')
<div class="container" style="padding: 50px 20px; max-width: 500px; margin: 0 auto; font-family: -apple-system, BlinkMacSystemFont, 'Inter', sans-serif; color: #1f2937;">
    
    {{-- KARTU UTAMA PREMIUM --}}
    <div style="background: #ffffff; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(6, 78, 59, 0.08); overflow: hidden; border: 1px solid #f3f4f6;">
        
        {{-- BAGIAN ATAS: HERO HEADER (TEMA TANUB PREMIUM EDITIONS) --}}
        <div style="background: linear-gradient(135deg, #064e3b 0%, #022c22 100%); padding: 45px 40px; text-align: center; color: #ffffff;">
            {{-- IKON 1: Logo Tema Pertanian/Aplikasi --}}
            <div style="width: 45px; height: 45px; background: rgba(255, 255, 255, 0.08); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; color: #34d399; font-size: 1.2rem;">
                <i class="fas fa-leaf"></i>
            </div>
            <p style="margin: 0 0 6px 0; font-size: 0.75rem; font-weight: 600; color: #a7f3d0; letter-spacing: 1.5px; text-transform: uppercase;">Total Tagihan Pembayaran</p>
            <h2 style="margin: 0; font-size: 2.5rem; font-weight: 800; letter-spacing: -1px; color: #ffffff;">
                Rp{{ number_format($pembayaran->TotalBayar, 0, ',', '.') }}
            </h2>
        </div>

        {{-- KONTEN UTAMA --}}
        <div style="padding: 40px;">
            
            {{-- DETAIL PESANAN --}}
            <div style="margin-bottom: 35px;">
                <p style="margin: 0 0 16px 0; font-size: 0.85rem; font-weight: 700; color: #064e3b; letter-spacing: 0.5px; text-transform: uppercase;">Rincian Transaksi</p>
                <div style="display: flex; flex-direction: column; gap: 14px; font-size: 0.95rem;">
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #f3f4f6; padding-bottom: 10px;">
                        <span style="color: #6b7280;">Komoditas</span>
                        <span style="font-weight: 600; color: #111827;">{{ $pembayaran->penawaran->NamaTanaman }} ({{ $pembayaran->penawaran->Komoditas }})</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #f3f4f6; padding-bottom: 10px;">
                        <span style="color: #6b7280;">Harga Satuan</span>
                        <span style="font-weight: 600; color: #059669;">Rp{{ number_format($pembayaran->penawaran->HargaTawar, 0, ',', '.') }} <small style="color: #9ca3af; font-weight: 400;">/kg</small></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #f3f4f6; padding-bottom: 10px;">
                        <span style="color: #6b7280;">Volume Order</span>
                        <span style="font-weight: 600; color: #111827;">{{ number_format($pembayaran->penawaran->JumlahTawar, 0, ',', '.') }} Kg</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding-bottom: 4px;">
                        <span style="color: #6b7280;">Mitra Petani</span>
                        <span style="font-weight: 600; color: #111827;">{{ $pembayaran->penawaran->petani->petaniProfile->NamaLengkap ?? $pembayaran->penawaran->petani->username }}</span>
                    </div>
                </div>
            </div>

            {{-- METODE TRANSFER --}}
            <div style="margin-bottom: 40px;">
                <p style="margin: 0 0 16px 0; font-size: 0.85rem; font-weight: 700; color: #064e3b; letter-spacing: 0.5px; text-transform: uppercase;">Tujuan Rekening</p>
                <div style="background: #f0fdf4; border: 1px solid #dcfce7; border-radius: 16px; padding: 20px; display: flex; align-items: center; gap: 16px;">
                    {{-- IKON 2: Metode Pembayaran --}}
                    <div style="color: #059669; font-size: 1.3rem; background: #ffffff; width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.02); border: 1px solid #e8f5e9;">
                        <i class="fas fa-university"></i>
                    </div>
                    <div>
                        <p style="margin: 0 0 2px 0; font-size: 0.75rem; color: #059669; font-weight: 700; letter-spacing: 0.5px;">BANK MANDIRI</p>
                        <p style="margin: 0 0 4px 0; font-size: 1.3rem; font-weight: 800; color: #111827; letter-spacing: 0.5px;">123-00-999-888-77</p>
                        <p style="margin: 0; font-size: 0.85rem; color: #6b7280; font-weight: 500;">a.n. PT TaniHub Nusantara</p>
                    </div>
                </div>
            </div>

            {{-- FORM UPLOAD DENGAN DESIGN MINIMALIS --}}
            <div>
                <form action="{{ route('pembayaran.upload', $pembayaran->idPembayaran) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div style="margin-bottom: 30px;">
                        <label style="display: block; width: 100%; padding: 28px 20px; border: 2px dashed #e5e7eb; border-radius: 16px; background: #fafafa; text-align: center; cursor: pointer; transition: all 0.2s; box-sizing: border-box;" onmouseover="this.style.borderColor='#059669'; this.style.background='#f0fdf4';" onmouseout="this.style.borderColor='#e5e7eb'; this.style.background='#fafafa';">
                            {{-- IKON 3: Aksi Upload --}}
                            <i class="fas fa-arrow-up" style="font-size: 1.1rem; color: #059669; background: #ffffff; width: 36px; height: 36px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.04);"></i>
                            <div style="font-size: 0.9rem; color: #111827; font-weight: 600; margin-bottom: 2px;">Unggah Bukti Transfer</div>
                            <div style="font-size: 0.75rem; color: #9ca3af;">Format berkas: Gambar (JPG, PNG) atau PDF</div>
                            
                            <input type="file" name="BuktiTransfer" required style="display: none;" onchange="document.getElementById('fileName').textContent = '✓ ' + this.files[0].name; document.getElementById('fileName').style.color='#059669'">
                            <div id="fileName" style="margin-top: 10px; font-size: 0.85rem; color: #6b7280; font-weight: 600;"></div>
                        </label>
                    </div>
                    
                    {{-- AREA TOMBOL UTAMA --}}
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <button type="submit" style="flex: 2; padding: 16px; background: #064e3b; color: #ffffff; border: none; border-radius: 12px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#043224'" onmouseout="this.style.background='#064e3b'">Konfirmasi Pembayaran</button>
                        <a href="javascript:history.back()" style="flex: 1; padding: 16px; background: #f3f4f6; color: #4b5563; text-align: center; border-radius: 12px; font-weight: 600; font-size: 0.95rem; text-decoration: none; transition: 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">Batal</a>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>
@endsection