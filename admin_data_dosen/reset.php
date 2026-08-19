<?php 
    require_once '../database/koneksi.php';
    $query_reset = mysqli_query($koneksi, "TRUNCATE TABLE tb_dosen") or die (mysqli_error($koneksi));
    $query_pengguna = mysqli_query($koneksi, "DELETE FROM tb_pengguna WHERE peran = 'D'") or die (mysqli_error($koneksi));

    if ($query_reset && $query_pengguna) {
        echo '
        <script>
            alert("Seluruh Data Dosen Telah Dihapus");
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