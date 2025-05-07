<?php
include 'koneksi.php'; // pastikan koneksi kamu sesuai

// Ambil data ID tipe kuis dan jawaban yang dikirimkan
if (isset($_POST['id_tipe']) && isset($_POST['jawaban'])) {
    $id_tipe = $_POST['id_tipe'];
    $jawaban_user = $_POST['jawaban']; // Array jawaban yang dikirimkan

    $score = 0;

    // Loop untuk memeriksa setiap jawaban
    foreach ($jawaban_user as $id_pertanyaan => $id_jawaban_user) {
        $query = "SELECT * FROM jawaban WHERE id_jawaban = $id_jawaban_user";
        $result = mysqli_query($conn, $query);
        $jawaban = mysqli_fetch_assoc($result);

        // Cek apakah jawaban yang dipilih benar
        if ($jawaban['is_benar'] == 1) {
            $score++;
        }
        
        // Simpan jawaban pengguna ke tabel jawaban_user
        $query_simpan_jawaban = "INSERT INTO jawaban_user (id_pertanyaan, id_jawaban, jawaban, skor) VALUES ($id_pertanyaan, $id_jawaban_user, '{$jawaban['jawaban']}', 1)";
        mysqli_query($conn, $query_simpan_jawaban);
    }

    // Ambil ID user yang sedang login, misalnya dari session
    session_start();
    $id_user = $_SESSION['id_user']; // Pastikan sudah ada sesi yang valid

    // Simpan hasil kuis ke tabel hasil_kuis
    $query_simpan_hasil = "INSERT INTO hasil_kuis (id_user, id_kuis, score) VALUES ($id_user, $id_tipe, $score)";
    mysqli_query($conn, $query_simpan_hasil);

    // Redirect ke halaman hasil atau halaman lain
    header("Location: hasil.php?score=$score");
    exit;
}
?>
