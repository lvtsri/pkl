<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit'])) {
    $nik     = trim(mysqli_real_escape_string($koneksi, $_POST['nik']));
    $nama    = trim(mysqli_real_escape_string($koneksi, $_POST['name']));
    $kontak  = trim(mysqli_real_escape_string($koneksi, $_POST['kontak']));
    $email   = trim(mysqli_real_escape_string($koneksi, $_POST['email']));
    $kelamin = trim(mysqli_real_escape_string($koneksi, $_POST['kelamin']));

    $query_edit_dosen = mysqli_query($koneksi, "UPDATE tb_dosen SET
        nama = '$nama',
        kontak = '$kontak',
        email = '$email',
        kelamin = '$kelamin' 
        WHERE nik = '$nik'
    ") or die(mysqli_error($koneksi));

    $query_edit_pengguna = mysqli_query($koneksi, "UPDATE tb_pengguna SET nama = '$nama' WHERE username = $nik") 
    or die(mysqli_error($koneksi));

    if ($query_edit_dosen && $query_edit_pengguna) {
        echo '
        <script>
            alert("Data Dosen Berhasil Diedit");
            window.location.href = "../admin_data_dosen";
        </script>';
    } else {
        $error_msg = mysqli_real_escape_string($koneksi, mysqli_error($koneksi));
        echo '
        <script>
            alert("Gagal mengedit data: ' . $error_msg . '");
            window.location.href = "../admin_data_dosen";
        </script>';
    }
}
?>