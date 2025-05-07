document.addEventListener("DOMContentLoaded", () => {
    // Navbar: Menandai link aktif
    const quizLink = document.getElementById("quiz-link");

    // Mendapatkan URL saat ini
    const currentUrl = window.location.href;

    // Memeriksa apakah pengguna berada di halaman quiz
    if (currentUrl.includes("quiz.html")) {
        quizLink.classList.add("active");
    }

    // Quiz Cards: Menangani pemilihan card
    const quizCards = document.querySelectorAll(".quiz-card");
    const startQuizBtn = document.getElementById("startQuizBtn");
    const popupModal = document.getElementById("popupModal");
    const closeBtn = document.querySelector(".close-btn");

    let selectedQuiz = null;

    // Tambahkan event listener untuk setiap kartu quiz
    quizCards.forEach((card) => {
        card.addEventListener("click", () => {
            // Hapus kelas 'selected' dari semua kartu
            quizCards.forEach((c) => c.classList.remove("selected"));
            // Tambahkan kelas 'selected' ke kartu yang dipilih
            card.classList.add("selected");
            // Simpan jenis quiz yang dipilih
            selectedQuiz = card.getAttribute("data-quiz");
        });
    });

    // Event listener untuk tombol "Mulai Quiz"
    startQuizBtn.addEventListener("click", () => {
        if (selectedQuiz) {
            // Redirect ke halaman quiz yang sesuai
            window.location.href = `quiz-${selectedQuiz}.php`;
        } else {
            // Tampilkan modal pop-up
            popupModal.style.display = "flex";
        }
    });

    // Event listener untuk tombol close modal
    closeBtn.addEventListener("click", () => {
        popupModal.style.display = "none";
    });

    // Tutup modal jika pengguna mengklik di luar area modal
    window.addEventListener("click", (event) => {
        if (event.target === popupModal) {
            popupModal.style.display = "none";
        }
    });
});