<?php
include 'database/koneksi.php';

session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.html"); // Redirect ke halaman login
    exit(); // Pastikan script berhenti setelah redirect
}

// Data user dari session
$isLoggedIn = true;
$id_user = $_SESSION['id_user']; // Mengambil id_user dari session
$username = $_SESSION['username'] ?? ''; // Jika tidak ada, kosongkan username
$email = $_SESSION['email'] ?? ''; // Jika tidak ada, kosongkan email

// Optional: Tambahkan regenerasi session untuk keamanan
session_regenerate_id(true); // Mengganti session ID untuk mencegah session fixation


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SundaVerse</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/quiz.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <a href="database/index.php">Sunda<span>Verse</span></a>
        </div>
        <ul class="menu">
            <li><a href="database/index.php" id="home-link">Home</a></li>
            <li><a href="aksara.php">Aksara</a></li>
            <li><a href="quiz.html" id="quiz-link">Quiz</a></li>
            <li><a href="database/profile.php">Profile</a></li>
        </ul>
    </nav>

    <!--Section Daftar Quiz-->
    <section class="daftar">
        <div class="container">
            <h1>Pilih Jenis Quiz</h1>
            <div class="quiz-list">
                <div class="quiz-card" data-quiz="tebak-kata-sunda">
                    <h2>Quiz Tebak Kata Sunda</h2>
                    <p>Tebak arti dan makna kata dalam bahasa Sunda</p>
                </div>
                <div class="quiz-card" data-quiz="tebak-aksara-sunda">
                    <h2>Quiz Aksara Sunda</h2>
                    <p>Tebak kata dalam aksara Sunda</p>
                </div>
                <div class="quiz-card" data-quiz="dad-bahasa-sunda">
                    <h2>Quiz DaD Bahasa Sunda</h2>
                    <p>Tebak penempatan kata aksara sunda dalam satu kalimat</p>
                </div>
                <div class="quiz-card" data-quiz="dad-aksara-sunda">
                    <h2>Quiz DaD Aksara Sunda</h2>
                    <p>Tebak penempatan huruf bahasa sunda dalam satu kata</p>
                </div>
            </div>
            <button id="startQuizBtn">Mulai Quiz!</button>
        </div>
    </section>

    <!-- Pop-up Modal -->
    <div id="popupModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <p>Silakan pilih salah satu quiz terlebih dahulu!</p>
        </div>
    </div>

    <!---Section Footer-->
    <section class="footer">
        <div class="footer-content">
            <div class="judul">
                <h2>Sunda<span>Verse</span></h2>
            </div>
            <div class="link-kosong">
                <p>FAQ</p>
                <p>Terms of Service</p>
            </div>
            <div class="lokasi">
                <p>Informatika, Universitas Siliwangi</p>
            </div>
            <div class="copyright">
                <p>&copy; SundaVerse 2025. All Rights Reserved.</p>
            </div>
        </div>
    </section>

    <script src="script/quiz.js"></script>
</body>
</html>