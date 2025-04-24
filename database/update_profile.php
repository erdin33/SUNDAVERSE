<?php
session_start();
include 'koneksi.php';

if (isset($_POST['submit_profile'])) {
    $id_user = $_SESSION['id_user'];
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $password_input = $_POST['password'];

    // Ambil password user saat ini dari DB
    $query = "SELECT password FROM user WHERE id_user = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $stmt->bind_result($password_hashed);
    $stmt->fetch();
    $stmt->close();

    // Cek apakah password cocok
    if (password_verify($password_input, $password_hashed)) {
        // Update profil
        $update_query = "UPDATE user SET nama = ?, email = ? WHERE id_user = ?";
        $stmt = $koneksi->prepare($update_query);
        $stmt->bind_param("ssi", $new_username, $new_email, $id_user);

        if ($stmt->execute()) {
            $_SESSION['username'] = $new_username;
            $_SESSION['email'] = $new_email;
            echo "<script>alert('Profil berhasil diperbarui!'); window.location.href = 'profile.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui profil. Silakan coba lagi.'); window.location.href = 'profile.php';</script>";
        }
    } else {
        echo "<script>alert('Password salah!'); window.location.href = 'editprofile.php';</script>";
    }
}
?>
