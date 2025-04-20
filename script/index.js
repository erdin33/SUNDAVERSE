document.addEventListener("DOMContentLoaded", () => {
    const homeLink = document.getElementById("home-link");

    // Mendapatkan URL saat ini
    const currentUrl = window.location.href;

    // Memeriksa apakah pengguna berada di halaman utama
    if (currentUrl.includes("index.html")) {
        homeLink.classList.add("active");
    }
});