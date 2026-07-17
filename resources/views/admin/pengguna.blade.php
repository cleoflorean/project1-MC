@extends('layouts.admin')

@section('title', 'Kelola Pengguna - Tani Harvest')
@section('header_title', 'Manajemen Akun Pengguna')

@section('content')
<div class="container-fluid p-0">
    
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        {{-- BAGIAN ATAS: JUDUL & PENCARIAN --}}
        <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-3 border-bottom">
            <h5 class="m-0 fw-bold text-dark">
                <i class="fas fa-users text-success me-2"></i> Daftar Pengguna Sistem
            </h5>
            
            {{-- Search Input Input Canggih --}}
            <div class="position-relative">
                <i class="fas fa-search text-muted position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.9rem;"></i>
                <input type="text" id="cariPengguna" onkeyup="filterPengguna()" class="form-control ps-5" placeholder="Cari Nama, Username, Email..." style="width: 300px; border-radius: 8px; font-size: 0.9rem;">
            </div>
        </div>

        <div class="card-body p-4">
            @php
                // Pisahkan data pengguna langsung di blade berdasarkan role
                $petani = collect($semuaAkun ?? [])->where('role', 'petani');
                $pembeli = collect($semuaAkun ?? [])->where('role', 'pembeli');
            @endphp

            {{-- 1. TABEL MITRA PETANI --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-success m-0"><i class="fas fa-tractor me-2"></i> Kelompok Mitra Petani</h6>
                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">Total: {{ $petani->count() }}</span>
            </div>
            <div class="table-responsive rounded-3 border mb-5">
                <table class="table table-hover align-middle mb-0" id="tabelPetani">
                    <thead class="table-light text-muted fw-bold" style="font-size: 0.85rem;">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Tanggal Daftar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.9rem;">
                        @forelse($petani as $user)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">#{{ $user->id }}</td>
                            <td class="fw-bold text-dark">{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.pengguna.detail', $user->id) }}" class="btn btn-sm btn-outline-dark px-3 rounded-2 fw-semibold">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted italic">Belum ada data akun Petani terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- 2. TABEL PEMBELI --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-primary m-0"><i class="fas fa-shopping-basket me-2"></i> Kelompok Akun Pembeli</h6>
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1">Total: {{ $pembeli->count() }}</span>
            </div>
            <div class="table-responsive rounded-3 border">
                <table class="table table-hover align-middle mb-0" id="tabelPembeli">
                    <thead class="table-light text-muted fw-bold" style="font-size: 0.85rem;">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Tanggal Daftar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.9rem;">
                        @forelse($pembeli as $user)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">#{{ $user->id }}</td>
                            <td class="fw-bold text-dark">{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.pengguna.detail', $user->id) }}" class="btn btn-sm btn-outline-dark px-3 rounded-2 fw-semibold">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted italic">Belum ada data akun Pembeli terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- JAVASCRIPT LIVE FILTER SEARCH --}}
<script>
function filterPengguna() {
    let input = document.getElementById("cariPengguna").value.toLowerCase();
    let daftarTabel = [document.getElementById("tabelPetani"), document.getElementById("tabelPembeli")];
    
    daftarTabel.forEach(table => {
        if (!table) return;
        let rows = table.getElementsByTagName("tr");
        
        // Loop mulai dari indeks 1 untuk melewati bagian header table
        for (let i = 1; i < rows.length; i++) {
            let cellUsername = rows[i].getElementsByTagName("td")[1];
            let cellEmail = rows[i].getElementsByTagName("td")[2];
            
            if (cellUsername || cellEmail) {
                let textLengkap = (cellUsername.textContent || cellUsername.innerText) + " " + 
                                  (cellEmail.textContent || cellEmail.innerText);
                
                if (textLengkap.toLowerCase().indexOf(input) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    });
}
</script>
@endsection