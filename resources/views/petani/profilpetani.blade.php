@extends('layouts.app')
@section('title', 'Profil Saya - TaniHarvest')

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
            {{-- TOMBOL EDIT PROFIL: Sekarang berupa Link yang mengarah ke halaman edit --}}
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
    
    {{-- KOTAK FORM PENGATURAN REKENING --}}
    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px; margin-top: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); box-sizing: border-box; width: 100%;">
        <h3 style="margin-top: 0; color: #1e293b; font-size: 1.2rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px;">
            <i class="fas fa-wallet" style="color: #2563eb;"></i> Pengaturan Rekening Pencairan
        </h3>
        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 20px;">Informasi ini bersifat rahasia dan hanya akan ditampilkan kepada pembeli pada saat proses instruksi pembayaran.</p>

        <form action="{{ route('petani.profil.rekening') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 0.9rem;">Nama Bank / E-Wallet</label>
                    <input type="text" name="NamaBank" value="{{ $profil->NamaBank ?? '' }}" required placeholder="Contoh: BCA / DANA" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 0.9rem;">Nomor Rekening</label>
                    <input type="text" name="NoRekening" value="{{ $profil->NoRekening ?? '' }}" required placeholder="Contoh: 1234567890" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 0.9rem;">Atas Nama (Pemilik Rekening)</label>
                <input type="text" name="NamaPemilik" value="{{ $profil->NamaPemilik ?? '' }}" required placeholder="Sesuai buku tabungan" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box;">
            </div>

            <div style="background: #fffbeb; border: 1px solid #fde68a; padding: 15px; border-radius: 6px; margin-bottom: 20px; box-sizing: border-box;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #92400e; font-size: 0.9rem;">Masukkan Password Akun Anda untuk Konfirmasi</label>
                <input type="password" name="password" required placeholder="Masukkan password saat ini..." style="width: 100%; padding: 10px; border: 1px solid #fcd34d; border-radius: 6px; box-sizing: border-box;">
            </div>

            <button type="submit" style="background: #2563eb; color: white; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-save"></i> Simpan Rekening
            </button>
        </form>
    </div>
    
    {{-- BARIS PALING BAWAH: Rekam Jejak Transaksi & Rating --}}
    <div style="width: 100%; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02); margin-top: 30px; box-sizing: border-box;">
        <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 15px 20px;">
            <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-chart-line" style="color: #15803d;"></i> Rekam Jejak Transaksi
            </h3>
        </div>
        
        <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem; text-align: left;">
            <tbody>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <th style="width: 40%; padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">Total Kontrak Berhasil</th>
                    <td style="padding: 14px 20px; font-weight: 600; color: #1e293b; text-align: right;">{{ $totalKontrak }} Transaksi</td>
                </tr>
                <tr style="background: #fffbeb;">
                    <th style="padding: 18px 20px; color: #92400e; font-weight: 700; font-size: 1.05rem; vertical-align: middle;">
                        Rating Kualitas Layanan & Hasil Kebun
                    </th>
                    <td style="padding: 18px 20px; text-align: right;">
                        <div style="font-size: 1.3rem; margin-bottom: 5px; font-weight: 700; color: #b45309;">
                            <span style="margin-right: 10px;">{{ number_format($rataRataRating, 1) }} / 5.0</span>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= round($rataRataRating) ? 'fas' : 'far' }} fa-star" style="color: #fbbf24;"></i>
                            @endfor
                        </div>
                        <div style="margin-top: 4px;">
                            <a href="{{ route('petani.ulasan') }}" style="display: inline-block; background: #b45309; color: white; padding: 6px 14px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: 0.2s;">
                                <i class="fas fa-eye"></i> Lihat {{ $totalUlasan }} Ulasan Pembeli
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection