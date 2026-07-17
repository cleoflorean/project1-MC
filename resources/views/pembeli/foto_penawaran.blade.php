@extends('layouts.app22')
@section('title', 'Detail Foto Kondisi Barang')

@section('content')
<div class="container" style="padding: 30px; max-width: 850px; margin: 0 auto; font-family: 'Inter', 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif; color: #334155;">
    
    <!-- HEADER -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; margin-bottom: 30px;">
        <div>
            <h1 style="margin: 0; font-size: 1.5rem; font-weight: 800; color: #0f172a; letter-spacing: -0.5px;">Foto Kondisi Barang</h1>
            <p style="margin: 6px 0 0 0; color: #64748b; font-size: 0.95rem;">
                Komoditas: <span style="background: #dcfce7; color: #16a34a; padding: 2px 8px; border-radius: 4px; font-weight: 700; font-size: 0.85rem; margin-left: 4px;">{{ $tawar->Komoditas ?? $tawar->NamaTanaman }}</span>
            </p>
        </div>
        <div>
            <a href="javascript:history.back()" 
               style="display: inline-flex; align-items: center; gap: 8px; background: #ffffff; color: #475569; border: 1px solid #cbd5e1; padding: 10px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.85rem; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.02);"
               onmouseover="this.style.background='#f8fafc'; this.style.borderColor='#94a3b8'; this.style.color='#1e293b';"
               onmouseout="this.style.background='#ffffff'; this.style.borderColor='#cbd5e1'; this.style.color='#475569';">
                <i class="fas fa-arrow-left" style="font-size: 0.8rem;"></i> Kembali
            </a>
        </div>
    </div>

    <!-- MAIN CARD -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);">
        
        <!-- BAGIAN FOTO -->
        <div style="background: #f8fafc; padding: 30px; text-align: center; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: center; align-items: center; min-height: 300px;">
            @if($tawar->Gambar)
                <img src="{{ asset($tawar->Gambar) }}" alt="Foto Barang" style="max-width: 100%; max-height: 400px; object-fit: contain; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            @else
                <div style="color: #94a3b8; text-align: center;">
                    <i class="fas fa-image" style="font-size: 4rem; margin-bottom: 15px; color: #cbd5e1;"></i>
                    <p style="margin: 0; font-weight: 500; font-size: 1.1rem;">Foto barang tidak tersedia</p>
                </div>
            @endif
        </div>

        <!-- BAGIAN INFORMASI -->
        <div style="padding: 30px;">
            <h3 style="margin: 0 0 20px 0; font-size: 1.1rem; color: #0f172a; border-bottom: 2px dashed #e2e8f0; padding-bottom: 12px; font-weight: 700;">
                <i class="fas fa-info-circle" style="color: #3b82f6; margin-right: 6px;"></i> Detail Penawaran
            </h3>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                
                <!-- Petani Pengirim -->
                <div>
                    <span style="display: block; font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 4px;">Petani Pengirim</span>
                    <div style="font-size: 1.05rem; font-weight: 700; color: #0f172a;">
                        {{ $tawar->petani->petaniProfile->NamaLengkap ?? 'Nama Tidak Diketahui' }} 
                    </div>
                    <div style="font-size: 0.85rem; color: #94a3b8; margin-top: 2px;">
                        Username: {{ $tawar->petani->username ?? 'Mitra Petani' }}
                    </div>
                </div>

                <!-- Harga Penawaran -->
                <div>
                    <span style="display: block; font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 4px;">Harga Penawaran</span>
                    <div style="font-size: 1.2rem; font-weight: 800; color: #16a34a;">
                        Rp {{ number_format($tawar->HargaTawar, 0, ',', '.') }} 
                        <span style="font-size: 0.85rem; font-weight: 600; color: #64748b;">/kg</span>
                    </div>
                </div>

                <!-- Volume -->
                <div>
                    <span style="display: block; font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 4px;">Volume Tersedia</span>
                    <div style="font-size: 1.1rem; font-weight: 700; color: #0f172a;">
                        {{ number_format($tawar->JumlahTawar, 0, ',', '.') }} 
                        <span style="font-size: 0.85rem; font-weight: 600; color: #64748b;">kg</span>
                    </div>
                </div>

                <!-- Alamat Lengkap (Mengambil full width) -->
                <div style="grid-column: 1 / -1; background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #f1f5f9; margin-top: 5px;">
                    <span style="display: block; font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 6px;">Alamat Lengkap</span>
                    <div style="font-size: 0.95rem; font-weight: 500; color: #334155; display: flex; align-items: flex-start; gap: 8px; line-height: 1.5;">
                        <i class="fas fa-map-marker-alt" style="color: #ef4444; margin-top: 4px;"></i>
                        <span>{{ $tawar->petani->petaniProfile->Alamat ?? 'Alamat tidak tersedia. Silakan hubungi petani untuk detail lokasi.' }}</span>
                    </div>
                </div>

                <div style="grid-column: 1 / -1; background: #fffbeb; padding: 15px; border-radius: 8px; border: 1px solid #fef3c7;">
                    <span style="display: block; font-size: 0.75rem; color: #d97706; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 6px;">Catatan dari Petani</span>
                    <div style="font-size: 0.95rem; font-weight: 500; color: #78350f; display: flex; align-items: flex-start; gap: 8px; line-height: 1.5; font-style: italic;">
                        <i class="fas fa-comment-dots" style="color: #f59e0b; margin-top: 4px;"></i>
                        <span>"{{ $tawar->Catatan ?? 'Tidak Ada Catatan dari Petani.' }}"</span>
                    </div>
                </div>

            </div>

            <!-- PERSIAPAN LINK WHATSAPP -->
            @php
                $noWa = $tawar->petani->petaniProfile->NoTlp ?? null;
                // Ubah format 08xx menjadi 628xx
                if($noWa && substr($noWa, 0, 1) == '0') {
                    $noWa = '62' . substr($noWa, 1);
                }
                
                $namaKomoditas = $tawar->Komoditas ?? $tawar->NamaTanaman ?? 'komoditas';
                $pesanWa = "Halo, saya melihat foto barang untuk penawaran " . $namaKomoditas . " Anda di sistem. Boleh saya berdiskusi lebih lanjut mengenai kondisinya?";
            @endphp

            <!-- TOMBOL AKSI BAWAH -->
            <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 15px;">
                @if($noWa)
                    <a href="https://wa.me/{{ $noWa }}?text={{ urlencode($pesanWa) }}" target="_blank" 
                       style="display: inline-flex; align-items: center; gap: 8px; background: #25D366; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: all 0.2s; box-shadow: 0 4px 6px rgba(37,211,102,0.2);"
                       onmouseover="this.style.background='#22c35e'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(37,211,102,0.3)';"
                       onmouseout="this.style.background='#25D366'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(37,211,102,0.2)';">
                        <i class="fab fa-whatsapp" style="font-size: 1.2rem;"></i> Chat Petani via WA
                    </a>
                @else
                    <button disabled style="display: inline-flex; align-items: center; gap: 8px; background: #e2e8f0; color: #94a3b8; padding: 12px 24px; border-radius: 8px; border: none; font-weight: 600; font-size: 0.95rem; cursor: not-allowed;">
                        <i class="fab fa-whatsapp" style="font-size: 1.2rem;"></i> Nomor WA Tidak Tersedia
                    </button>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection