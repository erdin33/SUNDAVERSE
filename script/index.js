
// Deteksi halaman aktif
const currentPage = window.location.pathname.split('/').pop();
document.querySelectorAll('.menu a').forEach(link => {
    if(link.getAttribute('href') === currentPage) {
        link.classList.add('active');
    }
});


