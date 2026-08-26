<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit_kelas'])) {
    $kode_kelas = trim(mysqli_real_escape_string($koneksi, $_POST['kode_kelas']));
    $kode_akd = trim(mysqli_real_escape_string($koneksi, $_POST['kode_akd']));
    $kode_makul = trim(mysqli_real_escape_string($koneksi, $_POST['kode_makul']));
    $kode_jurusan = trim(mysqli_real_escape_string($koneksi, $_POST['kode_jurusan']));
    $nik = trim(mysqli_real_escape_string($koneksi, $_POST['nik']));
    $nama_kelas = trim(mysqli_real_escape_string($koneksi, $_POST['nama_kelas']));

    $query_edit = mysqli_query($koneksi, "UPDATE tb_kelas_makul SET
        kode_kelas = '$kode_kelas',
        kode_akd = '$kode_akd',
        kode_makul = '$kode_makul',
        kode_jurusan = '$kode_jurusan',
        nik = '$nik',
        nama_kelas = '$nama_kelas' 
        WHERE kode_kelas = '$kode_kelas'
    ") or die(mysqli_error($koneksi));

    if ($query_edit) {
        echo '
        <script>
            alert("Data Kelas Berhasil Diedit");
            window.location.href = "../admin_data_kelas_makul";
        </script>';
    } else {
        $error_msg = mysqli_real_escape_string($koneksi, mysqli_error($koneksi));
        echo '
        <script>
            alert("Gagal mengedit data: ' . $error_msg . '");
            window.location.href = "../admin_data_kelas_makul";
        </script>';
    }
}
?>