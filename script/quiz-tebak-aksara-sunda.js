// Data pertanyaan
const questions = [
    {
        question: "ᮌᮩᮜᮤᮞ᮪",
        answers: ["Gulis", "Gelis", "Geulis", "Gélis"],
        correctAnswer: "Geulis",
        aksara_swara1: "ᮌᮩ",
        aksara_swara2: "ᮜᮤ",
        aksara_swara3: "ᮞ᮪",
        terjemah1: "Geu",
        terjemah2: "li",
        terjemah3: "s",
        explanation: "Perhatikan perbedaan pada suku kata pertama. Aksara 'ᮌᮩ' dibaca 'geu', bukan 'ge'. Untuk mendapatkan bunyi 'ge', seharusnya menggunakan aksara 'ᮌᮨ' (dengan tanda pamingkal di atas)."
    },
    {
        question: "ᮌᮩᮜᮤᮞ᮪",
        answers: ["Gulis", "Gelis", "Geulis", "Gélis"],
        correctAnswer: "Geulis",
        aksara_swara1: "ᮌᮩ",
        aksara_swara2: "ᮜᮤ",
        aksara_swara3: "ᮞ᮪",
        terjemah1: "Geu",
        terjemah2: "li",
        terjemah3: "s",
        explanation: "Perhatikan perbedaan pada suku kata pertama. Aksara 'ᮌᮩ' dibaca 'geu', bukan 'ge'. Untuk mendapatkan bunyi 'ge', seharusnya menggunakan aksara 'ᮌᮨ' (dengan tanda pamingkal di atas)."
    },
    // Tambahkan lebih banyak pertanyaan di sini
];

let currentQuestionIndex = 0;
let score = 0;
let userAnswers = {}; // Objek untuk menyimpan jawaban pengguna

// Elemen HTML
// Membuat elemen <link> untuk memuat font dari Google Fonts
const questionElement = document.getElementById("question");
const answerButtons = document.querySelectorAll(".answer-button");
const scoreElement = document.getElementById("score");
const feedbackElement = document.getElementById("feedback");
const nextBtn = document.getElementById("next-btn");
const prevBtn = document.getElementById("prev-btn");
const confirmationPopup = document.getElementById("confirmation-popup");
const confirmYes = document.getElementById("confirm-yes");
const confirmNo = document.getElementById("confirm-no");

function loadQuestion() {
    const currentQuestion = questions[currentQuestionIndex];
    questionElement.textContent = currentQuestion.question;

    // Reset tombol dan feedback
    answerButtons.forEach((button, index) => {
        button.textContent = currentQuestion.answers[index];
        button.classList.remove("correct", "incorrect"); // Reset kelas
        button.disabled = false; // Aktifkan tombol secara default
    });

    // Nonaktifkan tombol "Sebelum" jika di pertanyaan pertama
    if (currentQuestionIndex === 0) {
        prevBtn.textContent = "Kembali";
        prevBtn.removeEventListener("click", previousQuestion); // Hapus event listener sebelumnya
        prevBtn.addEventListener("click", showConfirmationPopup);
    } else {
        prevBtn.textContent = "Sebelum";
        prevBtn.removeEventListener("click", showConfirmationPopup); // Hapus event listener konfirmasi
        prevBtn.addEventListener("click", previousQuestion);
    }

    // Ubah teks tombol "Selanjutnya" menjadi "Selesai" jika di pertanyaan terakhir
    if (currentQuestionIndex === questions.length - 1) {
        nextBtn.textContent = "Selesai";
    } else {
        nextBtn.textContent = "Selanjutnya >";
    }

    // Jika sudah ada jawaban untuk pertanyaan ini, tampilkan jawaban dan nonaktifkan tombol
    if (userAnswers[currentQuestionIndex] !== undefined) {
        const userAnswer = userAnswers[currentQuestionIndex];
        const isCorrect = userAnswer.trim().toLowerCase() === currentQuestion.correctAnswer.trim().toLowerCase();

        answerButtons.forEach(button => {
            button.disabled = true; // Nonaktifkan semua tombol
            if (button.textContent.trim().toLowerCase() === userAnswer.trim().toLowerCase()) {
                button.classList.add(isCorrect ? "correct" : "incorrect"); // Tandai jawaban pengguna
            }
        });

        // Tampilkan feedback
        showFeedback(isCorrect, currentQuestion.correctAnswer);

        // Aktifkan tombol "Selanjutnya"
        nextBtn.disabled = false;
    } else {
        // Jika belum ada jawaban, sembunyikan feedback
        feedbackElement.style.display = "none";

        // Tambahkan event listener untuk tombol jawaban
        answerButtons.forEach(button => {
            button.addEventListener("click", () => checkAnswer(button, currentQuestion.correctAnswer));
        });

        // Nonaktifkan tombol "Selanjutnya" jika belum menjawab
        nextBtn.disabled = true;
    }
}

function checkAnswer(selectedButton, correctAnswer) {
    // Simpan jawaban pengguna hanya jika belum ada jawaban sebelumnya
    if (userAnswers[currentQuestionIndex] === undefined) {
        userAnswers[currentQuestionIndex] = selectedButton.textContent;

        // Tandai tombol yang dipilih sebagai benar atau salah
        const isCorrect = selectedButton.textContent.trim().toLowerCase() === correctAnswer.trim().toLowerCase();
        selectedButton.classList.add(isCorrect ? "correct" : "incorrect");

        // Perbarui skor jika jawaban benar
        if (isCorrect) {
            score += 10;
        }

        // Perbarui skor di layar
        scoreElement.textContent = `Skor: ${score}`;
    }

    // Nonaktifkan semua tombol setelah menjawab
    answerButtons.forEach(button => {
        button.disabled = true;
    });

    // Tampilkan feedback
    const isCorrect = selectedButton.textContent.trim().toLowerCase() === correctAnswer.trim().toLowerCase();
    showFeedback(isCorrect, correctAnswer);

    // Aktifkan tombol "Selanjutnya"
    nextBtn.disabled = false;
}

// Fungsi untuk menampilkan feedback
function showFeedback(isCorrect, correctAnswer) {
    // Hapus kelas sebelumnya (jika ada)
    feedbackElement.classList.remove("correct", "incorrect");

    if (isCorrect) {
        // Jika jawaban benar
        feedbackElement.innerHTML = `
            <p class="hasil">Benar!</p>
            <p class="judul-answer">Jawaban Anda "${userAnswers[currentQuestionIndex]}" Tepat.</p>
            <div class="aksara-row">
                <p class="penjelasan-aksara">${questions[currentQuestionIndex].aksara_swara1} <span>${questions[currentQuestionIndex].terjemah1}</p>
                <p class="penjelasan-aksara">${questions[currentQuestionIndex].aksara_swara2} <span>${questions[currentQuestionIndex].terjemah2}</p>
                <p class="penjelasan-aksara">${questions[currentQuestionIndex].aksara_swara3} <span>${questions[currentQuestionIndex].terjemah3}</p>
            </div>
            <div class="coba">
                <div class="answer-feedback">
                    <span class="answer-label">Jawaban Anda</span>
                    <p>${userAnswers[currentQuestionIndex]}</p>
                </div>
                <div class="answer-feedback">
                    <span class="answer-label">Jawaban Benar</span>
                    <p>${correctAnswer}</p>
                </div>
            </div>
        `;
        feedbackElement.classList.add("correct");
    } else {
        // Jika jawaban salah
        feedbackElement.innerHTML = `
            <p class="hasil">Salah!</p>
            <p class="judul-answer">Jawaban Anda "${userAnswers[currentQuestionIndex]}" Tidak Tepat.</p>
             <div class="aksara-row">
                <p class="penjelasan-aksara">${questions[currentQuestionIndex].aksara_swara1} <span>${questions[currentQuestionIndex].terjemah1}</p>
                <p class="penjelasan-aksara">${questions[currentQuestionIndex].aksara_swara2} <span>${questions[currentQuestionIndex].terjemah2}</p>
                <p class="penjelasan-aksara">${questions[currentQuestionIndex].aksara_swara3} <span>${questions[currentQuestionIndex].terjemah3}</p>
            </div>
            <div class="coba">
                <div class="answer-feedback">
                    <span class="wrong-answer">Jawaban Anda</span>
                    <p>${userAnswers[currentQuestionIndex]}</p>
                </div>
                <div class="answer-feedback">
                    <span class="answer-label">Jawaban Benar</span>
                    <p>${correctAnswer}</p>
                </div>
            </div>
            <p>${questions[currentQuestionIndex].explanation}</p>
        `;
        feedbackElement.classList.add("incorrect");
    }

    feedbackElement.style.display = "block";
}

// Fungsi untuk menampilkan pop-up konfirmasi
function showConfirmationPopup() {
    confirmationPopup.style.display = "flex"; // Tampilkan pop-up
}

// Event listeners untuk tombol konfirmasi
confirmYes.addEventListener("click", () => {
    window.location.href = "quiz.html"; // Kembali ke halaman quiz
});

confirmNo.addEventListener("click", () => {
    confirmationPopup.style.display = "none"; // Sembunyikan pop-up
});

// Fungsi untuk pindah ke pertanyaan berikutnya
function nextQuestion() {
    if (userAnswers[currentQuestionIndex] === undefined) {
        alert("Anda harus menjawab pertanyaan ini terlebih dahulu!");
        return; // Hentikan proses jika belum menjawab
    }

    currentQuestionIndex++;
    if (currentQuestionIndex >= questions.length) {
        alert(`Permainan selesai! Skor akhir Anda: ${score}`);
        window.location.href = "quiz.html"; // Kembali ke halaman quiz
    } else {
        loadQuestion();
    }
}

// Fungsi untuk pindah ke pertanyaan sebelumnya
function previousQuestion() {
    if (currentQuestionIndex > 0) {
        currentQuestionIndex--;
        loadQuestion();
    }
}

// Load the first question when the page loads
loadQuestion();

// Event listeners untuk tombol navigasi
nextBtn.addEventListener("click", () => {
    if (nextBtn.textContent === "Selesai") {
        alert(`Permainan selesai! Skor akhir Anda: ${score}`);
        window.location.href = "quiz.html"; // Kembali ke halaman quiz
    } else {
        nextQuestion();
    }
});

prevBtn.addEventListener("click", () => {
    if (currentQuestionIndex === 0) {
        showConfirmationPopup();
    } else {
        previousQuestion();
    }
});