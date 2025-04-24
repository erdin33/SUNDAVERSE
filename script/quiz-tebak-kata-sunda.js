// Data pertanyaan
const questions = [
    {
        question: "Malu",
        answers: ["Nyeri", "Éra", "Sieun", "Hanjakal"],
        correctAnswer: "Éra",
        explanation: "Kata 'Malu' dalam bahasa Indonesia, dalam bahasa Sunda disebut 'Éra'."
    },
    {
        question: "Tidur",
        answers: ["Nyeri", "Bobo", "Sieun", "Hanjakal"],
        correctAnswer: "Bobo",
        explanation: "Kata 'Tidur' dalam bahasa Indonesia, dalam bahasa Sunda disebut 'Bobo'."
    },
    // Tambahkan lebih banyak pertanyaan di sini
];

let currentQuestionIndex = 0;
let score = 0;
let selectedAnswer = ""; // Variabel global untuk menyimpan jawaban yang dipilih
let hasAnswered = false; // Variabel untuk melacak apakah pengguna sudah menjawab

// Elemen HTML
const questionElement = document.getElementById("question");
const answerButtons = document.querySelectorAll(".answer-button");
const scoreElement = document.getElementById("score");
const feedbackElement = document.getElementById("feedback");
const nextBtn = document.getElementById("next-btn");
const prevBtn = document.getElementById("prev-btn");

function loadQuestion() {
    hasAnswered = false; // Reset status jawaban

    const currentQuestion = questions[currentQuestionIndex];
    questionElement.textContent = currentQuestion.question;

    answerButtons.forEach((button, index) => {
        button.textContent = currentQuestion.answers[index];
        button.classList.remove("correct", "incorrect"); // Reset kelas
        button.disabled = false; // Aktifkan tombol lagi
        button.addEventListener("click", () => checkAnswer(button, currentQuestion.correctAnswer));
    });

    // Nonaktifkan tombol "Sebelum" jika di pertanyaan pertama
    if (currentQuestionIndex === 0) {
        prevBtn.disabled = true;
    } else {
        prevBtn.disabled = false;
    }

    // Ubah teks tombol "Selanjutnya" menjadi "Selesai" jika di pertanyaan terakhir
    if (currentQuestionIndex === questions.length - 1) {
        nextBtn.textContent = "Selesai";
    } else {
        nextBtn.textContent = "Selanjutnya >";
    }

    // Sembunyikan feedback
    feedbackElement.style.display = "none"; // Reset feedback
    feedbackElement.classList.remove("correct", "incorrect"); // Hapus kelas feedback
}

function checkAnswer(selectedButton, correctAnswer) {
    // Reset semua tombol terlebih dahulu
    answerButtons.forEach(button => {
        button.classList.remove("correct", "incorrect"); // Hapus semua kelas
    });

    // Tandai tombol yang dipilih sebagai benar atau salah
    const isCorrect = selectedButton.textContent === correctAnswer;
    selectedButton.classList.add(isCorrect ? "correct" : "incorrect");

    // Simpan jawaban yang dipilih
    selectedAnswer = selectedButton.textContent;

    // Perbarui skor jika jawaban benar
    if (isCorrect) {
        score += 20;
    }

    // Tampilkan feedback
    showFeedback(isCorrect, correctAnswer);

    // Perbarui skor di layar
    scoreElement.textContent = `Skor: ${score}`;

    // Nonaktifkan semua tombol setelah menjawab
    answerButtons.forEach(button => {
        button.disabled = true;
    });

    // Aktifkan tombol "Selanjutnya"
    nextBtn.disabled = false;

    // Setel status jawaban menjadi true
    hasAnswered = true;
}

// Fungsi untuk menampilkan feedback
function showFeedback(isCorrect, correctAnswer) {
    // Hapus kelas sebelumnya (jika ada)
    feedbackElement.classList.remove("correct", "incorrect");

    if (isCorrect) {
        // Jika jawaban benar
        feedbackElement.innerHTML = `
            <p class="hasil">Benar!</p>
            <p class="judul-answer">Jawaban Anda "${selectedAnswer}" Tepat.</p>
            <div class="coba">
                <div class="answer-feedback">
                    <span class="answer-label">Jawaban Anda</span>
                    <p>${selectedAnswer}</p>
                </div>
                <div class="answer-feedback">
                    <span class="answer-label">Jawaban Benar</span>
                    <p>${correctAnswer}</p>
                </div>
            </div>
            <p>${questions[currentQuestionIndex].explanation}</p>
        `;
        feedbackElement.classList.add("correct");
    } else {
        // Jika jawaban salah
        feedbackElement.innerHTML = `
            <p class="hasil">Salah!</p>
            <p class="judul-answer">Jawaban Anda "${selectedAnswer}" Tidak Tepat.</p>
            <div class="coba">
                <div class="answer-feedback">
                    <span class="wrong-answer">Jawaban Anda</span>
                    <p>${selectedAnswer}</p>
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

const popup = document.getElementById("popup");
const closePopupBtn = document.getElementById("close-popup");

function showPopup() {
    popup.style.display = "flex"; // Tampilkan pop-up
}

closePopupBtn.addEventListener("click", () => {
    popup.style.display = "none"; // Sembunyikan pop-up
});

function nextQuestion() {
    if (!hasAnswered) {
        showPopup(); // Tampilkan pop-up kustom
        return; // Hentikan proses jika belum menjawab
    }

    currentQuestionIndex++;
    if (currentQuestionIndex >= questions.length) {
        alert(`Permainan selesai! Skor akhir Anda: ${score}`);
        window.location.href = "quiz.html"; // Kembali ke halaman quiz
    } else {
        loadQuestion();
        hasAnswered = false; // Reset status jawaban untuk pertanyaan baru
    }
}   

// Fungsi untuk pindah ke pertanyaan sebelumnya
function previousQuestion() {
    if (currentQuestionIndex > 0) {
        currentQuestionIndex--;
        loadQuestion();
    }
}

// Event listeners
nextBtn.addEventListener("click", () => {
    if (nextBtn.textContent === "Selesai") {
        alert(`Permainan selesai! Skor akhir Anda: ${score}`);
        window.location.href = "quiz.html"; // Kembali ke halaman quiz
    } else {
        nextQuestion();
    }
});


prevBtn.addEventListener("click", previousQuestion);

// Load the first question when the page loads
loadQuestion();