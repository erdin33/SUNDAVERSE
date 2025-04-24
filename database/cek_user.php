<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.html");
    exit();
}

// Data user dari session
$isLoggedIn = true;
$id_user = $_SESSION['id_user'];
$username = $_SESSION['username'] ?? '';
$email = $_SESSION['email'] ?? '';
