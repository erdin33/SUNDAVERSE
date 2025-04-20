<?php
// login.php
session_start(); 
include 'koneksi.php'; // Mulai session

// Ambil data dari form
$username = $_POST['nama'];
$password = $_POST['password'];

// Query untuk cek user di database
$query = "SELECT * FROM user WHERE nama='$username'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    // Cek apakah password cocok
    if (password_verify($password, $user['password'])) {
        $_SESSION['id_user'] = $user['id_user'];  // Menyimpan id_user dari database
        $_SESSION['username'] = $username;   // Menyimpan username
        echo "Login berhasil!"; // Debug: Tampilkan jika login berhasil
        header("Location: ../database/index.php");  // Redirect setelah login sukses
        exit();
    } else {
        echo "<script>alert('Password salah!'); window.location.href = '../login.html';</script>";
    }
} else {
    echo "<script>alert('User tidak ditemukan!'); window.location.href = '../login.html';</script>";
}



