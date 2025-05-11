<?php 
include 'koneksi.php'; // Pastikan koneksi berhasil
include 'cek_user.php'; 
include 'skore.php';


$id_user = $_SESSION['id_user'];

// Ambil data user dari database
$query = "SELECT nama, email, foto FROM user WHERE id_user = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$stmt->bind_result($username, $email, $foto);
$stmt->fetch();
$stmt->close();// Ambil total skor user
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SundaVerse - Profile</title>
    <link rel="stylesheet" href="../style/profile.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="index.php">Sunda<span>Verse</span></a>
        </div>
        <ul class="menu">
            <li><a href="index.php" id="home-link">Home</a></li>
            <li><a href="../aksara.php">Aksara</a></li>
            <li><a href="../quiz.php">Quiz</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
    </nav>
    
    <div class="container">
        <div class="profile-card">
            <div class="profile-picture">
                <?php if (!empty($foto) && file_exists("../uploads/foto/" . $foto)): ?>
                    <img src="../uploads/foto/<?= htmlspecialchars($foto) ?>" alt="Foto Profil" width='100' height='100' >
                <?php else: ?>
                    <img src="../images/default_profile.png" alt="Foto Profil">
                <?php endif; ?>
            </div>

            <h2><?= $_SESSION['username']?></h2>
            <p class="username"><?= $_SESSION['email'] ?></p>
            <div class="score-badge">Total skor: <?= $total_skor ?></div>
        </div>
        
        <a href="editprofile.php" class="menu-card">
            <div class="menu-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 17.25V21H6.75L17.81 9.94L14.06 6.19L3 17.25ZM20.71 7.04C21.1 6.65 21.1 6.02 20.71 5.63L18.37 3.29C17.98 2.9 17.35 2.9 16.96 3.29L15.13 5.12L18.88 8.87L20.71 7.04Z" fill="black"/>
                </svg>
            </div>
            Ubah Profil
        </a>
        
        <a href="../faq.html" class="menu-card">
            <div class="menu-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 19H11V17H13V19ZM15.07 11.25L14.17 12.17C13.45 12.9 13 13.5 13 15H11V14.5C11 13.4 11.45 12.4 12.17 11.67L13.41 10.41C13.78 10.05 14 9.55 14 9C14 7.9 13.1 7 12 7C10.9 7 10 7.9 10 9H8C8 6.79 9.79 5 12 5C14.21 5 16 6.79 16 9C16 9.88 15.64 10.68 15.07 11.25Z" fill="black"/>
                </svg>
            </div>
            FAQ
        </a>
        
        <a href="../Tos.html" class="menu-card">
            <div class="menu-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.14 12.94C19.18 12.64 19.2 12.33 19.2 12C19.2 11.68 19.18 11.36 19.13 11.06L21.16 9.48C21.34 9.34 21.39 9.07 21.28 8.87L19.36 5.55C19.24 5.33 18.99 5.26 18.77 5.33L16.38 6.29C15.88 5.91 15.35 5.59 14.76 5.35L14.4 2.81C14.36 2.57 14.16 2.4 13.92 2.4H10.08C9.84 2.4 9.65 2.57 9.61 2.81L9.25 5.35C8.66 5.59 8.12 5.92 7.63 6.29L5.24 5.33C5.02 5.25 4.77 5.33 4.65 5.55L2.74 8.87C2.62 9.08 2.66 9.34 2.86 9.48L4.89 11.06C4.84 11.36 4.8 11.69 4.8 12C4.8 12.31 4.82 12.64 4.87 12.94L2.84 14.52C2.66 14.66 2.61 14.93 2.72 15.13L4.64 18.45C4.76 18.67 5.01 18.74 5.23 18.67L7.62 17.71C8.12 18.09 8.65 18.41 9.24 18.65L9.6 21.19C9.65 21.43 9.84 21.6 10.08 21.6H13.92C14.16 21.6 14.36 21.43 14.39 21.19L14.75 18.65C15.34 18.41 15.88 18.09 16.37 17.71L18.76 18.67C18.98 18.75 19.23 18.67 19.35 18.45L21.27 15.13C21.39 14.91 21.34 14.66 21.15 14.52L19.14 12.94ZM12 15.6C10.02 15.6 8.4 13.98 8.4 12C8.4 10.02 10.02 8.4 12 8.4C13.98 8.4 15.6 10.02 15.6 12C15.6 13.98 13.98 15.6 12 15.6Z" fill="black"/>
                </svg>
            </div>
            Terms of Service
        </a>
        
        <a href="logout.php" class="menu-card" onclick="openConfirmLogoutWindow(event)">
            <div class="menu-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.09 15.59L11.5 17L16.5 12L11.5 7L10.09 8.41L12.67 11H3V13H12.67L10.09 15.59ZM19 3H5C3.89 3 3 3.9 3 5V9H5V5H19V19H5V15H3V19C3 20.1 3.89 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3Z" fill="black"/>
                </svg>
            </div>
            Keluar
        </a>


    </div>
    
    <section class="footer">
        <div class="footer-content">
            <div class="judul">
                <h2>Sunda<span>Verse</span></h2>
            </div>
            <div class="link-kosong">
                <p>FAQ</p>
                <p>Terms of Service</p>
            </div>
            <div class="lokasi">
                <p>Informatika, Universitas Siliwangi</p>
            </div>
            <div class="copyright">
                <p>&copy; SundaVerse 2025. All Rights Reserved.</p>
            </div>
        </div>
    </section>
    
</body>
</html>