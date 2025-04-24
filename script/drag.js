// Script.js

document.addEventListener("DOMContentLoaded", () => {
    const pieces = document.querySelectorAll(".draggable");
    const targets = document.querySelectorAll(".target");
    const finishButton = document.getElementById("finish-button");

    let draggedPiece = null;

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
            draggedPiece = e.target;
            e.target.classList.add("dragging");
        });

        piece.addEventListener("dragend", () => {
            draggedPiece = null;
            e.target.classList.remove("dragging");
        });
    });

    targets.forEach((target) => {
        target.addEventListener("dragover", (e) => {
            e.preventDefault(); // Mengizinkan drop
        });

        target.addEventListener("drop", (e) => {
            if (!target.firstChild && draggedPiece) {
                target.appendChild(draggedPiece);
            }
        });
    });

    // Fungsi validasi jawaban
    finishButton.addEventListener("click", () => {
        let isCorrect = true;

        // Reset warna sebelum validasi
        pieces.forEach((piece) => {
            piece.classList.remove("correct", "wrong");
        });

        targets.forEach((target, index) => {
            const piece = target.firstChild;
            if (!piece || piece.id !== `piece-${index + 1}`) {
                isCorrect = false;
                if (piece) {
                    piece.classList.add("wrong");
                }
            } else {
                piece.classList.add("correct");
            }
        });

        if (isCorrect) {
            alert("Selamat! Jawaban Anda benar!");
        } else {
            alert("Maaf, jawaban Anda salah. Coba lagi!");

            // Shuffle puzzle ulang jika jawaban salah
            resetPuzzle();
        }
    });

    // Shuffle puzzle saat halaman dimuat
    resetPuzzle();
});