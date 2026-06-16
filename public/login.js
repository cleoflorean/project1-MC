document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk mengubah role saat tombol diklik
    window.selectRole = function(role) {
        // Ubah nilai input hidden
        document.getElementById('roleInput').value = role;

        // Hapus class 'active' dari semua tombol
        const buttons = document.querySelectorAll('.role-btn');
        buttons.forEach(btn => btn.classList.remove('active'));

        // Tambahkan class 'active' ke tombol yang diklik
        const clickedBtn = document.querySelector(`.role-btn[data-role="${role}"]`);
        if(clickedBtn) {
            clickedBtn.classList.add('active');
        }
    };
});