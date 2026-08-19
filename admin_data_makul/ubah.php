<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit'])) {
    $kode_makul = trim(mysqli_real_escape_string($koneksi, $_POST['kode_makul']));
    $nama_makul = trim(mysqli_real_escape_string($koneksi, $_POST['nama_makul']));
    $jml_sks = trim(mysqli_real_escape_string($koneksi, $_POST['jml_sks']));
    $jml_cpmk = trim(mysqli_real_escape_string($koneksi, $_POST['jml_cpmk']));

    $query_edit_makul = mysqli_query($koneksi, "UPDATE tb_makul SET
        nama_makul = '$nama_makul',
        jml_sks = '$jml_sks',
        jml_cpmk = '$jml_cpmk'
        WHERE kode_makul = '$kode_makul'
    ") or die(mysqli_error($koneksi));

    if ($query_edit_makul) {
        echo '
        <script>
            alert("Data Makul Berhasil Diedit");
            window.location.href = "../admin_data_makul";
        </script>';
    } else {
        $error_msg = mysqli_real_escape_string($koneksi, mysqli_error($koneksi));
        echo '
        <script>
            alert("Gagal mengedit data: ' . $error_msg . '");
            window.location.href = "../admin_data_makul";
        </script>';
    }
}
?>