<?php 
    require_once '../database/koneksi.php';

    $id_detail = @$_GET['id'];

    if (empty($id_detail)) {
        echo '<script>alert("Data tidak valid!"); 
        window.location.href="../admin_data_kelas_makul";</script>';
        exit;
    }

    // Biar habis ngehapus balik ke detail kelas yg sama
    $query_kls = mysqli_query($koneksi, "SELECT kode_kelas FROM tb_detail_kls_mk WHERE id = '$id_detail'") or die(mysqli_error($koneksi));
    $data_kls = mysqli_fetch_assoc($query_kls);
    
    $hapus_mhs = mysqli_query($koneksi, "DELETE FROM tb_detail_kls_mk WHERE id = '$id_detail'") or die (mysqli_error($koneksi));

    if ($hapus_mhs) {
        echo '
        <script>
            alert("Data Mahasiswa Berhasil Dihapus");
            window.location.href="index.php?data=' . $data_kls['kode_kelas'] . '";
        </script>';
    } else {
        $error_msg = mysqli_real_escape_string($koneksi, mysqli_error($koneksi));
        echo '
        <script>
            alert("Gagal menghapus data: ' . $error_msg . '");
            window.location.href="index.php?data=' . $data_kls['kode_kelas'] . '";
        </script>';
    }
?>