<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit'])) {
    $kode_jurusan = trim(mysqli_real_escape_string($koneksi, $_POST['kode_jurusan']));
    $nama_jurusan = trim(mysqli_real_escape_string($koneksi, $_POST['nama_jurusan']));

    $query_edit_mhs = mysqli_query($koneksi, "UPDATE tb_jurusan SET
        nama_jurusan = '$nama_jurusan'
        WHERE kode_jurusan = '$kode_jurusan'
    ") or die(mysqli_error($koneksi));

    $query_edit = mysqli_query($koneksi, "UPDATE tb_jurusan SET nama_jurusan = '$nama_jurusan' WHERE kode_jurusan = $kode_jurusan") 
    or die(mysqli_error($koneksi));

    if ($query_edit_mhs) {
        echo '
        <script>
            alert("Data jurusan Berhasil Diedit");
            window.location.href = "../admin_jurusan";
        </script>';
    } else {
        $error_msg = mysqli_real_escape_string($koneksi, mysqli_error($koneksi));
        echo '
        <script>
            alert("Gagal mengedit data: ' . $error_msg . '");
            window.location.href = "../admin_jurusan";
        </script>';
    }
}
?>