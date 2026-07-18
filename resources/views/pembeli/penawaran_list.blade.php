@extends('layouts.app22')
@section('title', 'Evaluasi Penawaran Masuk')

@section('content')

<div style="padding: 30px; max-width: 1000px; margin: 0 auto; font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif; color: #334155;">
    
    <!-- HEADER -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 30px;">
        <div>
            <h1 style="margin: 0; font-size: 1.75rem; font-weight: 800; color: #0f172a; letter-spacing: -0.5px;">Evaluasi Penawaran Masuk</h1>
            <p style="margin: 6px 0 0 0; color: #64748b; font-size: 0.95rem;">
                Permintaan: <span style="background: #dcfce7; color: #16a34a; padding: 2px 8px; border-radius: 4px; font-weight: 700; font-size: 0.85rem; margin-left: 4px;">{{ $permintaan->NamaTanaman }}</span>
            </p>
        </div>
        <div>
            <a href="javascript:history.back()" 
               style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 0.2s ease; text-decoration: none; background: #ffffff; color: #475569; border: 1px solid #cbd5e1;"
               onmouseover="this.style.background='#f8fafc'; this.style.borderColor='#94a3b8'; this.style.color='#1e293b';"
               onmouseout="this.style.background='#ffffff'; this.style.borderColor='#cbd5e1'; this.style.color='#475569';">
                <i class="fas fa-arrow-left" style="font-size: 0.8rem;"></i> Kembali
            </a>
        </div>
    </div>

    <!-- ALERT SUCCESS -->
    @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

    <div style="display: flex; flex-direction: column; gap: 20px;">
        {{-- Loop semua data penawaran --}}
        @forelse($penawarans as $tawar)
            
            {{-- CEK STATUS PEMBAYARAN SECARA REALTIME --}}
            @php
                $sudahUpload = \App\Models\Pembayaran::where('idTawar', $tawar->idTawar)
                                ->whereNotNull('BuktiTransfer')
                                ->exists();
            @endphp

            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.02); transition: all 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.05), 0 4px 6px -2px rgba(0,0,0,0.03)'; this.style.borderColor='#cbd5e1';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.02)'; this.style.borderColor='#e2e8f0';">
                
                <!-- BAGIAN ATAS KARTU (PROFIL & STATUS) -->
                <div style="background: #f8fafc; border-bottom: 1px solid #f1f5f9; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        
                        {{-- FOTO PROFIL PETANI --}}
                        <div style="width: 52px; height: 52px; background: #e2e8f0; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; color: #94a3b8; border: 2px solid #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); flex-shrink: 0;">
                            @if(!empty($tawar->petani->profile->FotoProfil))
                                <img src="{{ asset($tawar->petani->profile->FotoProfil) }}" alt="Foto Petani" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="fas fa-user-tie" style="font-size: 1.2rem;"></i>
                            @endif
                        </div>

                        <div>
    {{-- Container Flex agar Username dan Tombol Info Petani sejajar --}}
    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
        <h4 style="margin: 0; font-size: 1.05rem; color: #0f172a; font-weight: 700;">
            {{ $tawar->petani->username ?? 'Nama Tidak Diketahui' }}
        </h4>
        
        @if(isset($tawar->petani))
            <a href="{{ route('pembeli.petani.show', $tawar->petani->id) }}" 
               style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 12px; background: #e0f2fe; color: #0369a1; text-decoration: none; font-size: 0.75rem; font-weight: 600; border: 1px solid #bae6fd; transition: all 0.2s;"
               onmouseover="this.style.background='#0284c7'; this.style.color='#ffffff'; this.style.borderColor='#0284c7';"
               onmouseout="this.style.background='#e0f2fe'; this.style.color='#0369a1'; this.style.borderColor='#bae6fd';">
                <i class="fas fa-store" style="font-size: 0.7rem;"></i> Info Petani
            </a>
        @endif
    </div>

    {{-- Alamat tetap berada di bawahnya --}}
    <span style="font-size: 0.85rem; color: #64748b; display: flex; align-items: center; gap: 6px; margin-top: 4px;">
        <i class="fas fa-map-marker-alt" style="color: #ef4444;"></i> 
        {{ $tawar->petani->profile->Alamat ?? 'Alamat belum diatur' }}
    </span>
</div>
                    </div>

                    <!-- BADGE STATUS -->
                    <div>
                        @if($tawar->Status === 'Pending')
                            <span style="padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; background: #fef3c7; color: #d97706; border: 1px solid #fde68a;">
                                <i class="fas fa-hourglass-half" style="font-size: 0.75rem;"></i> Menunggu
                            </span>
                        @elseif($tawar->Status === 'Setuju' && $sudahUpload)
                            <span style="padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd;">
                                <i class="fas fa-receipt" style="font-size: 0.75rem;"></i> Sudah Dibayar
                            </span>
                        @elseif($tawar->Status === 'Setuju')
                            <span style="padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0;">
                                <i class="fas fa-check" style="font-size: 0.75rem;"></i> Disetujui
                            </span>
                        @else
                            <span style="padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; background: #fee2e2; color: #dc2626; border: 1px solid #fecaca;">
                                <i class="fas fa-times" style="font-size: 0.75rem;"></i> Ditolak
                            </span>
                        @endif
                    </div>
                </div>

                <!-- BAGIAN TENGAH (DETAIL HARGA & VOLUME) -->
                <div style="padding: 24px; display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 24px; align-items: center;">
                    
                    <div>
                        <span style="display: block; font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; margin-bottom: 6px;">Harga Penawaran</span>
                        <div style="font-size: 1.4rem; font-weight: 800; color: #0f172a;">
                            Rp {{ number_format($tawar->HargaTawar, 0, ',', '.') }}
                        </div>
                    </div>

                    <div>
                        <span style="display: block; font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; margin-bottom: 6px;">Volume Ketersediaan</span>
                        <div style="font-size: 1.15rem; font-weight: 700; color: #334155;">
                            {{ number_format($tawar->JumlahTawar, 0, ',', '.') }} <span style="font-size: 0.9rem; color: #64748b; font-weight: 600;">kg</span>
                        </div>
                    </div>

                    {{-- Kondisi Barang --}}
                    <div>
                        <span style="display: block; font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; margin-bottom: 6px;">Kondisi Barang</span>
                        @if(!empty($tawar->Gambar))
                            <a href="{{ route('pembeli.penawaran.foto', $tawar->idTawar) }}" 
                               style="display: inline-flex; align-items: center; gap: 8px; padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 0.8rem; cursor: pointer; transition: all 0.2s ease; text-decoration: none; background: #ffffff; color: #475569; border: 1px solid #cbd5e1;"
                               onmouseover="this.style.background='#f8fafc'; this.style.borderColor='#94a3b8'; this.style.color='#1e293b';"
                               onmouseout="this.style.background='#ffffff'; this.style.borderColor='#cbd5e1'; this.style.color='#475569';">
                                Lihat Detail
                            </a>
                        @else
                            <span style="font-size: 0.9rem; color: #94a3b8; font-style: italic;">Tidak ada foto</span>
                        @endif
                    </div>

                    {{-- TOMBOL TERIMA/TOLAK HANYA MUNCUL JIKA STATUS PENDING --}}
                    @if($tawar->Status === 'Pending')
                    <div style="display: flex; gap: 10px; justify-content: flex-end; border-left: 1px dashed #e2e8f0; padding-left: 24px;">
                        <form action="{{ route('pembeli.penawaran.update-status', $tawar->idTawar) }}" method="POST" style="margin: 0;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="Setuju">
                            <button type="submit" 
                                    style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 0.2s ease; border: none; background: #16a34a; color: white; box-shadow: 0 2px 4px rgba(22, 163, 74, 0.2);"
                                    onmouseover="this.style.background='#15803d'; this.style.boxShadow='0 4px 6px rgba(22, 163, 74, 0.3)';"
                                    onmouseout="this.style.background='#16a34a'; this.style.boxShadow='0 2px 4px rgba(22, 163, 74, 0.2)';">
                                <i class="fas fa-check-circle"></i> Terima
                            </button>
                        </form>

                        <form action="{{ route('pembeli.penawaran.update-status', $tawar->idTawar) }}" method="POST" style="margin: 0;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="Tidak Setuju">
                            <button type="submit" 
                                    style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 0.2s ease; border: 1px solid #fca5a5; background: #ffffff; color: #ef4444;"
                                    onmouseover="this.style.background='#fef2f2'; this.style.borderColor='#ef4444';"
                                    onmouseout="this.style.background='#ffffff'; this.style.borderColor='#fca5a5';">
                                <i class="fas fa-times-circle"></i> Tolak
                            </button>
                        </form>
                    </div>
                    @endif
                </div>

                <!-- AREA BAWAH (CALL TO ACTION SETUJU) -->
                @if($tawar->Status === 'Setuju')
                <div style="border-top: 1px dashed #e2e8f0; padding: 16px 24px; background: #fafaf9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                    
                    @if($sudahUpload)
                        <div style="color: #0369a1; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-info-circle" style="color: #0ea5e9; font-size: 1.1rem;"></i> 
                            <span>Bukti pembayaran telah diunggah. Silakan cek perkembangan status pesanan Anda di halaman <strong style="color: #0f172a;">Riwayat Transaksi</strong>.</span>
                        </div>
                    @else
                        <div style="color: #475569; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-info-circle" style="color: #64748b; font-size: 1.1rem;"></i> 
                            Silakan selesaikan pembayaran untuk penawaran ini.
                        </div>
                        <div style="display: flex; gap: 12px;">
                            @php
                                $noWa = $tawar->petani->profile->NoWhatsApp ?? null;
                                if($noWa && substr($noWa, 0, 1) == '0') {
                                    $noWa = '62' . substr($noWa, 1);
                                }
                                $pesanWa = "Halo, saya pembeli komoditas " . ($tawar->permintaan->Komoditas ?? $tawar->permintaan->NamaTanaman) . ". Penawaran Anda telah saya setujui. Mari berdiskusi mengenai teknis pengiriman.";
                            @endphp

                            @if($noWa)
                                <a href="https://wa.me/{{ $noWa }}?text={{ urlencode($pesanWa) }}" target="_blank" 
                                   style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 0.2s ease; text-decoration: none; border: none; background: #25D366; color: white; box-shadow: 0 2px 4px rgba(37,211,102,0.2);"
                                   onmouseover="this.style.background='#22c35e'; this.style.boxShadow='0 4px 6px rgba(37,211,102,0.3)';"
                                   onmouseout="this.style.background='#25D366'; this.style.boxShadow='0 2px 4px rgba(37,211,102,0.2)';">
                                    <i class="fab fa-whatsapp" style="font-size: 1.1rem;"></i> Chat Petani
                                </a>
                            @endif
                            
                            <a href="{{ route('pembayaran.show', $tawar->idTawar) }}" 
                               style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 0.2s ease; text-decoration: none; border: none; background: #2563eb; color: white; box-shadow: 0 2px 4px rgba(37,99,235,0.2);"
                               onmouseover="this.style.background='#1d4ed8'; this.style.boxShadow='0 4px 6px rgba(37,99,235,0.3)';"
                               onmouseout="this.style.background='#2563eb'; this.style.boxShadow='0 2px 4px rgba(37,99,235,0.2)';">
                                <i class="fas fa-wallet"></i> Lanjutkan Pembayaran
                            </a>
                        </div>
                    @endif

                </div>
                @endif
            </div>
        @empty
            <!-- EMPTY STATE -->
            <div style="background: #ffffff; border: 2px dashed #cbd5e1; border-radius: 16px; padding: 60px 20px; text-align: center;">
                <div style="width: 72px; height: 72px; background: #f8fafc; color: #94a3b8; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 16px auto; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3 style="margin: 0 0 8px 0; font-size: 1.25rem; color: #0f172a; font-weight: 800;">Belum Ada Penawaran</h3>
                <p style="margin: 0; color: #64748b; font-size: 0.95rem;">Mitra petani belum mengirimkan penawaran harga untuk komoditas ini. Harap tunggu beberapa saat lagi.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection