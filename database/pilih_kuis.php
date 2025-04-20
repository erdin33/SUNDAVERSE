<?php
include 'koneksi.php'; // Pastikan koneksi berhasil

// Ambil data tipe kuis dari database
$result = $koneksi->query("SELECT id_kuis, nama_kuis FROM tipe_kuis");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pilih Tipe Kuis</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h2 {
            text-align: center;
        }
        .kuis-container {
            max-width: 400px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .tipe-kuis {
            margin-bottom: 15px;
        }
        .start-button {
            text-align: center;
        }
        button {
            padding: 10px 25px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        label {
            display: block;
            padding: 5px;
        }
    </style>
</head>
<body>

<div class="kuis-container">
    <h2>Pilih Tipe Kuis</h2>
    <form action="mulai_kuis.php" method="POST">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="tipe-kuis">
                <label>
                    <input type="radio" name="tipe_kuis" value="<?= $row['id_kuis'] ?>" required>
                    <?= htmlspecialchars($row['nama_kuis']) ?>
                </label>
            </div>
        <?php endwhile; ?>

        <div class="start-button">
            <button type="submit">Mulai</button>
        </div>
    </form>
</div>

</body>
</html>