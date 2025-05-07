<?php
include 'koneksi.php'; // Pastikan ini path ke file koneksi kamu

header('Content-Type: application/json');

$id_tipe = 1; // ID untuk kuis 'Tebak Kata'

$query = "
    SELECT p.id_pertanyaan, p.pertanyaan, j.jawaban, j.is_benar
    FROM pertanyaan p
    JOIN jawaban j ON p.id_pertanyaan = j.id_pertanyaan
    WHERE p.id_tipe = ?
    ORDER BY p.id_pertanyaan, RAND()
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_tipe);
$stmt->execute();
$result = $stmt->get_result();

$soal = [];
while ($row = $result->fetch_assoc()) {
    $id = $row['id_pertanyaan'];
    if (!isset($soal[$id])) {
        $soal[$id] = [
            'pertanyaan' => $row['pertanyaan'],
            'jawaban' => []
        ];
    }
    $soal[$id]['jawaban'][] = [
        'teks' => $row['jawaban'],
        'benar' => $row['is_benar']
    ];
}

echo json_encode(array_values($soal));
?>
