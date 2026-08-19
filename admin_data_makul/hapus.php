<?php 
    require_once '../database/koneksi.php';

    $makul = @$_GET['kode'];

    $query_makul = mysqli_query($koneksi, "SELECT * FROM tb_makul WHERE kode_makul = '$makul'");
    $data = mysqli_fetch_assoc($query_makul);
    $nama_makul = $data ? $data['nama_makul'] : $makul;

    $hapus_makul = mysqli_query($koneksi, "DELETE FROM tb_makul WHERE kode_makul = '$makul'") or die (mysqli_error($koneksi));

    if ($hapus_makul) {
        echo '
        <script>
            alert("Data Matkul ' . $nama_makul . ' dengan Kode: ' . $makul . ' Berhasil Dihapus");
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