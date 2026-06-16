document.addEventListener('DOMContentLoaded', function() {
    console.log("Sistem Agrimart siap digunakan.");
});

// Fungsi untuk tombol Terima Penawaran
function terimaPenawaran(namaVendor) {
    if(confirm(`Apakah Anda yakin ingin menerima penawaran dari ${namaVendor}?`)) {
        // Nanti di sini kita bisa arahkan ke route PHP untuk memproses transaksi
        alert(`Penawaran dari ${namaVendor} berhasil diterima!`);
    }
}