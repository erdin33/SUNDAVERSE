<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $userId = $_SESSION['id_user']; // pastikan ini sudah diset saat login

    $query = "UPDATE user SET nama=?, email=? WHERE id_user=?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ssi", $newUsername, $newEmail, $userId);

    if ($stmt->execute()) {
        $_SESSION['username'] = $newUsername;
        $_SESSION['email'] = $newEmail;
        header("Location: profile.php?success=1");
    } else {
        echo "Gagal mengupdate profil: " . $koneksi->error;
    }

    $stmt->close();
    $koneksi->close();
}
?>
