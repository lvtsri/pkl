<?php 
    require_once '../database/koneksi.php';

    $data_kelas = @$_GET['data'];

    if (empty($data_kelas)) {
        echo '<script>alert("Data tidak valid!"); window.location.href="../admin_data_kelas_makul";</script>';
        exit;
    }

    $query_kelas = mysqli_query($koneksi, "SELECT * FROM tb_kelas_makul WHERE kode_kelas = '$data_kelas'");
    $data = mysqli_fetch_assoc($query_kelas);

    $hapus_kelas = mysqli_query($koneksi, "DELETE FROM tb_kelas_makul WHERE kode_kelas = '$data_kelas'") or die (mysqli_error($koneksi));

    if ($hapus_kelas) {
        echo '
        <script>
            alert("Data Kelas Berhasil Dihapus");
            window.location.href="../admin_data_kelas_makul";
        </script>';
    } else {
        $error_msg = mysqli_real_escape_string($koneksi, mysqli_error($koneksi));
        echo '
        <script>
            alert("Gagal menghapus data: ' . $error_msg . '");
            window.location.href="../admin_data_kelas_makul";
        </script>';
    }
?>