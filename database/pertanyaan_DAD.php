<?php
// Database connection
include('koneksi.php'); // Adjust this path to your database config file

// Get 5 random questions for aksara sunda quiz
// Using id_kuis = 4 for Aksara Sunda drag and drop quiz
function getRandomQuestions($id_kuis = 4, $count = 5) {
    global $koneksi;
    
    // Get random questions
    $sql = "SELECT * FROM pertanyaan WHERE id_kuis = ? ORDER BY RAND() LIMIT ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("ii", $id_kuis, $count);
    $stmt->execute();
    $questions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
    $result = array();
    
    foreach ($questions as $question) {
        $id_pertanyaan = $question['id_pertanyaan'];
        
        // Get all answers for this question
        $answerSql = "SELECT * FROM jawaban WHERE id_pertanyaan = ?";
        $answerStmt = $koneksi->prepare($answerSql);
        $answerStmt->bind_param("i", $id_pertanyaan);
        $answerStmt->execute();
        $answers = $answerStmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
        // Prepare answer objects
        $answerTexts = array();
        $correctOrder = array();
        $index = 1;
        
        // First add correct answers
        foreach ($answers as $answer) {
            if ($answer['is_benar'] == 1) {
                $answerTexts[] = $answer['jawaban'];
                $correctOrder[] = $index;
                $index++;
            }
        }
        
        // Then add incorrect answers if needed
        foreach ($answers as $answer) {
            if ($answer['is_benar'] == 0) {
                $answerTexts[] = $answer['jawaban'];
                $index++;
            }
        }
        
        $result[] = array(
            'id' => $id_pertanyaan,
            'question' => $question['pertanyaan'],
            'answers' => $answerTexts,
            'correctOrder' => $correctOrder,
            'nilai' => $question['nilai']
        );
    }
    
    return $result;
}

// Call the function and return JSON
header('Content-Type: application/json');

// Get questions for the aksara sunda quiz (using id_kuis = 4)
$quizId = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 4; // Default to 4 for Aksara Sunda
$questions = getRandomQuestions($quizId);

echo json_encode($questions);
?>