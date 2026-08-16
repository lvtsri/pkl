<?php 
    require_once '../database/koneksi.php';

    $pengguna = isset($_GET['user']) ? $_GET['user'] : '';

    // Jika parameter kosong
    if (empty($pengguna)) {
        echo '<script>alert("Data pengguna tidak valid!"); window.location.href="../admin_data_dosen";</script>';
        exit;
    }

    $query_dosen = mysqli_query($koneksi, "SELECT * FROM tb_dosen WHERE nik = '$pengguna'");
    $data = mysqli_fetch_assoc($query_dosen);
    $nama = $data ? $data['nama'] : $pengguna;

    $hapus_pengguna = mysqli_query($koneksi, "DELETE FROM tb_dosen WHERE nik = '$pengguna'") or die (mysqli_error($koneksi));

    if ($hapus_pengguna) {
        echo '
        <script>
            alert("Data Pengguna ' . $nama . ' (NIK: ' . $pengguna . ') Berhasil Dihapus");
            window.location.href="../admin_data_dosen";
        </script>';
    } else {
        $error_msg = mysqli_real_escape_string($koneksi, mysqli_error($koneksi));
        echo '
        <script>
            alert("Gagal menghapus data: ' . $error_msg . '");
            window.location.href="../admin_data_dosen";
        </script>';
    }
?>