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
    let answeredQuestions = [];
    let userAnswersState = [];

    function initializeQuiz() {
        showQuestion(currentQuestionIndex);
        updateNavButtons();
    }

    async function fetchQuestions() {
        try {
            const response = await fetch('./database/pertanyaan_DAD.php');
            if (!response.ok) throw new Error('Network response was not ok');

            questions = await response.json();

            if (questions.length > 0) {
                answeredQuestions = new Array(questions.length).fill(false);
                userAnswersState = new Array(questions.length).fill(null);
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

        let pieces = [...currentQuestion.answers];
        if (!answeredQuestions[index]) {
            shuffle(pieces);
        }

        if (answeredQuestions[index] && userAnswersState[index]) {
            const savedAnswers = userAnswersState[index];
            
            savedAnswers.forEach((answer, i) => {
                if (answer) {
                    const target = document.getElementById(`target-${i+1}`);
                    const piece = document.createElement("div");
                    piece.id = `piece-placed-${i+1}`;
                    piece.className = "piece draggable answered";
                    piece.draggable = false;
                    piece.textContent = answer;
                    
                    const correctOrderIndex = currentQuestion.correctOrder[i] - 1;
                    const correctAnswer = currentQuestion.answers[correctOrderIndex];
                    if (answer === correctAnswer) {
                        target.classList.add("correct");
                    } else {
                        target.classList.add("wrong");
                    }
                    
                    target.appendChild(piece);
                }
            });
            
            const isCorrect = savedAnswers.every((answer, i) => {
                const correctOrderIndex = currentQuestion.correctOrder[i] - 1;
                return answer === currentQuestion.answers[correctOrderIndex];
            });
            
            if (isCorrect) {
                document.getElementById("feedback").textContent = "Selamat! Jawaban Anda benar!";
                document.getElementById("feedback").className = "feedback correct";
            } else {
                document.getElementById("feedback").textContent = "Maaf, jawaban Anda salah.";
                document.getElementById("feedback").className = "feedback wrong";
            }
        } else {
            pieces.forEach((answer, i) => {
                const piece = document.createElement("div");
                piece.id = `piece-${i+1}`;
                piece.className = "piece draggable";
                piece.draggable = !answeredQuestions[index];
                piece.textContent = answer;
                
                if (!answeredQuestions[index]) {
                    piece.addEventListener("dragstart", dragStart);
                    piece.addEventListener("dragend", dragEnd);
                } else {
                    piece.classList.add("answered");
                }
                
                piecesContainer.appendChild(piece);
            });
            
            document.getElementById("feedback").textContent = "";
            document.getElementById("feedback").className = "feedback";
        }

        const targets = document.querySelectorAll(".target");
        targets.forEach(target => {
            target.addEventListener("dragover", dragOver);
            target.addEventListener("drop", drop);
        });
        
        checkBtn.disabled = answeredQuestions[currentQuestionIndex];
        
        updateNavButtons();
        updateQuestionIndicators();
    }

    function updateNavButtons() {
        prevBtn.disabled = currentQuestionIndex === 0;        
        nextBtn.disabled = !answeredQuestions[currentQuestionIndex];
        
        if (nextBtn.disabled) {
            nextBtn.classList.add("disabled-button");
            nextBtn.title = "Anda harus menjawab pertanyaan ini terlebih dahulu";
        } else {
            nextBtn.classList.remove("disabled-button");
            nextBtn.title = "";
        }
    }
    
    function createQuestionIndicators() {
        const indicatorContainer = document.createElement("div");
        indicatorContainer.className = "question-indicator";
        
        questions.forEach((_, index) => {
            const dot = document.createElement("div");
            dot.className = "question-dot";
            dot.dataset.index = index;
            dot.addEventListener("click", () => {
                if (answeredQuestions[index] || index === findNextUnansweredIndex()) {
                    saveCurrentState();
                    currentQuestionIndex = parseInt(dot.dataset.index);
                    setupQuestion(currentQuestionIndex);
                } else {
                    showRequiredAnswerMessage();
                }
            });
            indicatorContainer.appendChild(dot);
        });
        
        const quizContainer = document.querySelector(".quiz-container");
        if (quizContainer) {
            quizContainer.insertBefore(indicatorContainer, quizContainer.firstChild);
        }
    }
    
    function findNextUnansweredIndex() {
        if (!answeredQuestions[currentQuestionIndex]) {
            return currentQuestionIndex;
        }
        
        for (let i = 0; i < answeredQuestions.length; i++) {
            if (!answeredQuestions[i]) {
                return i;
            }
        }
        
        return answeredQuestions.length - 1;
    }
    
    function showRequiredAnswerMessage() {
        const feedbackElement = document.getElementById("feedback");
        feedbackElement.textContent = "Silakan jawab pertanyaan saat ini terlebih dahulu";
        feedbackElement.className = "feedback required";
        
        setTimeout(() => {
            if (feedbackElement.className === "feedback required") {
                feedbackElement.textContent = "";
                feedbackElement.className = "feedback";
            }
        }, 2000);
    }
    
    function updateQuestionIndicators() {
        const dots = document.querySelectorAll(".question-dot");
        dots.forEach((dot, index) => {
            dot.classList.remove("current", "answered", "available");
            
            if (index === currentQuestionIndex) {
                dot.classList.add("current");
            }
            
            if (answeredQuestions[index]) {
                dot.classList.add("answered");
            }
            
            if (answeredQuestions[index] || index === findNextUnansweredIndex()) {
                dot.classList.add("available");
            }
        });
    }

    function saveCurrentState() {
        if (!answeredQuestions[currentQuestionIndex]) return;
        
        const targets = document.querySelectorAll(".target");
        const currentAnswers = [];
        
        targets.forEach(target => {
            if (target.firstChild) {
                currentAnswers.push(target.firstChild.textContent);
            } else {
                currentAnswers.push(null);
            }
        });
        
        userAnswersState[currentQuestionIndex] = currentAnswers;
    }

    function dragStart(e) {
        if (!answeredQuestions[currentQuestionIndex]) {
            e.dataTransfer.setData("text/plain", e.target.id);
            e.target.classList.add("dragging");
        } else {
            e.preventDefault();
        }
    }

    function dragEnd(e) {
        e.target.classList.remove("dragging");
    }

    function dragOver(e) {
        e.preventDefault();
    }

    function drop(e) {
        e.preventDefault();
        if (answeredQuestions[currentQuestionIndex]) return;
        
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
        if (answeredQuestions[currentQuestionIndex]) return;
        
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
            } else {
                userAnswers.push(null);
            }
        });

        userAnswersState[currentQuestionIndex] = userAnswers;

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

        answeredQuestions[currentQuestionIndex] = true;
        checkBtn.disabled = true;
        
        const pieces = document.querySelectorAll(".piece");
        pieces.forEach(piece => {
            piece.draggable = false;
            piece.classList.add("answered");
        });

        updateNavButtons();
        updateQuestionIndicators();
    });

    nextBtn.addEventListener("click", () => {
        if (!answeredQuestions[currentQuestionIndex]) {
            showRequiredAnswerMessage();
            return;
        }
        
        if (currentQuestionIndex < questions.length - 1) {
            saveCurrentState();
            currentQuestionIndex++;
            setupQuestion(currentQuestionIndex);
        } else {
            alert("Permainan selesai! Skor akhir Anda: " + score);
            saveScore(score);
            setTimeout(() => {
                window.location.href = "./quiz.php";
            }, 1000);
        }
    });

    prevBtn.addEventListener("click", () => {
        if (currentQuestionIndex > 0) {
            saveCurrentState();
            currentQuestionIndex--;
            setupQuestion(currentQuestionIndex);
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

    const style = document.createElement('style');
    style.textContent = `
        .piece.answered {
            opacity: 0.8;
            cursor: not-allowed;
        }
        .question-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }
        .disabled-button {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .feedback.required {
            color: #ff9800;
            font-weight: bold;
        }
    `;
    document.head.appendChild(style);

    function init() {
        fetchQuestions().then(() => {
            if (questions.length > 0) {
                createQuestionIndicators();
                updateQuestionIndicators();
            }
        });
    }

    init();
});