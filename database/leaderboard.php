<?php 
include 'koneksi.php';
include 'cek_user.php'; 
include 'peringkat.php';

$daftar_peringkat = getDaftarPeringkat($koneksi, 20); // Top 20 users
$current_user_id = $_SESSION['id_user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SundaVerse - Papan Peringkat</title>
    <link rel="stylesheet" href="../style/profile.css">
    <style>
        .leaderboard-container {
            max-width: 800px;
            margin: 80px auto 20px;
            padding: 20px;
        }
        
        .leaderboard-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .leaderboard-header h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .leaderboard-item {
            display: flex;
            align-items: center;
            background: white;
            margin-bottom: 15px;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .leaderboard-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }
        
        .leaderboard-item.current-user {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .rank-number {
            font-size: 1.5rem;
            font-weight: bold;
            width: 50px;
            text-align: center;
            margin-right: 20px;
        }
        
        .rank-number.top-3 {
            color: #f39c12;
            font-size: 2rem;
        }
        
        .rank-number.first {
            color: #FFD700;
        }
        
        .rank-number.second {
            color: #C0C0C0;
        }
        
        .rank-number.third {
            color: #CD7F32;
        }
        
        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 20px;
            object-fit: cover;
            border: 3px solid #f8f9fa;
        }
        
        .user-info {
            flex: 1;
        }
        
        .user-name {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .user-score {
            font-size: 1.1rem;
            opacity: 0.8;
        }
        
        .score-badge {
            background: #3498db;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 1.1rem;
        }
        
        .current-user .score-badge {
            background: rgba(255,255,255,0.2);
        }
        
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        
        .back-button:hover {
            color: #2980b9;
        }
        
        .trophy-icon {
            margin-right: 10px;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="index.php">Sunda<span>Verse</span></a>
        </div>
        <ul class="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="../aksara.php">Aksara</a></li>
            <li><a href="../quiz.php">Quiz</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
    </nav>

    <div class="leaderboard-container">
        <a href="profile.php" class="back-button">← Kembali ke Profile</a>
        
        <div class="leaderboard-header">
            <h1><span class="trophy-icon">🏆</span>Papan Peringkat</h1>
            <p>Top performers dalam SundaVerse</p>
        </div>

        <?php if (empty($daftar_peringkat)): ?>
            <div class="leaderboard-item">
                <p>Belum ada data peringkat tersedia.</p>
            </div>
        <?php else: ?>
            <?php foreach ($daftar_peringkat as $user): ?>
                <div class="leaderboard-item <?= $user['id_user'] == $current_user_id ? 'current-user' : '' ?>">
                    <div class="rank-number <?= $user['peringkat'] <= 3 ? 'top-3' : '' ?> 
                         <?= $user['peringkat'] == 1 ? 'first' : '' ?>
                         <?= $user['peringkat'] == 2 ? 'second' : '' ?>
                         <?= $user['peringkat'] == 3 ? 'third' : '' ?>">
                        <?php if ($user['peringkat'] == 1): ?>
                            🥇
                        <?php elseif ($user['peringkat'] == 2): ?>
                            🥈
                        <?php elseif ($user['peringkat'] == 3): ?>
                            🥉
                        <?php else: ?>
                            #<?= $user['peringkat'] ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="user-avatar">
                        <?php if (!empty($user['foto']) && file_exists("../uploads/foto/" . $user['foto'])): ?>
                            <img src="../uploads/foto/<?= htmlspecialchars($user['foto']) ?>" alt="Avatar" class="user-avatar">
                        <?php else: ?>
                            <img src="../images/default_profile.png" alt="Avatar" class="user-avatar">
                        <?php endif; ?>
                    </div>
                    
                    <div class="user-info">
                        <div class="user-name">
                            <?= htmlspecialchars($user['nama']) ?>
                            <?= $user['id_user'] == $current_user_id ? '(Anda)' : '' ?>
                        </div>
                        <div class="user-score">Total Kuis: <?= $user['total_skor'] ?> poin</div>
                    </div>
                    
                    <div class="score-badge">
                        <?= $user['total_skor'] ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <section class="footer">
        <div class="footer-content">
            <div class="judul">
                <h2>Sunda<span>Verse</span></h2>
            </div>
            <div class="link-kosong">
                <a href="../faq.html">FAQ</a>
                <a href="../tos.html">Terms of Service</a>
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