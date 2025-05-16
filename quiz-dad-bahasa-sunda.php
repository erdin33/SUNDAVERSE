<?php
include 'database/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SundaVerse - Quiz Aksara Sunda</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/quiz-dad-aksara-sunda.css">
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
        <h1>Quiz Drag and Drop Bahasa Sunda</h1>
        <div class="score-container">
            <span id="score">Skor: 0</span>
        </div>
        
        <!-- Question Display -->
        <div class="question-container">
            <h2 id="question-text">Loading pertanyaan...</h2>
        </div>
        
        <div class="puzzle-container">
            <!-- Area Target - Will be populated dynamically -->
            <div class="target-area">
                <!-- Targets will be added via JavaScript -->
            </div>

            <!-- Potongan Puzzle - Will be populated dynamically -->
            <div class="pieces">
                <!-- Pieces will be added via JavaScript -->
            </div>
        </div>
        
        <div id="feedback" class="feedback"></div>
        
        <div class="navigation">
            <button id="prev-btn" class="nav-btn">Sebelumnya</button>
            <button id="check-btn" class="nav-btn">Cek Jawaban</button>
            <button id="next-btn" class="nav-btn" disabled>Selanjutnya</button>
        </div>
    </div>

    <!---Section Popup-->
    <div id="popup" class="popup">
        <div class="popup-content">
            <p>Tolong isi semua kotak target terlebih dahulu!</p>
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
    const quizType = 3;</script>
    <script src="script/quiz-dad-bahasa-sunda.js"></script>
</body>
</html>