document.addEventListener("DOMContentLoaded", () => {
    const scoreElement = document.getElementById("score");
    const checkBtn = document.getElementById("check-btn");
    const nextBtn = document.getElementById("next-btn");
    const prevBtn = document.getElementById("prev-btn");
    const questionDisplay = document.getElementById("question-text");
    const piecesContainer = document.querySelector(".pieces");
    const targetArea = document.querySelector(".target-area");

    let currentQuestionIndex = 0;
    let score = 0;
    let questions = [];

    function initializeQuiz() {
        showQuestion(currentQuestionIndex);
        updateNavButtons();
    }

    async function fetchQuestions() {
        try {
            const response = await fetch('./database/pertanyaan_DAD_bahasa.php');
            if (!response.ok) throw new Error('Network response was not ok');

            questions = await response.json();

            if (questions.length > 0) {
                setupQuestion(currentQuestionIndex);
            } else {
                alert("Tidak ada pertanyaan yang tersedia.");
            }
        } catch (error) {
            console.error('Error fetching questions:', error);
            alert("Gagal memuat pertanyaan. Silakan coba lagi nanti.");
        }
    }

    function setupQuestion(index) {
        if (!questions[index]) return;
        
        const currentQuestion = questions[index];
        if (questionDisplay && currentQuestion.question) {
            questionDisplay.textContent = currentQuestion.question;
        }

        piecesContainer.innerHTML = "";
        targetArea.innerHTML = "";

        const correctAnswerCount = currentQuestion.correctOrder.length;
        for (let i = 0; i < correctAnswerCount; i++) {
            const target = document.createElement("div");
            target.id = `target-${i+1}`;
            target.className = "target";
            targetArea.appendChild(target);
        }

        const answers = [...currentQuestion.answers];
        shuffle(answers);

        answers.forEach((answer, i) => {
            const piece = document.createElement("div");
            piece.id = `piece-${i+1}`;
            piece.className = "piece draggable";
            piece.draggable = true;
            piece.textContent = answer;
            piece.addEventListener("dragstart", dragStart);
            piece.addEventListener("dragend", dragEnd);
            piecesContainer.appendChild(piece);
        });

        const targets = document.querySelectorAll(".target");
        targets.forEach(target => {
            target.addEventListener("dragover", dragOver);
            target.addEventListener("drop", drop);
        });

        nextBtn.disabled = true;
    }

    function dragStart(e) {
        e.dataTransfer.setData("text/plain", e.target.id);
        e.target.classList.add("dragging");
    }

    function dragEnd(e) {
        e.target.classList.remove("dragging");
    }

    function dragOver(e) {
        e.preventDefault();
    }

    function drop(e) {
        e.preventDefault();
        const target = e.target;
        if (!target.hasChildNodes() && target.classList.contains("target")) {
            const draggedPieceId = e.dataTransfer.getData("text/plain");
            const draggedPiece = document.getElementById(draggedPieceId);
            if (draggedPiece) {
                if (draggedPiece.parentElement && draggedPiece.parentElement.classList.contains("target")) {
                    draggedPiece.parentElement.removeChild(draggedPiece);
                }
                target.appendChild(draggedPiece);
            }
        }
    }

    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    checkBtn.addEventListener("click", () => {
        const currentQuestion = questions[currentQuestionIndex];
        const targets = document.querySelectorAll(".target");
        let isCorrect = true;

        let allFilled = true;
        targets.forEach(target => {
            if (!target.firstChild) {
                allFilled = false;
            }
        });

        if (!allFilled) {
            document.getElementById("popup").style.display = "flex";
            return;
        }

        targets.forEach(target => {
            target.classList.remove("correct", "wrong");
        });

        const userAnswers = [];
        targets.forEach(target => {
            if (target.firstChild) {
                userAnswers.push(target.firstChild.textContent);
            }
        });

        const correctOrderCount = currentQuestion.correctOrder.length;
        for (let i = 0; i < correctOrderCount; i++) {
            const correctAnswerIndex = currentQuestion.correctOrder[i] - 1;
            const correctAnswer = currentQuestion.answers[correctAnswerIndex];
            if (userAnswers[i] !== correctAnswer) {
                isCorrect = false;
                targets[i].classList.add("wrong");
            } else {
                targets[i].classList.add("correct");
            }
        }

        if (isCorrect) {
            const questionValue = currentQuestion.nilai || 10;
            score += parseInt(questionValue);
            scoreElement.textContent = `Skor: ${score}`;
            document.getElementById("feedback").textContent = "Selamat! Jawaban Anda benar!";
            document.getElementById("feedback").className = "feedback correct";
        } else {
            document.getElementById("feedback").textContent = "Maaf, jawaban Anda salah.";
            document.getElementById("feedback").className = "feedback wrong";
        }

        nextBtn.disabled = false;
    });

    nextBtn.addEventListener("click", () => {
        if (currentQuestionIndex < questions.length - 1) {
            currentQuestionIndex++;
            setupQuestion(currentQuestionIndex);
            document.getElementById("feedback").textContent = "";
            document.getElementById("feedback").className = "feedback";
        } else {
            alert("Permainan selesai! Skor akhir Anda: " + score);
            saveScore(score);
            setTimeout(() => {
                window.location.href = "./quiz.php";
            }, 1500);
        }
    });

    prevBtn.addEventListener("click", () => {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            setupQuestion(currentQuestionIndex);
            document.getElementById("feedback").textContent = "";
            document.getElementById("feedback").className = "feedback";
        }
    });

    document.getElementById("close-popup").addEventListener("click", () => {
        document.getElementById("popup").style.display = "none";
    });

    function saveScore(finalScore) {
        const formData = new FormData();
        formData.append('quiz_type', quizType);
        formData.append('score', finalScore);

        fetch('./database/simpan_score.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            console.log('Score saved:', data);
            if (data.success) {
                const feedbackElement = document.getElementById("feedback");
                feedbackElement.textContent = data.message;
            }
        })
        .catch(error => {
            console.error('Error saving score:', error);
        });
    }

    // Jalankan fetch saat halaman dimuat
    fetchQuestions();
});
