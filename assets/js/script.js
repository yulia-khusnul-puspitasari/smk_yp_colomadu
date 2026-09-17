document.addEventListener('DOMContentLoaded', function() {
    // Validasi file PDF
    const berkasInput = document.querySelector('input[name="berkas"]');
    if (berkasInput) {
        berkasInput.addEventListener('change', function() {
            if (this.files[0] && this.files[0].type !== 'application/pdf') {
                alert('File harus berformat PDF!');
                this.value = '';
            }
        });
    }
    
    // Validasi file gambar
    const gambarInput = document.querySelector('input[name="gambar"]');
    if (gambarInput) {
        gambarInput.addEventListener('change', function() {
            const allowed = ['image/jpeg', 'image/png'];
            if (this.files[0] && !allowed.includes(this.files[0].type)) {
                alert('File harus berformat JPG atau PNG!');
                this.value = '';
            }
        });
    }
});