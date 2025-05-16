<?php
session_start();

if (isset($_POST['confirm_logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../login.html");
    exit();
} elseif (isset($_POST['cancel'])) {
    header("Location: profile.php"); // 
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Logout</title>
    <style>
        body {
            background-color: #0b2c57;
            color: white;
            font-family: sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .popup {
            background: #111;
            padding: 2em;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255,255,255,0.2);
            text-align: center;
        }
        button {
            padding: 0.5em 1.5em;
            margin: 0 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .yes { background-color: #2196F3; color: white; }
        .no { background-color: #ccc; color: black; }
    </style>
</head>
<body>
    <div class="popup">
        <p>Apakah Anda yakin ingin keluar?</p>
        <form method="POST">
            <button type="submit" name="confirm_logout" class="yes">Ya</button>
            <button type="submit" name="cancel" class="no">Batal</button>
        </form>
    </div>
</body>
</html>
