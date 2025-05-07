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
    
    // Check if user is logged in
    include 'cek_user.php';
    
    // Check if required data is present
    if (!isset($_POST['quiz_type']) || !isset($_POST['score'])) {
        throw new Exception('Missing required data');
    }
    
    // Ensure session is started and user_id exists
    if (!isset($_SESSION['id_user'])) {
        throw new Exception('User not logged in');
    }
    
    $userId = $_SESSION['id_user'];
    $quizType = (int)$_POST['quiz_type'];
    $score = (int)$_POST['score'];
    
    // Check if user already has a score for this quiz
    $checkSql = "SELECT id_hasil FROM hasil_kuis WHERE id_user = ? AND id_kuis = ?";
    $checkStmt = $koneksi->prepare($checkSql);
    
    if (!$checkStmt) {
        throw new Exception('Database prepare error: ' . $koneksi->error);
    }
    
    $checkStmt->bind_param("ii", $userId, $quizType);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows > 0) {
        // Update existing score if new score is higher
        $row = $checkResult->fetch_assoc();
        $existingScoreId = $row['id_hasil'];
        
        $updateSql = "UPDATE hasil_kuis SET score = ? WHERE id_hasil = ? AND score < ?";
        $updateStmt = $koneksi->prepare($updateSql);
        
        if (!$updateStmt) {
            throw new Exception('Database prepare error: ' . $koneksi->error);
        }
        
        $updateStmt->bind_param("iii", $score, $existingScoreId, $score);
        $updateStmt->execute();
        
        $success = $updateStmt->affected_rows > 0;
        $message = $success ? 'Skor berhasil diperbarui!' : 'Tidak ada pembaruan diperlukan (skor saat ini lebih tinggi)';
    } else {
        // Insert new score
        $insertSql = "INSERT INTO hasil_kuis (id_user, id_kuis, score) VALUES (?, ?, ?)";
        $insertStmt = $koneksi->prepare($insertSql);
        
        if (!$insertStmt) {
            throw new Exception('Database prepare error: ' . $koneksi->error);
        }
        
        $insertStmt->bind_param("iii", $userId, $quizType, $score);
        $insertStmt->execute();
        
        $success = $insertStmt->affected_rows > 0;
        $message = $success ? 'Skor berhasil disimpan!' : 'Gagal menyimpan skor';
    }
    
    // Return success response
    echo json_encode(['success' => $success, 'message' => $message]);

} catch (Exception $e) {
    // Log the error to a file
    error_log('Score saving error: ' . $e->getMessage(), 0);
    
    // Return error as JSON
    echo json_encode([
        'success' => false, 
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
}
?>