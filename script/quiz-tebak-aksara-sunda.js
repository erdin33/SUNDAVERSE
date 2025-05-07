document.addEventListener('DOMContentLoaded', function() {
    const questionElement = document.getElementById('question');
    const answerButtonsElement = document.getElementById('answer-buttons');
    const feedbackElement = document.getElementById('feedback');
    const prevButton = document.getElementById('prev-btn');
    const nextButton = document.getElementById('next-btn');
    const scoreElement = document.getElementById('score');
    const popup = document.getElementById('popup');
    const closePopupButton = document.getElementById('close-popup');

    let currentQuestionIndex = 0;
    let score = 0;
    let userAnswers = [];
    let selectedAnswer = null;

    // Initialize quiz with data from PHP
    function initializeQuiz() {
        showQuestion(currentQuestionIndex);
        updateNavButtons();
    }

    function showQuestion(questionIndex) {
        resetState();
        
        if (questionIndex >= quizQuestions.length) {
            // All questions completed
            finishQuiz();
            return;
        }

        const question = quizQuestions[questionIndex];
        questionElement.innerText = question.question;

        // Create and add answer buttons
        question.answers.forEach(answer => {
            const button = document.createElement('button');
            button.innerText = answer.text;
            button.classList.add('answer-button');
            button.dataset.answerId = answer.id;
            button.dataset.correct = answer.isCorrect;
            
            // Check if user has already answered this question
            if (userAnswers[questionIndex] && userAnswers[questionIndex].answerId === answer.id) {
                button.classList.add('selected');
                selectedAnswer = button;
            }
            
            button.addEventListener('click', selectAnswer);
            answerButtonsElement.appendChild(button);
        });

        // Show feedback if user has already answered
        if (userAnswers[questionIndex]) {
            showFeedback(userAnswers[questionIndex].correct);
        }
    }

    function resetState() {
        feedbackElement.innerHTML = '';
        feedbackElement.className = 'feedback';
        selectedAnswer = null;
        
        while (answerButtonsElement.firstChild) {
            answerButtonsElement.removeChild(answerButtonsElement.firstChild);
        }
    }

    function selectAnswer(e) {
        const selectedButton = e.target;
    
        // Hapus semua tanda pilihan sebelumnya
        const buttons = answerButtonsElement.querySelectorAll('.answer-button');
        buttons.forEach(button => button.classList.remove('selected', 'correct', 'incorrect'));
    
        // Tandai tombol yang dipilih
        selectedButton.classList.add('selected');
        selectedAnswer = selectedButton;
    
        const correct = selectedButton.dataset.correct === 'true';
        const answerId = selectedButton.dataset.answerId;
    
        // Tandai warna sesuai kebenaran
        selectedButton.classList.add(correct ? 'correct' : 'incorrect');
    
        // Simpan jawaban pengguna
        userAnswers[currentQuestionIndex] = {
            answerId: answerId,
            correct: correct
        };
    
        // Ambil jawaban benar untuk ditampilkan di feedback
        const correctAnswerText = quizQuestions[currentQuestionIndex].answers.find(a => a.isCorrect).text;
        showFeedback(correct, correctAnswerText);
        buttons.forEach(button => {
            button.disabled = true;
        });
    }
    

    function showFeedback(isCorrect, correctAnswer) {
        const selectedText = selectedAnswer ? selectedAnswer.innerText : "-";
        feedbackElement.classList.remove("correct", "incorrect");
    
        if (isCorrect) {
            feedbackElement.innerHTML = `
                <p class="hasil">Benar!</p>
                <p class="judul-answer">Jawaban Anda "${selectedText}" Tepat.</p>
                <div class="coba">
                    <div class="answer-feedback">
                        <span class="answer-label">Jawaban Anda</span>
                        <p>${selectedText}</p>
                    </div>
                    <div class="answer-feedback">
                        <span class="answer-label">Jawaban Benar</span>
                        <p>${correctAnswer}</p>
                    </div>
                </div>
            `;
            feedbackElement.classList.add("correct");
        } else {
            feedbackElement.innerHTML = `
                <p class="hasil">Salah!</p>
                <p class="judul-answer">Jawaban Anda "${selectedText}" Tidak Tepat.</p>
                <div class="coba">
                    <div class="answer-feedback">
                        <span class="wrong-answer">Jawaban Anda</span>
                        <p>${selectedText}</p>
                    </div>
                    <div class="answer-feedback">
                        <span class="answer-label">Jawaban Benar</span>
                        <p>${correctAnswer}</p>
                    </div>
                </div>
            `;
            feedbackElement.classList.add("incorrect");
        }
    
        feedbackElement.style.display = "block";
    }
    

    function updateNavButtons() {
        prevButton.style.visibility = currentQuestionIndex > 0 ? 'visible' : 'hidden';
        nextButton.innerText = currentQuestionIndex === quizQuestions.length - 1 ? 'Selesai' : 'Selanjutnya >';
    }

    prevButton.addEventListener('click', () => {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            showQuestion(currentQuestionIndex);
            updateNavButtons();
        }
    });

    nextButton.addEventListener('click', () => {
        // Check if user has selected an answer
        if (!userAnswers[currentQuestionIndex] && currentQuestionIndex < quizQuestions.length) {
            popup.style.display = 'flex';
            return;
        }

        currentQuestionIndex++;
        
        if (currentQuestionIndex < quizQuestions.length) {
            showQuestion(currentQuestionIndex);
        } else {
            finishQuiz();
        }
        
        updateNavButtons();
    });

    closePopupButton.addEventListener('click', () => {
        popup.style.display = 'none';
    });

    function finishQuiz() {
        // Calculate final score
        let totalScore = 0;
        let totalPossibleScore = 0;
        
        for (let i = 0; i < quizQuestions.length; i++) {
            totalPossibleScore += quizQuestions[i].nilai || 10; // Default 10 points if not specified
            if (userAnswers[i] && userAnswers[i].correct) {
                totalScore += quizQuestions[i].nilai || 10;
            }
        }
        
        // Calculate percentage
        const finalScore = Math.round(totalScore);        
        // Update display
        questionElement.innerText = `Quiz Selesai!`;
        answerButtonsElement.innerHTML = '';
        scoreElement.innerText = `Skor Akhir: ${totalScore}`;
        
        // Create a message based on score
        let message = '';
        if (finalScore >= 80) {
            message = 'Luar biasa! Anda sangat menguasai materi ini.';
        } else if (finalScore >= 60) {
            message = 'Bagus! Anda memiliki pemahaman yang baik.';
        } else {
            message = 'Terus berlatih! Anda akan semakin baik.';
        }
        
        feedbackElement.innerHTML = message;
        feedbackElement.className = 'feedback final-feedback';
        
        // Save score to database
        saveScore(finalScore);
        
        // Hide navigation buttons
        prevButton.style.visibility = 'hidden';
        nextButton.style.visibility = 'hidden';
    }

    function saveScore(finalScore) {
        // Create form data to send
        const formData = new FormData();
        formData.append('quiz_type', quizType);
        formData.append('score', finalScore);
        
        // Send score to server using fetch API
        fetch('database/simpan_score.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Score saved:', data);
        })
        .catch(error => {
            console.error('Error saving score:', error);
        });
    }

    // Start the quiz
    initializeQuiz();
});