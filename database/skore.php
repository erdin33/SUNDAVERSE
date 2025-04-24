<?php

$id_user = $_SESSION['id_user'];

// Ambil total skor user
$sql = "SELECT SUM(score) AS total_skor FROM hasil_kuis WHERE id_user = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$total_skor = $result['total_skor'] ?? 0;
?>
