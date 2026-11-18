@extends('layouts.kurir')
@section('title', 'Kelola Pengiriman - ' . ($pengiriman->no_resi ?? 'Detail'))

@section('content')
@php
    $penawaran = $pengiriman->penawaran;
    $permintaan = $penawaran->permintaan ?? null;
    $komoditas = $permintaan->komoditas ?? null;
    $petani = $penawaran->petani ?? null;
    $profilPetani = $petani->profile ?? null;
    $pembeli = $permintaan->user ?? null;
    $profilPembeli = $pembeli->profile ?? null;
    $trackings = $pengiriman->tracking;
    $isSelesai = in_array($pengiriman->StatusPesanan, ['Pesanan Selesai', 'Selesai']);
@endphp

<div class="container py-4">

    {{-- KEMBALI & NOMOR RESI --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('kurir.dashboard') }}" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="fw-bold mb-0 text-dark">Kelola Paket & Logistik</h4>
                <div class="d-flex align-items-center gap-2 mt-1">
                    <span class="badge bg-success-subtle text-success border border-success px-2 py-1 fs-6">
                        <i class="fas fa-barcode me-1"></i> Resi: <strong>{{ $pengiriman->no_resi ?? 'Belum Terbit' }}</strong>
                    </span>
                    <button class="btn btn-sm btn-link text-decoration-none text-muted p-0" onclick="copyResi('{{ $pengiriman->no_resi }}')" title="Salin Resi">
                        <i class="far fa-copy"></i> Salin
                    </button>
                </div>
            </div>
        </div>

        <div>
            <span class="badge bg-primary px-3 py-2 rounded-pill fs-7">
                Status Saat Ini: {{ $pengiriman->StatusPesanan }}
            </span>
        </div>
    </div>

    <div class="row g-4">
        
        {{-- KOLOM KIRI: TINDAKAN KURIR & TIMELINE --}}
        <div class="col-12 col-lg-7">
            
            {{-- PANEL AKSI KURIR --}}
            @if(!$isSelesai)
            <div class="card-custom p-4 mb-4 border-top border-4 border-success">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="fas fa-location-crosshairs text-success me-2"></i>Perbarui Perjalanan Paket
                </h5>

                <div class="row g-2">
                    {{-- Tombol Check-in Drop Point --}}
                    <div class="col-12 col-sm-6">
                        <button type="button" class="btn btn-outline-success fw-bold w-100 py-3 rounded-3 shadow-sm d-flex flex-column align-items-center justify-content-center gap-1" data-bs-toggle="modal" data-bs-target="#modalDropPoint">
                            <i class="fas fa-warehouse fs-4 text-success"></i>
                            <span>Check-in Drop Point</span>
                            <small class="text-muted fw-normal" style="font-size: 0.75rem;">Singgah di transit/gudang</small>
                        </button>
                    </div>

                    {{-- Tombol Selesaikan Pengantaran --}}
                    <div class="col-12 col-sm-6">
                        <button type="button" class="btn btn-success fw-bold w-100 py-3 rounded-3 shadow-sm d-flex flex-column align-items-center justify-content-center gap-1" data-bs-toggle="modal" data-bs-target="#modalSelesai">
                            <i class="fas fa-clipboard-check fs-4 text-white"></i>
                            <span>Serah Terima ke Pembeli</span>
                            <small class="text-white-50 fw-normal" style="font-size: 0.75rem;">Upload foto bukti paket diterima</small>
                        </button>
                    </div>
                </div>
            </div>
            @endif

            {{-- TIMELINE PERJALANAN PAKET --}}
            <div class="card-custom p-4">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fas fa-route text-primary me-2"></i>Riwayat Pelacakan Paket
                    </h5>
                    <span class="badge bg-secondary rounded-pill">{{ $trackings->count() }} Checkpoint</span>
                </div>

                <div class="timeline-container px-2">
                    @forelse($trackings as $index => $track)
                        <div class="timeline-step">
                            <div class="timeline-dot {{ $index === $trackings->count() - 1 ? 'bg-success' : 'bg-primary' }}"></div>
                            <div>
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-1">
                                    <strong class="text-dark fs-6">{{ $track->status_log }}</strong>
                                    <span class="text-muted small">
                                        <i class="far fa-clock me-1"></i>{{ \Carbon\Carbon::parse($track->waktu_scan)->translatedFormat('d M Y, H:i') }} WIB
                                    </span>
                                </div>

                                @if($track->dropPoint)
                                    <div class="text-secondary small mb-1">
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i> Lokasi: <strong>{{ $track->dropPoint->nama_titik }}</strong> ({{ $track->dropPoint->kota }})
                                    </div>
                                @endif

                                @if($track->catatan)
                                    <p class="text-muted small mb-2 fst-italic">"{{ $track->catatan }}"</p>
                                @endif

                                @if($track->foto_bukti)
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $track->foto_bukti) }}" target="_blank" class="d-inline-block text-decoration-none">
                                            <div class="border rounded-3 p-1 bg-light d-flex align-items-center gap-2">
                                                <img src="{{ asset('storage/' . $track->foto_bukti) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                                <span class="small text-primary fw-semibold"><i class="fas fa-magnifying-glass me-1"></i> Lihat Foto Bukti</span>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-map-location-dot fs-2 mb-2 text-secondary"></i>
                            <p class="mb-0">Belum ada riwayat tracking log untuk pengiriman ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- KOLOM KANAN: RINCIAN ALAMAT & KOMODITAS --}}
        <div class="col-12 col-lg-5">
            
            {{-- Kartu Info Komoditas --}}
            <div class="card-custom p-3 mb-3">
                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                    <i class="fas fa-box text-success me-2"></i>Komoditas yang Diantar
                </h6>
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 border overflow-hidden bg-light d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; flex-shrink: 0;">
                        @if($penawaran->Gambar)
                            <img src="{{ asset($penawaran->Gambar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fas fa-seedling text-success fs-3"></i>
                        @endif
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">{{ $komoditas->namatanaman ?? 'Komoditas Pertanian' }}</h6>
                        <div class="text-secondary small">Volume: <strong>{{ number_format($penawaran->JumlahTawar, 0, ',', '.') }} Kg</strong></div>
                        <div class="text-success fw-bold small">Total Tagihan: Rp {{ number_format($pengiriman->pembayaran->TotalBayar ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            {{-- Kartu Alamat Penjemputan (Petani) --}}
            <div class="card-custom p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="fas fa-store text-danger me-2"></i>Alamat Penjemputan (Petani)
                    </h6>
                    @if(!empty($profilPetani->NoWhatsApp))
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $profilPetani->NoWhatsApp)) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-2 py-0">
                            <i class="fab fa-whatsapp me-1"></i> Hubungi
                        </a>
                    @endif
                </div>
                <div class="fw-bold text-dark">{{ $profilPetani->NamaLengkap ?? $petani->username ?? 'Petani' }}</div>
                <div class="text-muted small mb-2"><i class="fas fa-phone me-1"></i> {{ $profilPetani->NoWhatsApp ?? '-' }}</div>
                <p class="text-secondary small mb-0 lh-sm">{{ $profilPetani->Alamat ?? 'Alamat petani belum dilengkapi.' }}</p>
            </div>

            {{-- Kartu Alamat Tujuan (Pembeli) --}}
            <div class="card-custom p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="fas fa-house-chimney text-success me-2"></i>Alamat Tujuan (Pembeli)
                    </h6>
                    @if(!empty($profilPembeli->NoWhatsApp))
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $profilPembeli->NoWhatsApp)) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-2 py-0">
                            <i class="fab fa-whatsapp me-1"></i> Hubungi
                        </a>
                    @endif
                </div>
                <div class="fw-bold text-dark">{{ $profilPembeli->NamaLengkap ?? $pembeli->username ?? 'Pembeli' }}</div>
                <div class="text-muted small mb-2"><i class="fas fa-phone me-1"></i> {{ $profilPembeli->NoWhatsApp ?? '-' }}</div>
                <p class="text-secondary small mb-0 lh-sm">{{ $profilPembeli->Alamat ?? 'Alamat pembeli belum diatur.' }}</p>
            </div>

            {{-- Link Halaman Publik Lacak Resi --}}
            <div class="card-custom p-3 bg-light">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fw-bold text-dark small">Tautan Lacak Publik:</div>
                        <div class="text-muted small">Dapat dibagikan ke penerima</div>
                    </div>
                    <a href="{{ route('lacak.resi', ['resi' => $pengiriman->no_resi]) }}" target="_blank" class="btn btn-sm btn-success rounded-pill">
                        <i class="fas fa-external-link-alt me-1"></i> Buka Pelacakan
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>

{{-- MODAL CHECK-IN DROP POINT --}}
<div class="modal fade" id="modalDropPoint" tabindex="-1" aria-labelledby="modalDropPointLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <form action="{{ route('kurir.pengiriman.checkin', $pengiriman->idPengiriman) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold" id="modalDropPointLabel">
                        <i class="fas fa-warehouse me-2"></i>Check-in di Drop Point Transit
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Pilih Drop Point / Gudang Transit <span class="text-danger">*</span></label>
                        <select name="drop_point_id" class="form-select form-select-lg" required>
                            <option value="">-- Pilih Titik Singgah --</option>
                            @foreach($dropPoints as $dp)
                                <option value="{{ $dp->id }}">
                                    {{ $dp->nama_titik }} ({{ $dp->kota }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Unggah Foto Resi / Kondisi Paket <small class="text-muted fw-normal">(Opsional)</small></label>
                        <input type="file" name="foto_bukti" class="form-control" accept="image/png,image/jpeg,image/jpg">
                        <div class="form-text">Maksimal 3MB. Format JPG, JPEG, PNG.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Catatan Kurir <small class="text-muted fw-normal">(Opsional)</small></label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Paket tiba di gudang Batununggal, menunggu armada distribusi wilayah utara..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold rounded-pill px-4">
                        <i class="fas fa-check me-1"></i> Simpan Check-in
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL SERAH TERIMA PENGANTARAN SELESAI --}}
<div class="modal fade" id="modalSelesai" tabindex="-1" aria-labelledby="modalSelesaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <form action="{{ route('kurir.pengiriman.selesai', $pengiriman->idPengiriman) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="modalSelesaiLabel">
                        <i class="fas fa-hand-holding-heart me-2"></i>Serah Terima ke Penerima
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info py-2 small mb-3">
                        <i class="fas fa-info-circle me-1"></i> Pastikan penerima telah mengecek kondisi barang sebelum Anda menyelesaikan pengantaran.
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Unggah Foto Bukti Penyerahan / Resi Diterima <span class="text-danger">*</span></label>
                        <input type="file" name="foto_bukti" class="form-control" accept="image/png,image/jpeg,image/jpg" required>
                        <div class="form-text">Wajib unggah foto saat paket diserahkan ke penerima / depan rumah.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Catatan Serah Terima</label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Diterima langsung oleh Bapak Budi Santoso di lokasi. Kondisi komoditas segar."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold rounded-pill px-4">
                        <i class="fas fa-check-double me-1"></i> Selesaikan Pengantaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyResi(resi) {
        if (!resi) return;
        navigator.clipboard.writeText(resi).then(() => {
            alert('Nomor Resi ' + resi + ' berhasil disalin ke clipboard!');
        });
    }
</script>
@endpush
@endsection
