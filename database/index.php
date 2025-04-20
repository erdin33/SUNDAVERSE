<<?php
session_start(); // Mulai session
include 'koneksi.php'; // Pastikan koneksi berhasil

$isLoggedIn = isset($_SESSION['id_user']);  // Periksa apakah user sudah login

echo "<pre>";
print_r($_SESSION);  // Debug untuk menampilkan session
echo "</pre>";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SundaVerse</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../index.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <a href="index.php">Sunda<span>Verse</span></a>
        </div>
        <ul class="menu">
            <li><a href="index.php" id="home-link">Home</a></li>
            <li><a href="aksara.html">Aksara</a></li>
            <li><a href="quiz.html">Quiz</a></li>
            <li><a href="profile.html">Profile</a></li>
        </ul>
    </nav>

    <!---Section Atas-->
    <section id="satu-home">
        <div class="satu-content">
            <h1>Ngamumulé Basa Sunda Ti Ayeuna!</h1>
            <p>Diajar basa Sunda kiwari langkung gampang!<br>ku <span><span1>Sunda</span1>Verse</span>, anjeun tiasa latihan aksara Sunda, terjemahan,<br>jeung kalimah sapopoe.</p>
            <?php if (!$isLoggedIn): ?>
                <div>
                    <button><a href="../login.html">Masuk / Login!</a></button>
                </div>
            <?php endif; ?>
        </div>
        <div class="satu-image">    
            <img src="foto-home.png" alt="seni Sunda">
        </div>
    </section>

    <!-----Section Tengah-->
    <section class="dua-home">
        <div class="dua-content">
            <h2>Ngulik Sunda</h2>
        </div>
        <div class="dua-border">
            <h3>Sejarah Sunda</h3>
            <div class="paraghrap">
                <p>Bahasa Sunda memiliki sejarah panjang yang berkembang sejak zaman kerajaan di Tatar Sunda. Penggunaannya sudah ada sejak masa Kerajaan Tarumanegara dan semakin berkembang pada era Kerajaan Sunda dan Galuh.</p>
            </div>
            <div class="paraghrap">
                <p>Pada abad ke-16, setelah runtuhnya Kerajaan Pakuan Pajajaran, bahasa Sunda mulai dipengaruhi oleh bahasa Jawa dan Arab, terutama karena masuknya Islam ke wilayah Sunda. Meskipun begitu, bahasa Sunda tetap bertahan dan berkembang dengan berbagai dialek di daerah Priangan, Banten, Cirebon, dan lainnya.</p>
            </div>
            <div class="paraghrap">
                <p>Aksara Sunda Kuno juga menjadi bagian penting dalam sejarah bahasa Sunda. Aksara ini digunakan dalam prasasti dan naskah kuno sebelum akhirnya tergeser oleh aksara Latin dan Pegon. Saat ini, aksara Sunda kembali diperkenalkan sebagai warisan budaya yang perlu dilestarikan. Hingga kini, bahasa Sunda masih digunakan oleh jutaan orang dan terus berkembang dengan berbagai bentuk, termasuk dalam sastra, media, dan pendidikan.</p>
            </div>
        </div>
    </section>

    <!---Section bawah-->
    <section class="tiga-home">
        <div class="tiga-content">
            <p>Sebagai bagian dari peradaban yang telah ada sejak zaman kuno, bahasa Sunda tidak hanya tercermin dalam percakapan dan tulisan, tetapi juga dalam berbagai peninggalan sejarah, seperti candi-candi, yang menjadi bukti kejayaan masa lampau.</p>
        </div>
        <div class="tiga-image">
            <div class="image1">
                <img src="candi1.jpeg" alt="Candi Bladongan">
                <p><b>Candi Bladongan</b></p>
            </div>
            <div class="image2">
                <img src="candi2.jpeg" alt="Candi Cangkuang">
                <p><b>Candi Cangkuang</b></p>
            </div>
            <div class="image3">
                <img src="candi3.png" alt="Candi Jiwa">
                <p><b>Candi Jiwa</b></p>
            </div>
        </div>
    </section>

    <!---Section Bawah Kedua-->
    <section class="sblm-ftr">
        <div class="sblm-content">
            <p>Bahasa Sunda juga memiliki sistem tulisan sendiri yang dikenal sebagai Aksara Sunda Kuno. Aksara ini digunakan sejak zaman kerajaan dan masih dilestarikan hingga kini. Mau belajar tentang aksara Sunda? Yuk, kunjungin halaman <a href="aksara.html">Aksara!</a></p>
        </div>
    </section>
    
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

    <script src="index.js"></script>
</body>
</html>