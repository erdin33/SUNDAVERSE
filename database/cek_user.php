<?php

// Cek apakah user sudah login
$isLoggedIn = isset($_SESSION['id_user']);
$username = $isLoggedIn ? $_SESSION['username'] : null;
