<?php
include 'koneksi.php';  // Pastikan koneksi database sudah ada
include 'cek_user.php';  // Pastikan user sudah login

// Cek apakah form sudah disubmit
if (isset($_POST['submit_profile'])) {
    // Ambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_id = $_SESSION['id_user'];
    
    // Verifikasi password
    $query_pass = "SELECT password FROM user WHERE id_user = ?";
    $stmt_pass = $koneksi->prepare($query_pass);
    $stmt_pass->bind_param("i", $user_id);
    $stmt_pass->execute();
    $stmt_pass->bind_result($db_password);
    $stmt_pass->fetch();
    $stmt_pass->close();
    
    // Periksa kecocokan password (asumsikan sudah di-hash)
    if (password_verify($password, $db_password) || $password === $db_password) {
        // Password cocok, lanjutkan proses update
        
        // Proses upload foto jika ada
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $foto_tmp = $_FILES['foto']['tmp_name'];
            $foto_name = $_FILES['foto']['name'];
            $foto_ext = pathinfo($foto_name, PATHINFO_EXTENSION);
            $foto_name_new = 'foto_' . $user_id . '.' . $foto_ext;  // Nama file unik berdasarkan ID pengguna
            
            // Tentukan direktori penyimpanan foto
            $upload_dir = '../uploads/foto/';
            
            // Buat direktori jika belum ada
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $upload_path = $upload_dir . $foto_name_new;
            
            // Validasi tipe file
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['foto']['type'], $allowed_types)) {
                header("Location: editprofile.php?edit=true&update=error&message=" . urlencode("Format file tidak didukung!"));
                exit();
            }
            
            // Validasi ukuran file (maksimal 2MB)
            $max_size = 2 * 1024 * 1024;
            if ($_FILES['foto']['size'] > $max_size) {
                header("Location: editprofile.php?edit=true&update=error&message=" . urlencode("Ukuran file terlalu besar (maksimal 2MB)!"));
                exit();
            }
            
            // Pindahkan file foto ke direktori tujuan
            if (move_uploaded_file($foto_tmp, $upload_path)) {
                // Jika foto berhasil diupload, perbarui data pengguna di database
                $query = "UPDATE user SET nama = ?, email = ?, foto = ? WHERE id_user = ?";
                $stmt = $koneksi->prepare($query);
                $stmt->bind_param("sssi", $username, $email, $foto_name_new, $user_id);
                $stmt->execute();
                $stmt->close();
                
                // Update session dengan data baru
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['foto'] = $foto_name_new;
                
                header("Location: profile.php?update=success");
                exit();
            } else {
                header("Location: editprofile.php?edit=true&update=error&message=" . urlencode("Gagal mengupload foto!"));
                exit();
            }
        } else {
            // Jika foto tidak di-upload, hanya update data tanpa foto
            $query = "UPDATE user SET nama = ?, email = ? WHERE id_user = ?";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("ssi", $username, $email, $user_id);
            $stmt->execute();
            $stmt->close();
            
            // Update session dengan data baru
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            
            header("Location: profile.php?update=success");
            exit();
        }
    } else {
        // Password tidak cocok
        header("Location: editprofile.php?edit=true&update=error&message=" . urlencode("Password salah!"));
        exit();
    }
} else {
    // Jika tidak ada form yang disubmit, redirect ke halaman profil
    header("Location: profile.php");
    exit();
}
?>