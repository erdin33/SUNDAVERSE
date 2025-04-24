<?php
// login.php
session_start(); 
include 'koneksi.php'; // Mulai session

// Ambil data dari form
$username_or_email = $_POST['nama'];  // Ambil input nama/email
$password = $_POST['password'];

// Query untuk cek user di database (bisa cek berdasarkan nama atau email)
$query = "SELECT * FROM user WHERE nama='$username_or_email' OR email='$username_or_email'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    // Cek apakah password cocok
    if (password_verify($password, $user['password'])) {
        $_SESSION['id_user'] = $user['id_user'];  // Menyimpan id_user dari database
        $_SESSION['username'] = $user['nama'];    // Menyimpan username
        $_SESSION['email'] = $user['email'];      // Menyimpan email (optional)

        echo "Login berhasil!"; // Debug: Tampilkan jika login berhasil
        header("Location: ../database/index.php");  // Redirect setelah login sukses
        exit();
    } else {
        echo "<script>alert('Password salah!'); window.location.href = '../login.html';</script>";
    }
} else {
    echo "<script>alert('User tidak ditemukan!'); window.location.href = '../login.html';</script>";
}
?>
