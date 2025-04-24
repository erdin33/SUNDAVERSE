<?php
include 'cek_user.php';
include 'koneksi.php';
include 'skore.php';
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
        <li><a href="index.html">Home</a></li>
        <li><a href="aksara.html">Aksara</a></li>
        <li><a href="quiz.html">Quiz</a></li>
        <li><a href="profile.php" class="active">Profile</a></li>
    </ul>
</nav>

<!-- CONTAINER -->
<div class="container">
    <div class="profile-card">
        <div class="profile-picture">
            <!-- Bisa tambahkan icon user di sini -->
            <svg viewBox="0 0 24 24"><path fill="#666" d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-3.33 0-10 1.67-10 5v3h20v-3c0-3.33-6.67-5-10-5Z"/></svg>
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
        <form id="edit-form" class="hidden" method="POST" action="update_profile.php">
            <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" required>
            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
            <input type="password" name="password" placeholder="Konfirmasi password" required>
            <button type="submit" name="submit_profile">Simpan Perubahan</button>
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
