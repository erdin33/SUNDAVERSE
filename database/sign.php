<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($koneksi, "SELECT * FROM user WHERE nama='$nama' OR email='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username atau email sudah digunakan.'); window.location.href='../register.html';</script>";
    } else {
        $query = "INSERT INTO user (nama, email, password) VALUES ('$nama', '$email', '$password')";
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Pendaftaran berhasil. Silakan login.'); window.location.href='../login.html';</script>";
        } else {
            echo "Terjadi kesalahan: " . mysqli_error($koneksi);
        }
    }
}
?>
