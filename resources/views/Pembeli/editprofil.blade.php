@extends('Layouts.app22')

@section('content')
<div class="container" style="padding: 30px; max-width: 1000px; margin: 0 auto; font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif; color: #334155;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; margin-bottom: 30px;">
        <div>
            <h1 style="margin: 0; font-size: 1.6rem; font-weight: 700; color: #1e293b; letter-spacing: -0.3px;">Konfigurasi Akun Pembeli</h1>
            <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.9rem;">Gerbang modifikasi data legalitas instansi, pemutakhiran kontak logistik, dan kredensial keamanan.</p>
        </div>
        <div>
            <a href="{{ route('profil') }}" style="display: inline-flex; align-items: center; gap: 8px; background: #ffffff; color: #475569; border: 1px solid #cbd5e1; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.85rem; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
                <i class="fas fa-arrow-left" style="font-size: 0.8rem;"></i> Kembali ke Profil
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; padding: 15px 20px; border-radius: 6px; margin-bottom: 30px; font-size: 0.9rem;">
            <div style="font-weight: 700; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-exclamation-triangle"></i> Terjadi Kesalahan Validasi Input:
            </div>
            <ul style="margin: 0; padding-left: 20px; line-height: 1.6;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display: flex; flex-direction: column; gap: 35px;">
        
        <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" style="margin: 0;">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="hapus_foto" id="hapus_foto_input" value="0">

            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 15px 20px;">
                    <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-user-edit" style="color: #64748b;"></i> Pemutakhiran Identitas & Data Distribusi
                    </h3>
                </div>

                <div style="padding: 30px 25px; display: flex; flex-direction: column; gap: 25px;">
                    
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 10px 0 20px 0; border-bottom: 1px dashed #e2e8f0; margin-bottom: 10px;">
                        <div style="margin-bottom: 15px; position: relative;">
                            
                            @if($profil && $profil->FotoProfile)
                                <img id="current-photo" src="{{ asset($profil->FotoProfile) }}" style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover; border: 4px solid #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.1); background: #fff;">
                                
                                <div id="no-photo-placeholder" style="display: none; width: 130px; height: 130px; border-radius: 50%; background: #f1f5f9; border: 2px dashed #cbd5e1; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                                    <i class="fas fa-user-tie" style="font-size: 2.5rem; margin-bottom: 5px;"></i>
                                    <span style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase; color: #94a3b8;">No Image</span>
                                </div>
                            @else
                                <div style="width: 130px; height: 130px; border-radius: 50%; background: #f1f5f9; border: 2px dashed #cbd5e1; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                                    <i class="fas fa-user-tie" style="font-size: 2.5rem; margin-bottom: 5px;"></i>
                                    <span style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase; color: #94a3b8;">No Image</span>
                                </div>
                            @endif
                        </div>
                        <div style="text-align: center; max-width: 350px;">
                            <div style="display: flex; gap: 10px; justify-content: center; margin-bottom: 8px;">
                                <label style="display: inline-block; font-size: 0.75rem; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; background: #f1f5f9; padding: 6px 12px; border-radius: 4px; border: 1px solid #cbd5e1;">
                                    <i class="fas fa-camera" style="margin-right: 5px;"></i> Pilih Foto Baru
                                    <input type="file" name="FotoProfile" id="input-foto" style="display: none;" onchange="batalHapusFoto(this)">
                                </label>
                                
                                @if($profil && $profil->FotoProfile)
                                <button type="button" id="btn-hapus-foto" onclick="triggerHapusFoto()" style="font-size: 0.75rem; font-weight: 700; color: #dc2626; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; background: #fef2f2; padding: 6px 12px; border-radius: 4px; border: 1px solid #fca5a5;">
                                    <i class="fas fa-trash-alt" style="margin-right: 5px;"></i> Hapus
                                </button>
                                @endif
                            </div>
                            
                            <span id="nama-file-terpilih" style="font-size: 0.8rem; color: #15803d; margin-top: 5px; display: block; font-weight: 600;"></span>
                            <span style="display: block; color: #94a3b8; font-size: 0.75rem; margin-top: 6px; line-height: 1.4;">Ekstensi: JPG, JPEG, PNG. Maksimal ukuran file: 2 MB.</span>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Username Sistem (Permanen)</label>
                            <input type="text" value="{{ $user->username }}" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 6px; background: #f1f5f9; color: #64748b; font-family: monospace; font-size: 0.95rem; box-sizing: border-box; cursor: not-allowed;" disabled>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Alamat Email Terdaftar (Permanen)</label>
                            <input type="email" value="{{ $user->email }}" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 6px; background: #f1f5f9; color: #64748b; font-size: 0.95rem; box-sizing: border-box; cursor: not-allowed;" disabled>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Nama Lengkap / Instansi Perusahaan <span style="color: #dc2626;">*</span></label>
                            <input type="text" name="NamaLengkap" value="{{ old('NamaLengkap', $profil->NamaLengkap ?? '') }}" style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; color: #1e293b; box-sizing: border-box; background: #ffffff;" required>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Nomor Telepon / Jalur WhatsApp <span style="color: #dc2626;">*</span></label>
                            <input type="text" name="NoTlp" value="{{ old('NoTlp', $profil->NoTlp ?? '') }}" style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; color: #1e293b; box-sizing: border-box; background: #ffffff;" required>
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Deskripsi Singkat Perusahaan / Komoditas Bisnis</label>
                        <textarea name="Bio" style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; color: #1e293b; height: 75px; box-sizing: border-box; resize: vertical; background: #ffffff;">{{ old('Bio', $profil->Bio ?? '') }}</textarea>
                    </div>

                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Alamat Fisik / Lokasi Gudang Distribusi Utama <span style="color: #dc2626;">*</span></label>
                        <textarea name="Alamat" style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; color: #1e293b; height: 95px; box-sizing: border-box; resize: vertical; background: #ffffff;" required>{{ old('Alamat', $profil->Alamat ?? '') }}</textarea>
                    </div>

                </div>

                <div style="background: #fafafa; border-top: 1px solid #e2e8f0; padding: 15px 25px; text-align: right;">
                    <button type="submit" style="background: #15803d; color: white; border: none; padding: 11px 24px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: background 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        <i class="fas fa-check" style="margin-right: 6px; font-size: 0.85rem;"></i> Simpan Perubahan Profil
                    </button>
                </div>
            </div>
        </form>

        <form action="{{ route('profil.password') }}" method="POST" style="margin: 0;">
            @csrf
            
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 15px 20px;">
                    <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-lock" style="color: #64748b;"></i> Autentikasi Keamanan & Sandi Sistem
                    </h3>
                </div>

                <div style="padding: 25px; display: flex; flex-direction: column; gap: 20px;">
                    
                    <div style="max-width: 500px;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Kata Sandi Saat Ini <span style="color: #dc2626;">*</span></label>
                        <input type="password" name="current_password" style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; color: #1e293b; box-sizing: border-box; background: #ffffff;" required>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Kata Sandi Baru Sistem <span style="color: #dc2626;">*</span></label>
                            <input type="password" name="password" style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; color: #1e293b; box-sizing: border-box; background: #ffffff;" required>
                            <span style="display: block; color: #94a3b8; font-size: 0.75rem; margin-top: 4px;">Kombinasi minimal harus bermuatan 8 karakter.</span>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Konfirmasi Kata Sandi Baru <span style="color: #dc2626;">*</span></label>
                            <input type="password" name="password_confirmation" style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; color: #1e293b; box-sizing: border-box; background: #ffffff;" required>
                        </div>
                    </div>

                </div>

                <div style="background: #fafafa; border-top: 1px solid #e2e8f0; padding: 15px 25px; text-align: right;">
                    <button type="submit" style="background: #1e293b; color: white; border: none; padding: 11px 24px; border-radius: 6px; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: background 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        <i class="fas fa-key" style="margin-right: 6px; font-size: 0.85rem;"></i> Perbarui Kata Sandi Akun
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

<script>
    // Fungsi untuk menandai foto agar dihapus saat form di-submit
    function triggerHapusFoto() {
        document.getElementById('hapus_foto_input').value = '1';
        
        // Sembunyikan foto saat ini dan tombol hapus
        if(document.getElementById('current-photo')) document.getElementById('current-photo').style.display = 'none';
        if(document.getElementById('btn-hapus-foto')) document.getElementById('btn-hapus-foto').style.display = 'none';
        
        // Tampilkan placeholder No Image
        if(document.getElementById('no-photo-placeholder')) {
            document.getElementById('no-photo-placeholder').style.display = 'flex';
        }

        // Hapus value input file jika ada
        document.getElementById('input-foto').value = '';
        document.getElementById('nama-file-terpilih').textContent = 'Foto akan dihapus saat disimpan.';
        document.getElementById('nama-file-terpilih').style.color = '#dc2626';
    }

    // Fungsi membatalkan aksi hapus jika user tiba-tiba memilih foto baru dari device
    function batalHapusFoto(input) {
        if (input.files && input.files[0]) {
            // Batalkan status hapus
            document.getElementById('hapus_foto_input').value = '0';
            
            // Sembunyikan foto lama dan placeholder
            if(document.getElementById('current-photo')) document.getElementById('current-photo').style.display = 'none';
            if(document.getElementById('no-photo-placeholder')) document.getElementById('no-photo-placeholder').style.display = 'none';
            
            // Tampilkan nama file yang dipilih
            document.getElementById('nama-file-terpilih').textContent = 'File terpilih: ' + input.files[0].name;
            document.getElementById('nama-file-terpilih').style.color = '#15803d';
        }
    }
</script>
@endsection