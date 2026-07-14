@extends('layouts.app22')
@section('title', 'Ajukan Komplain')

@section('content')
<div style="background-color: #f3f4f6; min-height: 100vh; padding: 40px 20px; font-family: sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); overflow: hidden;">
        
        {{-- Header Form --}}
        <div style="background-color: #ef4444; padding: 20px; text-align: center; color: white;">
            <i class="fas fa-exclamation-triangle" style="font-size: 2.5rem; margin-bottom: 10px;"></i>
            <h2 style="margin: 0; font-size: 1.5rem;">Pengajuan Komplain</h2>
            <p style="margin: 5px 0 0 0; font-size: 0.9rem; opacity: 0.9;">ID Pesanan: #{{ $pembayaran->idPembayaran }}</p>
        </div>

        {{-- Isi Form --}}
        <div style="padding: 30px;">
            <form action="{{ route('pembeli.komplain.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                {{-- Input Hidden --}}
                <input type="hidden" name="idPembayaran" value="{{ $pembayaran->idPembayaran }}">

                {{-- Input WhatsApp --}}
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Nomor WhatsApp Aktif <span style="color: red;">*</span></label>
                    <p style="font-size: 0.8rem; color: #6b7280; margin: 0 0 8px 0;">Agar admin dapat menghubungi Anda untuk penyelesaian.</p>
                    <input type="text" name="no_whatsapp" placeholder="Contoh: 08123456789" required style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; font-size: 1rem;">
                </div>

                {{-- Input Alasan --}}
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Detail Kendala / Masalah <span style="color: red;">*</span></label>
                    <textarea name="alasan_komplain" rows="4" placeholder="Jelaskan secara rinci barang yang rusak, kurang, atau masalah lainnya..." required style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; font-size: 1rem; resize: vertical;"></textarea>
                </div>

                {{-- Input Foto --}}
                <div style="margin-bottom: 30px;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Foto Bukti <span style="color: red;">*</span></label>
                    <div style="border: 2px dashed #d1d5db; border-radius: 8px; padding: 20px; text-align: center; background-color: #f9fafb;">
                        <input type="file" name="bukti_pendukung" accept="image/png, image/jpeg, image/jpg" required style="max-width: 100%; font-size: 0.9rem;">
                        <p style="margin: 10px 0 0 0; font-size: 0.8rem; color: #6b7280;">Format: JPG, JPEG, PNG. Ukuran maksimal 2MB.</p>
                    </div>
                </div>

                {{-- Tombol --}}
                <div style="display: flex; gap: 15px;">
                    <a href="{{ route('pembeli.riwayat') }}" style="text-decoration: none; text-align: center; background-color: #e5e7eb; color: #374151; font-weight: 600; padding: 14px; border-radius: 8px; flex: 1; transition: 0.2s;">Kembali</a>
                    <button type="submit" style="background-color: #ef4444; color: white; font-weight: 600; padding: 14px; border: none; border-radius: 8px; flex: 1; cursor: pointer; transition: 0.2s;">Kirim Komplain</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection