<?php
// Include database connection
require_once 'koneksi.php';

// Function to get questions by quiz type
function getQuestionsByQuizType($quizType) {
    global $koneksi;
    
    $quizType = (int)$quizType; // Ensure it's an integer for security
    
    // Prepare SQL to get questions with answers for the specified quiz type
    $sql = "SELECT p.id_pertanyaan, p.pertanyaan, p.nilai, j.id_jawaban, j.jawaban, j.is_benar 
            FROM pertanyaan p
            LEFT JOIN jawaban j ON p.id_pertanyaan = j.id_pertanyaan
            WHERE p.id_kuis = ?
            ORDER BY p.id_pertanyaan, j.is_benar DESC";
            
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $quizType);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $questions = [];
    $currentQuestion = null;
    
    while($row = $result->fetch_assoc()) {
        // If this is a new question or the first row
        if($currentQuestion === null || $currentQuestion['id'] != $row['id_pertanyaan']) {
            // Save the previous question to our array if it exists
            if($currentQuestion !== null) {
                $questions[] = $currentQuestion;
            }
            
            // Start a new question
            $currentQuestion = [
                'id' => $row['id_pertanyaan'],
                'question' => $row['pertanyaan'],
                'nilai' => $row['nilai'],
                'answers' => []
            ];
        }
        
        // Add this answer to the current question
        if($row['id_jawaban'] !== null) {
            $currentQuestion['answers'][] = [
                'id' => $row['id_jawaban'],
                'text' => $row['jawaban'],
                'isCorrect' => (bool)$row['is_benar']
            ];
        }
    }
    
    // Add the last question to our array if it exists
    if($currentQuestion !== null) {
        $questions[] = $currentQuestion;
    }
    
    return $questions;
}

// Check if this is an AJAX request
if(isset($_GET['tipe_kuis'])) {
    $quizType = $_GET['tipe_kuis'];
    $questions = getQuestionsByQuizType($quizType);
    
    // Return questions as JSON
    header('Content-Type: application/json');
    echo json_encode($questions);
    exit;
}
?>