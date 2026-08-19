<?php 
    require_once '../database/koneksi.php';
    $query_reset = mysqli_query($koneksi, "TRUNCATE TABLE tb_makul") or die (mysqli_error($koneksi));

    if ($query_reset) {
        echo '
        <script>
            alert("Seluruh Data Makul Telah Dihapus");
            window.location.href="../admin_data_makul";
        </script>';
    } else {
        $error_msg = mysqli_real_escape_string($koneksi, mysqli_error($koneksi));
        echo '
        <script>
            alert("Gagal menghapus data: ' . $error_msg . '");
            window.location.href="../admin_data_makul";
        </script>';
    }
?>