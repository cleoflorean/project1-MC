@extends('layouts.app')
@section('title', 'Profil Saya - Tani Harvest')

@section('content')
{{-- Pembungkus utama disesuaikan agar bersahabat dengan layout dashboard --}}
<div class="container-fluid" style="padding: 20px; max-width: 1200px; margin: 0 auto; font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif; color: #334155; box-sizing: border-box;">
    
    {{-- Header Section --}}
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h1 style="margin: 0; font-size: 1.6rem; font-weight: 700; color: #1e293b; letter-spacing: -0.3px;">
                Profil Petani - {{ $profil->NamaKebun ?? $profil->NamaLengkap ?? $user->name }}
            </h1>
            <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.9rem;">Kelola informasi identitas kebun, kontak, dan hasil panen Anda.</p>
        </div>
        <div>
            {{-- TOMBOL EDIT PROFIL --}}
            <a href="{{ route('petani.profil.edit') }}" style="display: inline-flex; align-items: center; gap: 8px; background: #15803d; color: white; padding: 10px 18px; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; font-size: 0.9rem; text-decoration: none; transition: background 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <i class="fas fa-edit" style="font-size: 0.85rem;"></i> Perbarui Profil & Sandi
            </a>
        </div>
    </div>

    {{-- NOTIFIKASI BERHASIL --}}
    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 14px 20px; border-radius: 6px; margin-bottom: 25px; font-size: 0.95rem; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-check-circle" style="color: #15803d;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- NOTIFIKASI ERROR GAGAL PASSWORD REKENING --}}
    @if(session('error'))
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 20px; border-radius: 6px; margin-bottom: 25px; font-size: 0.95rem; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-exclamation-triangle" style="color: #dc2626;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- BARIS ATAS: Foto Profil & Informasi Detail --}}
    <div style="display: flex; gap: 30px; flex-wrap: wrap; margin-bottom: 30px; width: 100%;">
        
        {{-- KOLOM KIRI: Foto & Status Keamanan --}}
        <div style="flex: 1; min-width: 280px; max-width: 320px; display: flex; flex-direction: column; gap: 25px; box-sizing: border-box;">
            
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                <div style="margin-bottom: 15px; display: flex; justify-content: center;">
                    @if(!empty($profil->FotoProfile))
                        <img src="{{ asset($profil->FotoProfile) }}" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 1px solid #cbd5e1; padding: 4px; background: #fff;">
                    @else
                        <div style="width: 150px; height: 150px; border-radius: 50%; background: #15803d; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: bold; margin: 0 auto; border: 1px solid #cbd5e1;">
                            {{ strtoupper(substr($profil->NamaLengkap ?? $user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>
                
                <div style="font-weight: 700; color: #1e293b; font-size: 1.1rem; line-height: 1.3; margin-bottom: 6px;">
                    {{ $profil->NamaKebun ?? $profil->NamaLengkap ?? $user->username }}
                </div>  
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; padding: 6px; border-radius: 4px; font-size: 0.8rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;">
                    Hak Akses: Petani
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: Informasi Identitas, Kontak & Lokasi --}}
        <div style="flex: 2; min-width: 320px; display: flex; flex-direction: column; gap: 25px; box-sizing: border-box;">
            
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
                            <th style="padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa; width: 30%;">Nama Lengkap</th>
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
                            <th style="width: 30%; padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">Alamat Surel (Email)</th>
                            <td style="padding: 14px 20px; color: #334155;">{{ $user->email ?? 'Email tidak ditemukan' }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <th style="padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">No. Telepon / WhatsApp</th>
                            <td style="padding: 14px 20px; color: #334155; font-weight: 500;">{{ $profil->NoTlp ?? 'Belum diatur' }}</td>
                        </tr>
                        <tr>
                            <th style="padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">Alamat</th>
                            <td style="padding: 14px 20px; color: #334155; line-height: 1.5; font-size: 0.9rem;">
                                <div style="background: #f8fafc; padding: 10px; border-radius: 4px; border: 1px solid #e2e8f0; box-sizing: border-box;">
                                    {!! nl2br(e($profil->Alamat ?? 'Belum diatur')) !!}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    
    {{-- KOTAK FORM PENGATURAN REKENING (Tampilan Baru) --}}
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02); margin-top: 30px; width: 100%;">
        <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 15px 20px;">
            <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-wallet" style="color: #15803d;"></i> Pengaturan Rekening Pencairan
            </h3>
        </div>
        
        <div style="padding: 25px;">
            <p style="color: #64748b; font-size: 0.9rem; margin-top: 0; margin-bottom: 25px;">
                <i class="fas fa-info-circle" style="color: #94a3b8; margin-right: 4px;"></i> Informasi ini bersifat rahasia dan hanya ditampilkan kepada pembeli saat instruksi pembayaran.
            </p>

            <form action="{{ route('petani.profil.rekening') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-weight: 600; color: #334155; margin-bottom: 8px; font-size: 0.9rem;">Nama Bank / E-Wallet</label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"><i class="fas fa-university"></i></span>
                            <input type="text" name="NamaBank" value="{{ $profil->NamaBank ?? '' }}" required placeholder="Contoh: BCA / DANA" style="width: 100%; padding: 10px 10px 10px 40px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-size: 0.95rem; color: #1e293b;">
                        </div>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; color: #334155; margin-bottom: 8px; font-size: 0.9rem;">Nomor Rekening / E-Wallet</label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"><i class="fas fa-hashtag"></i></span>
                            <input type="text" name="NoRekening" value="{{ $profil->NoRekening ?? '' }}" required placeholder="Contoh: 1234567890" style="width: 100%; padding: 10px 10px 10px 40px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-size: 0.95rem; color: #1e293b;">
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; color: #334155; margin-bottom: 8px; font-size: 0.9rem;">Atas Nama (Pemilik Rekening)</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"><i class="fas fa-user-circle"></i></span>
                        <input type="text" name="NamaPemilik" value="{{ $profil->NamaPemilik ?? '' }}" required placeholder="Sesuai buku tabungan / akun e-wallet" style="width: 100%; padding: 10px 10px 10px 40px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-size: 0.95rem; color: #1e293b;">
                    </div>
                </div>

                <div style="background: #f8fafc; border: 1px dashed #cbd5e1; padding: 20px; border-radius: 8px; margin-bottom: 25px; box-sizing: border-box;">
                    <label style="display: block; font-weight: 600; color: #334155; margin-bottom: 6px; font-size: 0.95rem;">
                        <i class="fas fa-shield-alt" style="color: #64748b; margin-right: 5px;"></i> Konfirmasi Keamanan
                    </label>
                    <p style="font-size: 0.85rem; color: #64748b; margin-top: 0; margin-bottom: 12px;">Untuk menyimpan perubahan rekening, mohon masukkan password akun Anda.</p>
                    <div style="position: relative; max-width: 400px;">
                        <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" required placeholder="Masukkan password saat ini..." style="width: 100%; padding: 10px 10px 10px 40px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-size: 0.95rem;">
                    </div>
                </div>

                <button type="submit" style="background: #15803d; color: white; padding: 10px 24px; border: none; border-radius: 6px; font-weight: 600; font-size: 0.95rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s;">
                    <i class="fas fa-save"></i> Simpan Rekening
                </button>
            </form>
        </div>
    </div>
    
    {{-- BARIS PALING BAWAH: Rekam Jejak Transaksi & Rating (Tampilan Baru) --}}
    <div style="width: 100%; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02); margin-top: 30px; margin-bottom: 40px; box-sizing: border-box;">
        <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 15px 20px;">
            <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-chart-line" style="color: #15803d;"></i> Rekam Jejak Kinerja & Penilaian
            </h3>
        </div>
        
        <div style="display: flex; flex-wrap: wrap; padding: 25px; gap: 25px;">
            
            {{-- Statistik Box 1: Transaksi --}}
            <div style="flex: 1; min-width: 250px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; display: flex; align-items: center; gap: 18px;">
                <div style="width: 55px; height: 55px; background: #e0f2fe; color: #0284c7; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 1.5rem; flex-shrink: 0;">
                    <i class="fas fa-handshake"></i>
                </div>
                <div>
                    <div style="font-size: 0.9rem; color: #64748b; font-weight: 600; margin-bottom: 4px;">Total Pesanan Selesai</div>
                    <div style="font-size: 1.6rem; font-weight: 700; color: #1e293b;">
                        {{ $totalKontrak }} <span style="font-size: 0.95rem; font-weight: 500; color: #64748b;">Transaksi</span>
                    </div>
                </div>
            </div>

            {{-- Statistik Box 2: Rating Ulasan --}}
            <div style="flex: 1; min-width: 300px; background: #fefce8; border: 1px solid #fef08a; border-radius: 8px; padding: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <div style="display: flex; align-items: center; gap: 18px;">
                    <div style="width: 55px; height: 55px; background: #fef9c3; color: #ca8a04; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 1.5rem; flex-shrink: 0;">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.9rem; color: #64748b; font-weight: 600; margin-bottom: 4px;">Rating Kepuasan Pembeli</div>
                        <div style="display: flex; align-items: baseline; gap: 10px;">
                            <span style="font-size: 1.6rem; font-weight: 700; color: #1e293b;">{{ number_format($rataRataRating, 1) }}</span>
                            <span style="font-size: 1rem; color: #fbbf24;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= round($rataRataRating) ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </span>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="{{ route('petani.ulasan') }}" style="display: inline-flex; align-items: center; gap: 6px; background: white; color: #15803d; border: 1px solid #15803d; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: 0.2s;">
                        Lihat Ulasan ({{ $totalUlasan }}) <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                    </a>
                </div>
            </div>
            
        </div>
    </div>

</div>
@endsection