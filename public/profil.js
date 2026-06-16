document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Fungsi Tombol Edit Profil
    const btnEdit = document.getElementById('btn-edit-profile');
    if(btnEdit) {
        btnEdit.addEventListener('click', function() {
            // Nantinya ini bisa diganti dengan membuka Modal Form Edit
            alert('Fitur Edit Profil sedang dipersiapkan. Nanti akan muncul form untuk mengubah data!');
        });
    }

    // 2. Fungsi Animasi Switch 2FA
    const toggleSwitch = document.getElementById('toggle-2fa');
    if(toggleSwitch) {
        toggleSwitch.addEventListener('click', function() {
            // Menambah/menghapus class 'active' untuk memicu animasi CSS
            this.classList.toggle('active');
            
            if(this.classList.contains('active')) {
                console.log('Autentikasi 2 Langkah Diaktifkan');
            } else {
                console.log('Autentikasi 2 Langkah Dinonaktifkan');
            }
        });
    }

});