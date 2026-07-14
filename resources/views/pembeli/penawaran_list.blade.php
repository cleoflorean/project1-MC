@extends('layouts.app22')
@section('title', 'Evaluasi Penawaran Masuk')

@section('content')
<div class="container" style="padding: 30px; max-width: 1000px; margin: 0 auto; font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif; color: #334155;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; margin-bottom: 30px;">
        <div>
            <h1 style="margin: 0; font-size: 1.5rem; font-weight: 700; color: #1e293b; letter-spacing: -0.3px;">Evaluasi Penawaran Masuk</h1>
            <p style="margin: 6px 0 0 0; color: #64748b; font-size: 0.95rem;">
                Permintaan Komoditas: <span style="font-weight: 600; color: #15803d;">{{ $permintaan->NamaTanaman }}</span>
            </p>
        </div>
        <div>
            <a href="javascript:history.back()" style="display: inline-flex; align-items: center; gap: 8px; background: #ffffff; color: #475569; border: 1px solid #cbd5e1; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.85rem; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
                <i class="fas fa-arrow-left" style="font-size: 0.8rem;"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 14px 20px; border-radius: 6px; margin-bottom: 25px; font-size: 0.95rem; display: flex; align-items: center; gap: 10px; font-weight: 600;">
            <i class="fas fa-check-circle" style="color: #15803d; font-size: 1.1rem;"></i>
            <span>{{ session('success') }}</span>
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

            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: border-color 0.2s;">
                
                <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        
                        {{-- FOTO PROFIL PETANI --}}
                        <div style="width: 48px; height: 48px; background: #e2e8f0; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; color: #64748b; border: 2px solid #cbd5e1; flex-shrink: 0;">
                            @if(!empty($tawar->petani->petaniProfile->FotoProfile))
                                <img src="{{ asset($tawar->petani->petaniProfile->FotoProfile) }}" alt="Foto Petani" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="fas fa-tractor" style="font-size: 1.2rem;"></i>
                            @endif
                        </div>

                        <div>
                            <h4 style="margin: 0; font-size: 1rem; color: #1e293b; font-weight: 700;">
                                {{ $tawar->petani->petaniProfile->NamaLengkap ?? 'Nama Tidak Diketahui' }}
                                <span style="font-size: 0.85rem; font-weight: normal; color: #64748b;">({{ $tawar->petani->username ?? 'Mitra Petani' }})</span>
                            </h4>
                            <span style="font-size: 0.8rem; color: #64748b; display: flex; align-items: center; gap: 5px; margin-top: 3px;">
                                <i class="fas fa-map-marker-alt" style="color: #ef4444;"></i> 
                                {{ $tawar->petani->petaniProfile->Alamat ?? 'Alamat belum diatur' }}
                            </span>
                        </div>
                    </div>

                    <div>
                        @if($tawar->Status === 'Pending')
                            <span style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fas fa-clock" style="font-size: 0.75rem;"></i> Menunggu Evaluasi
                            </span>
                        @elseif($tawar->Status === 'Setuju' && $sudahUpload)
                            <span style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fas fa-receipt" style="font-size: 0.75rem;"></i> Sudah Dibayar
                            </span>
                        @elseif($tawar->Status === 'Setuju')
                            <span style="background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fas fa-check" style="font-size: 0.75rem;"></i> Disetujui
                            </span>
                        @else
                            <span style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fas fa-times" style="font-size: 0.75rem;"></i> Ditolak
                            </span>
                        @endif
                    </div>
                </div>

                <div style="padding: 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px; align-items: center;">
                    
                    <div>
                        <span style="display: block; font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Harga Penawaran</span>
                        <div style="font-size: 1.25rem; font-weight: 700; color: #1e293b;">
                            Rp {{ number_format($tawar->HargaTawar, 0, ',', '.') }}
                        </div>
                    </div>

                    <div>
                        <span style="display: block; font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Volume Ketersediaan</span>
                        <div style="font-size: 1.1rem; font-weight: 600; color: #334155;">
                            {{ number_format($tawar->JumlahTawar, 0, ',', '.') }} <span style="font-size: 0.9rem; color: #64748b;">kg</span>
                        </div>
                    </div>

                    {{-- Kondisi Barang --}}
                    <div>
                        <span style="display: block; font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Kondisi Barang</span>
                        @if(!empty($tawar->Gambar))
                            <a href="{{ route('pembeli.penawaran.foto', $tawar->idTawar) }}" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s; text-decoration: none;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                                <i class="fas fa-image" style="color: #3b82f6;"></i> Lihat Foto
                            </a>
                        @else
                            <span style="font-size: 0.85rem; color: #94a3b8; font-style: italic;">Tidak ada foto</span>
                        @endif
                    </div>

                    {{-- TOMBOL TERIMA/TOLAK HANYA MUNCUL JIKA STATUS PENDING --}}
                    @if($tawar->Status === 'Pending')
                    <div style="display: flex; gap: 10px; justify-content: flex-end; border-left: 1px solid #e2e8f0; padding-left: 20px;">
                        <form action="{{ route('pembeli.penawaran.update-status', $tawar->idTawar) }}" method="POST" style="margin: 0;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="Setuju">
                            <button type="submit" style="background: #15803d; color: white; border: none; padding: 10px 16px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" onmouseover="this.style.background='#166534'" onmouseout="this.style.background='#15803d'">
                                <i class="fas fa-check-circle"></i> Terima
                            </button>
                        </form>

                        <form action="{{ route('pembeli.penawaran.update-status', $tawar->idTawar) }}" method="POST" style="margin: 0;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="Tidak Setuju">
                            <button type="submit" style="background: #ffffff; color: #dc2626; border: 1px solid #fca5a5; padding: 10px 16px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='#ffffff'">
                                <i class="fas fa-times-circle"></i> Tolak
                            </button>
                        </form>
                    </div>
                    @endif
                </div>

                {{-- AREA BAWAH UNTUK STATUS SETUJU --}}
                @if($tawar->Status === 'Setuju')
                <div style="border-top: 1px dashed #e2e8f0; padding: 15px 20px; background: #f8fafc; display: flex; justify-content: space-between; align-items: center;">
                    
                    @if($sudahUpload)
                        <div style="color: #0369a1; font-size: 0.85rem; font-weight: 600;">
                            <i class="fas fa-info-circle" style="color: #38bdf8;"></i> Bukti pembayaran telah diunggah. Silakan cek perkembangan status pesanan Anda di halaman <strong>Riwayat Transaksi</strong>.
                        </div>
                    @else
                        <div style="color: #64748b; font-size: 0.85rem;">
                            <i class="fas fa-info-circle text-blue-500"></i> Silakan selesaikan pembayaran.
                        </div>
                        <div style="display: flex; gap: 10px;">
                            @php
                                $noWa = $tawar->petani->petaniProfile->NoTlp ?? null;
                                if($noWa && substr($noWa, 0, 1) == '0') {
                                    $noWa = '62' . substr($noWa, 1);
                                }
                                $pesanWa = "Halo, saya pembeli komoditas " . $tawar->Komoditas . ". Penawaran Anda telah saya setujui. Mari berdiskusi mengenai teknis pengiriman.";
                            @endphp

                            @if($noWa)
                                <a href="https://wa.me/{{ $noWa }}?text={{ urlencode($pesanWa) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; background: #25D366; color: white; padding: 10px 18px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 0.9rem; transition: 0.2s; box-shadow: 0 2px 4px rgba(37,211,102,0.2);">
                                    <i class="fab fa-whatsapp" style="font-size: 1rem;"></i> Chat Petani
                                </a>
                            @endif
                            
                            <a href="{{ route('pembayaran.show', $tawar->idTawar) }}" style="display: inline-flex; align-items: center; gap: 8px; background: #2563eb; color: white; padding: 10px 18px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 0.9rem; transition: 0.2s; box-shadow: 0 2px 4px rgba(37,99,235,0.2);">
                                <i class="fas fa-wallet"></i> Lanjutkan Pembayaran
                            </a>
                        </div>
                    @endif

                </div>
                @endif
            </div>
        @empty
            <div style="background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 50px 20px; text-align: center;">
                <div style="width: 60px; height: 60px; background: #f1f5f9; color: #94a3b8; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 15px auto;">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3 style="margin: 0 0 8px 0; font-size: 1.1rem; color: #1e293b; font-weight: 700;">Belum Ada Penawaran</h3>
                <p style="margin: 0; color: #64748b; font-size: 0.95rem;">Mitra petani belum mengirimkan penawaran harga untuk komoditas ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection