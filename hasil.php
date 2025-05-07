<?php
// Start session
// Include database connection
require_once 'database/koneksi.php';
include 'databse/cek_login.php';

// Get user information
$userSql = "SELECT nama FROM user WHERE id_user = ?";
$userStmt = $conn->prepare($userSql);
$userStmt->bind_param("i", $userId);
$userStmt->execute();
$userResult = $userStmt->get_result();
$userData = $userResult->fetch_assoc();
$userName = $userData['nama'];

// Get all quiz results for this user
$resultsSql = "SELECT h.id_hasil, h.id_kuis, h.score, t.nama_kuis 
               FROM hasil_kuis h
               JOIN tipe_kuis t ON h.id_kuis = t.id_kuis
               WHERE h.id_user = ?
               ORDER BY h.id_kuis";
$resultsStmt = $conn->prepare($resultsSql);
$resultsStmt->bind_param("i", $userId);
$resultsStmt->execute();
$resultsData = $resultsStmt->get_result();

// Get total possible scores for each quiz type
$quizScoresSql = "SELECT id_kuis, COUNT(*) * 10 as max_score 
                  FROM pertanyaan 
                  GROUP BY id_kuis";
$quizScoresResult = $conn->query($quizScoresSql);
$maxScores = [];
while ($scoreRow = $quizScoresResult->fetch_assoc()) {
    $maxScores[$scoreRow['id_kuis']] = $scoreRow['max_score'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Quiz - SundaVerse</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f7f4ef;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 5%;
            background-color: #008D36;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .logo a {
            color: #fff;
            text-decoration: none;
            font-size: 24px;
            font-weight: 700;
        }

        .logo span {
            color: #ffd700;
        }

        .menu {
            display: flex;
            list-style: none;
        }

        .menu li {
            margin-left: 30px;
        }

        .menu a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .menu a:hover {
            color: #ffd700;
        }

        .results-container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .results-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .results-header h1 {
            color: #008D36;
            margin-bottom: 10px;
        }

        .results-header p {
            color: #666;
            font-size: 18px;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .results-table th, .results-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .results-table th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: 600;
        }

        .quiz-type {
            font-weight: 500;
            color: #008D36;
        }

        .score {
            font-weight: 600;
        }

        .percentage {
            color: #666;
        }

        .progress-bar-container {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 10px;
            margin-top: 5px;
        }

        .progress-bar {
            height: 10px;
            border-radius: 10px;
        }

        .high {
            background-color: #4CAF50;
        }

        .medium {
            background-color: #FFC107;
        }

        .low {
            background-color: #F44336;
        }

        .no-results {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        .back-button {
            display: block;
            width: 200px;
            margin: 30px auto 0;
            padding: 10px;
            background-color: #008D36;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #006d29;
        }

        .footer {
            background-color: #008D36;
            padding: 30px 5%;
            margin-top: 50px;
        }

        .footer-content {
            color: #fff;
            text-align: center;
        }

        .judul h2 {
            margin-bottom: 20px;
        }

        .judul span {
            color: #ffd700;
        }

        .link-kosong, .lokasi {
            margin-bottom: 15px;
        }

        .copyright {
            margin-top: 20px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <a href="database/index.php">Sunda<span>Verse</span></a>
        </div>
        <ul class="menu">
            <li><a href="database/index.php" id="home-link">Home</a></li>
            <li><a href="aksara.php">Aksara</a></li>
            <li><a href="quiz.html" id="quiz-link">Quiz</a></li>
            <li><a href="database/profile.php">Profile</a></li>
        </ul>
    </nav>

    <!-- Results Container -->
    <div class="results-container">
        <div class="results-header">
            <h1>Hasil Quiz</h1>
            <p>Halo, <?php echo htmlspecialchars($userName); ?>! Berikut adalah hasil quiz yang telah kamu selesaikan.</p>
        </div>

        <?php if ($resultsData->num_rows > 0): ?>
            <table class="results-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Quiz</th>
                        <th>Skor</th>
                        <th>Progress</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $counter = 1;
                    while ($row = $resultsData->fetch_assoc()): 
                        $quizId = $row['id_kuis'];
                        $score = $row['score'];
                        $maxScore = isset($maxScores[$quizId]) ? $maxScores[$quizId] : 100;
                        $percentage = ($score / $maxScore) * 100;
                        
                        // Determine progress bar color
                        $progressClass = 'high';
                        if ($percentage < 50) {
                            $progressClass = 'low';
                        } elseif ($percentage < 75) {
                            $progressClass = 'medium';
                        }
                    ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td class="quiz-type"><?php echo htmlspecialchars($row['nama_kuis']); ?></td>
                            <td class="score"><?php echo $score; ?> / <?php echo $maxScore; ?></td>
                            <td>
                                <div class="percentage"><?php echo round($percentage); ?>%</div>
                                <div class="progress-bar-container">
                                    <div class="progress-bar <?php echo $progressClass; ?>" style="width: <?php echo $percentage; ?>%"></div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-results">
                <p>Kamu belum menyelesaikan quiz apapun. Ayo mulai belajar!</p>
            </div>
        <?php endif; ?>

        <a href="quiz.html" class="back-button">Kembali ke Quiz</a>
    </div>

    <!---Section Footer-->
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