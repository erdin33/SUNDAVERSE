<?php
// Start session to get user ID
session_start();

// Include database connection
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Return error response
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Check if required data is present
if (!isset($_POST['quiz_type']) || !isset($_POST['score'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Missing required data']);
    exit;
}

$userId = $_SESSION['user_id'];
$quizType = (int)$_POST['quiz_type'];
$score = (int)$_POST['score'];

// Check if user already has a score for this quiz
$checkSql = "SELECT id_hasil FROM hasil_kuis WHERE id_user = ? AND id_kuis = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ii", $userId, $quizType);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    // Update existing score if new score is higher
    $row = $checkResult->fetch_assoc();
    $existingScoreId = $row['id_hasil'];
    
    $updateSql = "UPDATE hasil_kuis SET score = ? WHERE id_hasil = ? AND score < ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("iii", $score, $existingScoreId, $score);
    $updateStmt->execute();
    
    $success = $updateStmt->affected_rows > 0;
    $message = $success ? 'Score updated successfully' : 'No update needed (current score is higher)';
} else {
    // Insert new score
    $insertSql = "INSERT INTO hasil_kuis (id_user, id_kuis, score) VALUES (?, ?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("iii", $userId, $quizType, $score);
    $insertStmt->execute();
    
    $success = $insertStmt->affected_rows > 0;
    $message = $success ? 'Score saved successfully' : 'Failed to save score';
}

// Return response
header('Content-Type: application/json');
echo json_encode(['success' => $success, 'message' => $message]);
?>