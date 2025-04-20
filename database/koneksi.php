<?php
$host = 'localhost';     // Host database
$username = 'root';      // Username database
$password = '';          // Password database
$database = 'sundaverse';   // Nama database

// Membuat koneksi menggunakan mysqli_connect()
$koneksi = mysqli_connect($host, $username, $password, $database);

// Memeriksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

echo "Koneksi berhasil!";
?>