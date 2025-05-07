<?php
// Set appropriate headers
header('Content-Type: application/json');

// Disable error display in output
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Start a try-catch block to handle errors gracefully
try {
    // Include necessary files
    include 'koneksi.php';
    include 'cek_user.php'; // Pastikan file ini memverifikasi login dan memulai session

    // Check if required data is present
    if (!isset($_POST['quiz_type']) || !isset($_POST['score'])) {
        throw new Exception('Data kuis tidak lengkap.');
    }

    // Ensure session is started and user_id exists
    if (!isset($_SESSION['id_user'])) {
        throw new Exception('User belum login.');
    }

    $userId   = $_SESSION['id_user'];
    $quizType = (int) $_POST['quiz_type'];
    $score    = (int) $_POST['score'];

    // Cek apakah user sudah pernah menyimpan skor untuk kuis ini
    $checkSql = "SELECT id_hasil, score FROM hasil_kuis WHERE id_user = ? AND id_kuis = ?";
    $checkStmt = $koneksi->prepare($checkSql);

    if (!$checkStmt) {
        throw new Exception('Kesalahan query: ' . $koneksi->error);
    }

    $checkStmt->bind_param("ii", $userId, $quizType);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $existingScoreId = $row['id_hasil'];
        $existingScore = (int) $row['score'];

        // Update jika skor baru lebih tinggi
        if ($score > $existingScore) {
            $updateSql = "UPDATE hasil_kuis SET score = ? WHERE id_hasil = ?";
            $updateStmt = $koneksi->prepare($updateSql);

            if (!$updateStmt) {
                throw new Exception('Kesalahan saat update: ' . $koneksi->error);
            }

            $updateStmt->bind_param("ii", $score, $existingScoreId);
            $updateStmt->execute();

            $success = $updateStmt->affected_rows > 0;
            $message = $success ? 'Skor berhasil diperbarui!' : 'Skor tetap, tidak perlu diperbarui.';
        } else {
            $success = false;
            $message = 'Skor baru lebih rendah atau sama, tidak diperbarui.';
        }
    } else {
        // Insert skor baru
        $insertSql = "INSERT INTO hasil_kuis (id_user, id_kuis, score) VALUES (?, ?, ?)";
        $insertStmt = $koneksi->prepare($insertSql);

        if (!$insertStmt) {
            throw new Exception('Kesalahan saat insert: ' . $koneksi->error);
        }

        $insertStmt->bind_param("iii", $userId, $quizType, $score);
        $insertStmt->execute();

        $success = $insertStmt->affected_rows > 0;
        $message = $success ? 'Skor berhasil disimpan!' : 'Gagal menyimpan skor.';
    }

    // Kirim response
    echo json_encode([
        'success' => $success,
        'message' => $message
    ]);

} catch (Exception $e) {
    // Log error ke sistem log server
    error_log('Score saving error: ' . $e->getMessage());

    // Kirim response error
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
}
