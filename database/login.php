<?php
session_start();
include 'koneksi.php';

$username = $_POST['nama'];
$password = $_POST['password'];

$query = "SELECT * FROM user WHERE nama='$username'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    // Cocokkan password input dengan hash di database
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        header("Location: ../index.html");
        exit();
    } else {
        echo "<script>alert('Password salah!'); window.location.href = '../login.html';</script>";
    }
} else {
    echo "<script>alert('User tidak ditemukan!'); window.location.href = '../login.html';</script>";
}
?>
