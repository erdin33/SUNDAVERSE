<?php
// Include question fetching functionality
require_once 'database/pertanyaan.php';

// Default to quiz type 1 (tebak kata sunda)
$quizType = 1;
if(isset($_GET['type'])) {
    $quizType = (int)$_GET['type'];
}

// Get questions for this quiz type
$questions = getQuestionsByQuizType($quizType);

// Convert questions to JSON for JavaScript
$questionsJson = json_encode($questions);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SundaVerse</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/quiz-tebak-kata-sunda.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <a href="database/index.php">Sunda<span>Verse</span></a>
        </div>
        <ul class="menu">
            <li><a href="database/index.php">Home</a></li>
            <li><a href="aksara.php">Aksara</a></li>
            <li><a href="quiz.php" class="active">Quiz</a></li>
            <li><a href="database/profile.php">Profile</a></li>
        </ul>
    </nav>

    <!--Section Quiz-->
    <div class="quiz-container">
        <?php
        // Determine quiz title based on type
        $quizTitle = "";
        switch($quizType) {
            case 1:
                $quizTitle = "Tebak Kata Bahasa Sunda";
                $instruction = "Apa terjemahan kata berikut dalam bahasa Sunda?";
                break;
            case 2:
                $quizTitle = "Tebak Aksara Sunda";
                $instruction = "Pilih aksara Sunda yang tepat untuk kata berikut:";
                break;
            case 3:
                $quizTitle = "Drag and Drop Kata Sunda";
                $instruction = "Susun kata-kata berikut menjadi kalimat bahasa Sunda yang benar:";
                break;
            case 4:
                $quizTitle = "Drag and Drop Aksara Sunda";
                $instruction = "Susun aksara-aksara berikut menjadi kata dalam bahasa Sunda yang benar:";
                break;
            default:
                $quizTitle = "Quiz Bahasa Sunda";
                $instruction = "Jawab pertanyaan berikut:";
        }
        ?>
        <h1><?php echo $quizTitle; ?></h1>
        <div class="score-container">
            <span id="score">Skor: 0</span>
        </div>
        <div class="perintah">
            <p><?php echo $instruction; ?></p>
        </div>
        <h2 class="question" id="question">Loading question...</h2>
        <div id="answer-buttons" class="answer-buttons">
            <!-- Buttons will be added dynamically by JavaScript -->
        </div>
        <div id="feedback" class="feedback"></div>
        <div class="navigation">
            <button id="prev-btn" class="nav-btn"> Sebelum</button>
            <button id="next-btn" class="nav-btn">Selanjutnya ></button>
        </div>
    </div>

    <!---Section Popup-->
    <div id="popup" class="popup">
        <div class="popup-content">
            <p>Tolong isi terlebih dahulu soal berikut!</p>
            <button id="close-popup">OK</button>
        </div>
    </div>

    <!---Section Footer-->
    <section class="footer">
        <div class="footer-content">
            <div class="judul">
                <h2>Sunda<span>Verse</span></h2>
            </div>
            <div class="link-kosong">
                <a href="faq.html">FAQ</a>
                <a href="tos.html">Terms of Service</a>
            </div>
            <div class="lokasi">
                <p>Informatika, Universitas Siliwangi</p>
            </div>
            <div class="copyright">
                <p>&copy; SundaVerse 2025. All Rights Reserved.</p>
            </div>
        </div>
    </section>

    <script>
    // Pass PHP data to JavaScript
    const quizQuestions = <?php echo $questionsJson; ?>;
    const quizType = <?php echo $quizType; ?>;
    </script>
    <script src="script/quiz-tebak-kata-sunda.js"></script>
</body>
</html>