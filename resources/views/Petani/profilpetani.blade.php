@extends('layouts.app')

@section('title', 'Profil Saya - TaniHarvest')

@section('content')
<div class="container" style="padding: 30px; max-width: 1100px; margin: 0 auto; font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif; color: #334155;">
    
    {{-- Header Section --}}
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h1 style="margin: 0; font-size: 1.6rem; font-weight: 700; color: #1e293b; letter-spacing: -0.3px;">Profil Petani - {{ $profil->NamaKebun ?? $profil->NamaLengkap ?? $user->name }}</h1>
            <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.9rem;">Kelola informasi identitas kebun, kontak, dan hasil panen Anda.</p>
        </div>
        <div>
            <button id="btn-edit-profile" style="display: inline-flex; align-items: center; gap: 8px; background: #15803d; color: white; padding: 10px 18px; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; font-size: 0.9rem; transition: background 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <i class="fas fa-edit" style="font-size: 0.85rem;"></i> Edit Profil
            </button>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 14px 20px; border-radius: 6px; margin-bottom: 25px; font-size: 0.95rem; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-check-circle" style="color: #15803d;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- BARIS ATAS: Foto Profil & Informasi Detail --}}
    <div style="display: flex; gap: 30px; flex-wrap: wrap; margin-bottom: 30px;">
        
        {{-- KOLOM KIRI: Foto & Status Keamanan --}}
        <div style="flex: 1; min-width: 280px; max-width: 320px; display: flex; flex-direction: column; gap: 25px;">
            
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                <div style="margin-bottom: 15px; display: flex; justify-content: center;">
                    @if(!empty($profil->FotoProfile))
                        <img src="{{ asset('storage/' . $profil->FotoProfile) }}" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 1px solid #cbd5e1; padding: 4px; background: #fff;">
                    @else
                        <div style="width: 150px; height: 150px; border-radius: 50%; background: #15803d; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: bold; margin: 0 auto; border: 1px solid #cbd5e1;">
                            {{ strtoupper(substr($profil->NamaLengkap ?? $user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>
                
                <div style="font-weight: 700; color: #1e293b; font-size: 1.1rem; line-height: 1.3; margin-bottom: 6px;">
                    {{ $profil->NamaKebun ?? $profil->NamaLengkap ?? $user->username }}
                </div>
                <div style="font-size: 0.85rem; color: #64748b; font-weight: 500; margin-bottom: 12px;">
                    ID Sistem: <span style="font-family: monospace; font-weight: 600; color: #334155;">#{{ str_pad($user->id ?? 1, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; padding: 6px; border-radius: 4px; font-size: 0.8rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;">
                    Hak Akses: Petani
                </div>
            </div>

            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                <h4 style="margin: 0 0 12px 0; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">Status</h4>
                <div style="display: flex; flex-direction: column; gap: 10px; font-size: 0.9rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #64748b;">Verifikasi ID</span>
                        <span style="color: #166534; font-weight: 600;"><i class="fas fa-check-shield"></i> Aktif</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #64748b;">Tipe Akun</span>
                        <span style="color: #334155; font-weight: 600;">Mitra Penjual</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: Informasi Identitas, Kontak & Lokasi --}}
        <div style="flex: 2; min-width: 450px; display: flex; flex-direction: column; gap: 25px;">
            
            {{-- Bagian 1: Identitas Kebun --}}
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 15px 20px;">
                    <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-id-card" style="color: #15803d;"></i> Informasi Profil
                    </h3>
                </div>
                
                <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem; text-align: left;">
                    <tbody>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <th style="padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">Nama Lengkap</th>
                            <td style="padding: 14px 20px; color: #334155;">{{ $profil->NamaLengkap ?? 'Belum diatur' }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <th style="padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">Username</th>
                            <td style="padding: 14px 20px; color: #334155; font-family: monospace; font-size: 1rem;">{{ $user->username ?? 'Belum diatur' }}</td>
                        </tr>
                        <tr>
                            <th style="padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">Bio / Deskripsi</th>
                            <td style="padding: 14px 20px; color: #334155; line-height: 1.5; font-size: 0.9rem;">
                                {{ $profil->Bio ?? 'Belum ada deskripsi.' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Bagian 2: Kontak & Lokasi --}}
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 15px 20px;">
                    <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-map-marker-alt" style="color: #15803d;"></i> Kontak Resmi
                    </h3>
                </div>
                
                <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem; text-align: left;">
                    <tbody>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <th style="width: 30%; padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">Alamat Surel  (Email)</th>
                            <td style="padding: 14px 20px; color: #334155;">{{ $user->email ?? 'Email tidak ditemukan' }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <th style="padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">No. Telepon / WhatsApp</th>
                            <td style="padding: 14px 20px; color: #334155; font-weight: 500;">{{ $profil->NoTlp ?? 'Belum diatur' }}</td>
                        </tr>
                        <tr>
                            <th style="padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">Alamat</th>
                            <td style="padding: 14px 20px; color: #334155; line-height: 1.5; font-size: 0.9rem;">
                                <div style="background: #f8fafc; padding: 10px; border-radius: 4px; border: 1px solid #e2e8f0;">
                                    {!! nl2br(e($profil->Alamat ?? 'Belum diatur')) !!}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- BARIS PALING BAWAH: Rekam Jejak Transaksi & Rating (MEMBENTANG FULL DARI UJUNG KE UJUNG) --}}
    <div style="width: 100%; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 15px 20px;">
            <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-chart-line" style="color: #15803d;"></i> Rekam Jejak Transaksi
            </h3>
        </div>
        
        <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem; text-align: left;">
            <tbody>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <th style="width: 40%; padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">Total Kontrak Berhasil</th>
                    <td style="padding: 14px 20px; font-weight: 600; color: #1e293b; text-align: right;">0</td>
                </tr>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <th style="padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">Estimasi Panen keseluruhan</th>
                    <td style="padding: 14px 20px; font-weight: 600; color: #1e293b; text-align: right;">0 Kg</td>
                </tr>
                {{-- RATING DI BAGIAN TERBAWAH DAN FULL-WIDTH --}}
                <tr style="background: #fffbeb;">
                    <th style="padding: 18px 20px; color: #92400e; font-weight: 700; font-size: 1.05rem;">Rating Kualitas Layanan & Hasil Kebun</th>
                    <td style="padding: 18px 20px; font-weight: 700; color: #b45309; text-align: right; font-size: 1.2rem;">
                        <i class="fas fa-star" style="color: #fbbf24; margin-right: 6px;"></i> 0.0 / 5.0
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection