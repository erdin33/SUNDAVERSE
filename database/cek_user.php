<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.html");
    exit();
}

// Ambil informasi user dari session
$id_user = $_SESSION['id_user'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$foto = isset($_SESSION['foto']) ? $_SESSION['foto'] : null;


?>