document.addEventListener("DOMContentLoaded", () => {
    const pieces = document.querySelectorAll(".draggable");
    const targets = document.querySelectorAll(".target");
    const scoreElement = document.getElementById("score");
    const checkBtn = document.getElementById("check-btn");
    const nextBtn = document.getElementById("next-btn");
    const prevBtn = document.getElementById("prev-btn");

    let currentQuestionIndex = 0;
    let score = 0;

    // Data pertanyaan
    const questions = [
        {
            answers: ["ᮃᮘ᮪ᮓᮤ", "ᮠᮧᮚᮧᮀ", "ᮘᮧᮘᮧ"],
            correctOrder: [1, 2, 3], // Urutan yang benar
        },
        // Tambahkan lebih banyak pertanyaan di sini
    ];

    // Fungsi shuffle untuk mengacak array
    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    // Acak potongan puzzle saat halaman dimuat
    function resetPuzzle() {
        const pieceArray = Array.from(pieces);

        // Hapus semua potongan puzzle dari DOM
        const piecesContainer = document.querySelector(".pieces");
        piecesContainer.innerHTML = "";

        // Acak urutan potongan puzzle
        shuffle(pieceArray);

        // Tambahkan kembali potongan puzzle dalam urutan acak
        pieceArray.forEach((piece) => {
            piecesContainer.appendChild(piece);
        });

        // Bersihkan area target
        targets.forEach((target) => {
            target.innerHTML = "";
        });
    }

    // Event drag-and-drop
    pieces.forEach((piece) => {
        piece.addEventListener("dragstart", (e) => {
            e.target.classList.add("dragging");
            e.dataTransfer.setData("text/plain", e.target.id); // Simpan ID potongan puzzle
        });

        piece.addEventListener("dragend", () => {
            e.target.classList.remove("dragging"); // Hapus kelas "dragging" setelah penggeseran selesai
        });
    });

    targets.forEach((target) => {
        target.addEventListener("dragover", (e) => {
            e.preventDefault(); // Mengizinkan drop
        });

        target.addEventListener("drop", (e) => {
            if (!target.firstChild) {
                const draggedPieceId = e.dataTransfer.getData("text/plain"); // ID potongan puzzle
                const originalPiece = document.getElementById(draggedPieceId); // Temukan elemen potongan puzzle

                if (originalPiece) {
                    target.appendChild(originalPiece); // Pindahkan potongan puzzle ke area tujuan
                }
            }
        });
    });

    // Fungsi validasi jawaban
    checkBtn.addEventListener("click", () => {
        const currentQuestion = questions[currentQuestionIndex];
        let isCorrect = true;

        // Reset warna sebelum validasi
        targets.forEach((target) => {
            target.classList.remove("correct", "wrong");
            target.style.backgroundColor = ""; // Reset warna latar belakang
            target.style.borderColor = ""; // Reset warna border
        });

        targets.forEach((target, index) => {
            const pieceText = target.textContent.trim();
            const correctAnswer = currentQuestion.answers[currentQuestion.correctOrder[index] - 1];

            if (pieceText !== correctAnswer) {
                isCorrect = false;
                target.classList.add("wrong"); // Tandai sebagai salah
            } else {
                target.classList.add("correct"); // Tandai sebagai benar
            }
        });

        if (isCorrect) {
            alert("Selamat! Jawaban Anda benar!");
            score += 10; // Tambahkan skor
            scoreElement.textContent = `Skor: ${score}`;
            nextBtn.disabled = false; // Aktifkan tombol "Selanjutnya"
        } else {
            alert("Maaf, jawaban Anda salah. Coba lagi!");

            // Shuffle puzzle ulang jika jawaban salah
            resetPuzzle();
        }
    });

    // Navigasi ke pertanyaan berikutnya
    nextBtn.addEventListener("click", () => {
        if (currentQuestionIndex < questions.length - 1) {
            currentQuestionIndex++;
            resetPuzzle();
            nextBtn.disabled = true; // Nonaktifkan tombol "Selanjutnya" sampai menjawab
        } else {
            alert("Permainan selesai! Skor akhir Anda: " + score);
            window.location.href = "quiz.html"; // Kembali ke halaman quiz
        }
    });

    // Navigasi ke pertanyaan sebelumnya
    prevBtn.addEventListener("click", () => {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            resetPuzzle();
        }
    });

    // Shuffle puzzle saat halaman dimuat
    resetPuzzle();
});