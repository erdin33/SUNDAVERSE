<?php include 'koneksi.php'; ?>

<form action="kuis.php" method="GET">
    <label>Pilih Kuis:</label>
    <div style="margin-top: 10px;">
        <?php
        // Query untuk mendapatkan data kuis
        $kuis = mysqli_query($conn, "SELECT * FROM tipe_kuis");
        while ($row = mysqli_fetch_assoc($kuis)) {
            // Tombol untuk setiap kuis
            echo "<button 
                    type='submit' 
                    name='id_kuis' 
                    value='{$row['id_kuis']}' 
                    style='margin-right: 10px; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;'
                  >
                    {$row['nama_kuis']}
                  </button>";
        }
        ?>
    </div>
</form>