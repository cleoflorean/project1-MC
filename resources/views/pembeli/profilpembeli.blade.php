@extends('Layouts.app22')

@section('content')
<div class="container" style="padding: 30px; max-width: 1000px; margin: 0 auto; font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif; color: #334155;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; margin-bottom: 30px;">
        <div>
            <h1 style="margin: 0; font-size: 1.6rem; font-weight: 700; color: #1e293b; letter-spacing: -0.3px;">Manajemen Akun Pembeli</h1>
            <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.9rem;">Informasi legalitas identitas, kontak logistik, dan kredensial keamanan pengguna sistem.</p>
        </div>
        <div>
            <a href="{{ route('profil.edit') }}" style="display: inline-flex; align-items: center; gap: 8px; background: #15803d; color: white; padding: 10px 18px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: background 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <i class="fas fa-edit" style="font-size: 0.85rem;"></i> Perbarui Profil & Sandi
            </a>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 14px 20px; border-radius: 6px; margin-bottom: 25px; font-size: 0.95rem; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-check-circle" style="color: #15803d;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div style="display: flex; gap: 30px; flex-wrap: wrap;">
        
        <div style="flex: 1; min-width: 280px; max-width: 320px; display: flex; flex-direction: column; gap: 25px;">
            
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                <div style="margin-bottom: 15px; display: flex; justify-content: center;">
                    @if($profil && $profil->FotoProfile)
                        <img src="{{ asset($profil->FotoProfile) }}" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 1px solid #cbd5e1; padding: 4px; background: #fff;">
                    @else
                        {{-- TAMPILAN FOTO DEFAULT ALA WHATSAPP --}}
                        <div style="width: 150px; height: 150px; border-radius: 50%; background: #cbd5e1; display: flex; align-items: flex-end; justify-content: center; overflow: hidden; border: 3px solid #f8fafc; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#ffffff" style="width: 130px; height: 130px; margin-bottom: -10px;">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <div style="font-weight: 700; color: #1e293b; font-size: 1.1rem; line-height: 1.3; margin-bottom: 6px;">
                    {{ $profil->NamaLengkap ?? $user->username }}
                </div>
                <div style="font-size: 0.85rem; color: #64748b; font-weight: 500; margin-bottom: 12px;">
                    ID Sistem: <span style="font-family: monospace; font-weight: 600; color: #334155;">#{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                
                <div style="background: #f1f5f9; border: 1px solid #e2e8f0; color: #334155; padding: 6px; border-radius: 4px; font-size: 0.8rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;">
                    Hak Akses: {{ $user->role }}
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
                        <span style="color: #334155; font-weight: 600;">Mitra Pembeli</span>
                    </div>
                </div>
            </div>
        </div>

        <div style="flex: 2; min-width: 450px; display: flex; flex-direction: column; gap: 25px;">
            
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 15px 20px;">
                    <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-id-card" style="color: #15803d;"></i> Informasi Profil
                    </h3>
                </div>
                
                <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem; text-align: left;">
                    <tbody>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <th style="width: 30%; padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">Nama Lengkap </th>
                            <td style="padding: 14px 20px; font-weight: 600; color: #1e293b;">{{ $profil->NamaLengkap ?? '-' }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <th style="padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">Username </th>
                            <td style="padding: 14px 20px; color: #334155; font-family: monospace; font-size: 1rem;">{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th style="padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">Deskripsi / Bio</th>
                            <td style="padding: 14px 20px; color: #334155; line-height: 1.5; font-size: 0.9rem;">
                                {{ $profil->Bio ?? 'Tidak ada keterangan tambahan.' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

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
                            <td style="padding: 14px 20px; color: #334155;">{{ $user->email }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <th style="padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">No. Telepon / WhatsApp</th>
                            <td style="padding: 14px 20px; color: #334155; font-weight: 500;">{{ $profil->NoTlp ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="padding: 14px 20px; color: #64748b; font-weight: 500; background: #fafafa;">Alamat</th>
                            <td style="padding: 14px 20px; color: #334155; line-height: 1.5; font-size: 0.9rem;">
                                <div style="background: #f8fafc; padding: 10px; border-radius: 4px; border: 1px solid #e2e8f0;">
                                    {{ $profil->Alamat ?? 'Alamat pengiriman belum diatur di dalam sistem.' }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection