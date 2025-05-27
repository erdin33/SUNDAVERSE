<?php
// Fungsi untuk menghitung peringkat user berdasarkan total skor
function hitungPeringkat($koneksi, $id_user) {
    // Query untuk mendapatkan total skor semua user dan mengurutkannya
    $query = "SELECT 
                u.id_user,
                u.nama,
                COALESCE(SUM(hk.score), 0) as total_skor
              FROM user u
              LEFT JOIN hasil_kuis hk ON u.id_user = hk.id_user
              GROUP BY u.id_user, u.nama
              ORDER BY total_skor DESC";
    
    $result = $koneksi->query($query);
    
    if (!$result) {
        return null;
    }
    
    $peringkat = 1;
    $peringkat_user = null;
    
    while ($row = $result->fetch_assoc()) {
        if ($row['id_user'] == $id_user) {
            $peringkat_user = $peringkat;
            break;
        }
        $peringkat++;
    }
    
    return $peringkat_user;
}

// Fungsi untuk mendapatkan daftar peringkat teratas (top 10)
function getDaftarPeringkat($koneksi, $limit = 10) {
    $query = "SELECT 
                u.id_user,
                u.nama,
                u.foto,
                COALESCE(SUM(hk.score), 0) as total_skor
              FROM user u
              LEFT JOIN hasil_kuis hk ON u.id_user = hk.id_user
              GROUP BY u.id_user, u.nama, u.foto
              ORDER BY total_skor DESC
              LIMIT ?";
    
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $daftar_peringkat = [];
    $peringkat = 1;
    
    while ($row = $result->fetch_assoc()) {
        $row['peringkat'] = $peringkat;
        $daftar_peringkat[] = $row;
        $peringkat++;
    }
    
    $stmt->close();
    return $daftar_peringkat;
}

// Fungsi untuk mendapatkan total user yang terdaftar
function getTotalUser($koneksi) {
    $query = "SELECT COUNT(*) as total FROM user";
    $result = $koneksi->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Fungsi untuk mendapatkan statistik user
function getStatistikUser($koneksi, $id_user) {
    // Total kuis yang sudah dikerjakan
    $query_total_kuis = "SELECT COUNT(DISTINCT id_kuis) as total_kuis FROM hasil_kuis WHERE id_user = ?";
    $stmt = $koneksi->prepare($query_total_kuis);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $stmt->bind_result($total_kuis);
    $stmt->fetch();
    $stmt->close();
    
    // Skor tertinggi
    $query_skor_tertinggi = "SELECT MAX(score) as skor_tertinggi FROM hasil_kuis WHERE id_user = ?";
    $stmt = $koneksi->prepare($query_skor_tertinggi);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $stmt->bind_result($skor_tertinggi);
    $stmt->fetch();
    $stmt->close();
    
    // Rata-rata skor
    $query_rata_rata = "SELECT AVG(score) as rata_rata FROM hasil_kuis WHERE id_user = ?";
    $stmt = $koneksi->prepare($query_rata_rata);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $stmt->bind_result($rata_rata);
    $stmt->fetch();
    $stmt->close();
    
    return [
        'total_kuis' => $total_kuis ?? 0,
        'skor_tertinggi' => $skor_tertinggi ?? 0,
        'rata_rata' => round($rata_rata ?? 0, 1)
    ];
}

// Jika dipanggil untuk mendapatkan peringkat user tertentu
if (isset($id_user) && isset($koneksi)) {
    $peringkat_user = hitungPeringkat($koneksi, $id_user);
}
?>