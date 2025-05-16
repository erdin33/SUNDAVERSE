<?php 
session_start(); 
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SundaVerse</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/aksara.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <a href="index.php">Sunda<span>Verse</span></a>
        </div>
        <ul class="menu">
            <li><a href="database/index.php">Home</a></li>
            <li><a href="../aksara.php" class="active" >Aksara</a></li>
            <li><a href="quiz.php">Quiz</a></li>
            <li><a href="database/profile.php">Profile</a></li>
        </ul>
    </nav>

    <!--Section Header-->
    <section class="header">
        <div class="header-content">
            <h1>TAHUKAH KAMU SEJARAH AKSARA SUNDA?</h1>
        </div>
    </section>

    <!---Section utama--->
    <section class="utama">
        <div class="utama-border">
            <p><b>Tahukah kamu bahwa masyarakat Sunda memiliki sistem tulisan khas yang telah ada sejak zaman kerajaan?</b> Aksara Sunda merupakan salah satu warisan budaya yang berkembang sejak abad ke-14 dan digunakan untuk mencatat berbagai naskah penting pada masa Kerajaan Sunda dan Pajajaran. Aksara ini berasal dari aksara Brahmi yang berkembang di Nusantara dan memiliki bentuk unik yang berbeda dari aksara Jawa atau Bali.</p>
            <p>Pada masa kejayaannya, aksara Sunda digunakan dalam prasasti dan naskah kuno, seperti Prasasti Kawali yang ditemukan di Ciamis serta Naskah Sanghyang Siksa Kandang Karesian yang berisi ajaran moral masyarakat Sunda. Namun, setelah runtuhnya Kerajaan Sunda, penggunaannya mulai tergeser oleh aksara Arab Pegon dan Latin yang diperkenalkan oleh kolonial Belanda.</p>
            <p>Kini, aksara Sunda kembali dihidupkan dan diajarkan dalam kurikulum sekolah di Jawa Barat. Pada tahun 2008, pemerintah daerah resmi menetapkan aksara Sunda sebagai identitas budaya dan memasukkannya ke dalam Unicode, sehingga bisa digunakan dalam perangkat digital. Beberapa nama jalan dan dokumen resmi di Jawa Barat pun mulai menggunakan aksara ini sebagai upaya pelestarian.</p>
            <p>Dengan sejarah panjang dan perannya yang kembali diakui, aksara Sunda menjadi simbol kebanggaan bagi masyarakat Sunda. Jadi, sudahkah kamu mencoba menulis namamu dalam aksara Sunda?</p>
        </div>
    </section>

    <!--Section Swara-->
    <section class="swara">
        <div class="judul-content">
            <h2>Hayu diajar Aksara Sunda!</h2>
        </div>
        <div class="judul-aksara">
            <p>Aksara Swara (Huruf Vokal Mandiri)</p>
        </div>
        <div class="swara-r1">
            <div class="aksara-swara">
                <p>ᮃ<br>a</p>
            </div>
            <div class="aksara-swara">
                <p>ᮄ<br>i</p>
            </div>
            <div class="aksara-swara">
                <p>ᮅ<br>u</p>
            </div>
            <div class="aksara-swara">
                <p>ᮆ<br>é</p>
            </div>
            <div class="aksara-swara">
                <p>ᮇ<br>o</p>
            </div>
            <div class="aksara-swara">
                <p>ᮈ<br>e</p>
            </div>
            <div class="aksara-swara">
                <p>ᮉ<br>eu</p>
            </div>
        </div>
    </section>

    <!--Section Ngalagena-->
    <section class="ngalagena">
        <div class="judul-aksara2">
            <p>Aksara Ngalagena (Huruf Konsonan Dasar)</p>
        </div>
        <div class="ngalagena-r">
            <div class="ngalagena1">
                <p>ᮊ<br>ka</p>
            </div>
            <div class="ngalagena1">
                <p>ᮌ<br>ga</p>
            </div>
            <div class="ngalagena1">
                <p>ᮍ<br>nga</p>
            </div>
            <div class="ngalagena1">
                <p>ᮎ<br>ca</p>
            </div>
            <div class="ngalagena1">
                <p>ᮏ<br>ja</p>
            </div>
            <div class="ngalagena1">
                <p>ᮑ<br>nya</p>
            </div>
            <div class="ngalagena1">
                <p>ᮒ<br>ta</p>
            </div>
            <div class="ngalagena1">
                <p>ᮓ<br>da</p>
            </div>
        </div>
        <div class="ngalagena-r">
            <div class="ngalagena1">
                <p>ᮖ<br>fa</p>
            </div>
            <div class="ngalagena1">
                <p>ᮔ<br>na</p>
            </div>
            <div class="ngalagena1">
                <p>ᮕ<br>pa</p>
            </div>
            <div class="ngalagena1">
                <p>ᮘ<br>ba</p>
            </div>
            <div class="ngalagena1">
                <p>ᮙ<br>ma</p>
            </div>
            <div class="ngalagena1">
                <p>ᮚ<br>ya</p>
            </div>
            <div class="ngalagena1">
                <p>ᮛ<br>ra</p>
            </div>
            <div class="ngalagena1">
                <p>ᮜ<br>la</p>
            </div>
        </div>
        <div class="ngalagena-r">
            <div class="ngalagena1">
                <p>ᮝ<br>wa</p>
            </div>
            <div class="ngalagena1">
                <p>ᮠ<br>ha</p>
            </div>
        </div>
    </section>

    <!--Section Rarangken-->
    <section class="rarangken">
        <div class="judul-aksara3">
            <p>Rarangkén (Tanda Diakritik untuk Mengubah Vokal)</p>
        </div>
        <div class="tanda-r">
            <div class="tanda1">
                <p>᮪<br>Pamaéh<br>/ka/ jadi /k/</p>
            </div>
            <div class="tanda1">
                <p>ᮤ /<br>Panghulu<br>/a/ jadi /i</p>
            </div>
            <div class="tanda1">
                <p>ᮥ <br>Panghulu<br>/a/ jadi /u/</p>
            </div>
            <div class="tanda1">
                <p>ᮦ<br>Paneuleung<br>/a/ jadi /é/</p>
            </div>
        </div>
        <div class="tanda-r">
            <div class="tanda1">
                <p>ᮧ<br>Panéléng<br>/a/ jadi /o/</p>
            </div>
            <div class="tanda1">
                <p>ᮨ<br>Pamingkal<br>/a/ jadi /e/</p>
            </div>
            <div class="tanda1">
                <p>ᮩ<br>Panolong<br>/a/ jadi /eu/</p>
            </div>
        </div>
    </section>

    <!--Section Angka-->
    <section class="angka">
        <div class="judul-content2">
            <p>Angka di Aksara Sunda</p>
        </div>
        <div class="angka-r">
            <div class="angka1">
                <p>᮰<br>0</p>
            </div>
            <div class="angka1">
                <p>᮱<br>1</p>
            </div>
            <div class="angka1">
                <p>᮲<br>2</p>
            </div>
            <div class="angka1">
                <p>᮳<br>3</p>
            </div>
            <div class="angka1">
                <p>᮴<br>4</p>
            </div>
            <div class="angka1">
                <p>᮵<br>5</p>
            </div>
            <div class="angka1">
                <p>᮶<br>6</p>
            </div>
            <div class="angka1">
                <p>᮷<br>7</p>
            </div>
        </div>
        <div class="angka-r">
            <div class="angka1">
                <p>᮸<br>8</p>
            </div>
            <div class="angka1">
                <p>᮹<br>9</p>
            </div>
        </div>
    </section>

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

    <script src="aksara.js"></script>
</body>
</html>