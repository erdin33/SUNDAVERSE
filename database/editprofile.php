<?php
include 'cek_user.php';
include 'koneksi.php';
include 'skore.php';



$id_user = $_SESSION['id_user'];

// Ambil data user dari database
$query = "SELECT nama, email, foto FROM user WHERE id_user = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$stmt->bind_result($username, $email, $foto);
$stmt->fetch();
$stmt->close();

// Cek apakah file foto ada atau tidak
$foto_path = 'uploads/foto/' . $foto;
if (empty($foto) || !file_exists($foto_path)) {
    $foto_display = '<img src="../images/default_profile.png" alt="Profile Picture" width="100" height="100">';
} else {
    $foto_display = '<img src="' . htmlspecialchars($foto_path) . '" alt="Foto Profil" width="100" height="100">';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SundaVerse - Profil</title>
    <link rel="stylesheet" href="../style/profileedit.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="logo">
        <a href="index.html">Sunda<span>Verse</span></a>
    </div>
    <ul class="menu">
        <li><a href="index.php" id="home-link">Home</a></li>
        <li><a href="../aksara.php">Aksara</a></li>
        <li><a href="../quiz.html">Quiz</a></li>
        <li><a href="profile.php">Profile</a></li>
    </ul>
</nav>

<!-- CONTAINER -->
<div class="container">
    <div class="profile-card">
        <div class="profile-picture">
            <?php if (!empty($foto) && file_exists("../uploads/foto/" . $foto)): ?>
                <img src="../uploads/foto/<?= htmlspecialchars($foto) ?>" alt="Foto Profil" width="100" height="100">
            <?php else: ?>
                <img src="../images/default_profile.png" alt="Foto Profil" width="100" height="100">
            <?php endif; ?>
        </div>

        <!-- Nama user bisa diklik untuk edit -->
        <h2 class="editable" id="edit-toggle">
            <?= htmlspecialchars($username) ?>
            <svg class="edit-icon" width="20" height="20" viewBox="0 0 24 24">
                <path fill="#555" d="M14.06 9l1.44 1.44-9.5 9.5H4.5v-1.5l9.56-9.44M17.66 3c-.4 0-.78.15-1.08.44l-1.83 1.83 3.94 3.94 1.83-1.83a1.52 1.52 0 0 0 0-2.17l-1.77-1.77A1.47 1.47 0 0 0 17.66 3Z" />
            </svg>
        </h2>
        <p class="username"><?= htmlspecialchars($email) ?></p>
        <div class="score-badge">Total skor: <?= $total_skor ?></div>

        <!-- FORM EDIT -->
        <form id="edit-form" class="<?= isset($_GET['edit']) ? '' : 'hidden' ?>" method="POST" action="update_profile.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="foto">Foto Profil:</label>
                <input type="file" name="foto" accept="image/*">
                <small>Format: JPG, PNG, GIF. Maks: 2MB</small>
            </div>
            
            <div class="form-group">
                <label for="password">Konfirmasi Password:</label>
                <input type="password" name="password" placeholder="Masukkan password Anda" required>
            </div>
            
            <button type="submit" name="submit_profile" class="btn-update">Simpan Perubahan</button>
        </form>

        <!-- NOTIFIKASI -->
        <?php if (isset($_GET['update'])): ?>
            <p style="margin-top: 20px; font-weight: bold; color: <?= $_GET['update'] === 'success' ? 'green' : 'red' ?>;">
                <?= $_GET['update'] === 'success' ? 'Profil berhasil diperbarui.' : 'Password salah. Gagal memperbarui profil.' ?>
            </p>
        <?php endif; ?>
    </div>
</div>

<!-- FOOTER -->
<footer class="footer">
    <div class="judul">
        <h2>Sunda<span>Verse</span></h2>
    </div>
    <div class="link-kosong">
        <p>Beranda</p>
        <p>Tentang Kami</p>
        <p>Kontak</p>
    </div>
    <div class="lokasi">
        <p>Jl. Sunda Digital No.88, Jawa Barat</p>
    </div>
    <div class="copyright">
        <p>&copy; 2025 SundaVerse. All rights reserved.</p>
    </div>
</footer>

<!-- SCRIPT TOGGLER -->
<script>
    document.getElementById('edit-toggle').addEventListener('click', function () {
        document.getElementById('edit-form').classList.toggle('hidden');
    });
</script>

</body>
</html>
