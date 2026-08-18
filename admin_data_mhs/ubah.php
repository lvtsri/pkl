<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit'])) {
    $nim     = trim(mysqli_real_escape_string($koneksi, $_POST['nim']));
    $nama    = trim(mysqli_real_escape_string($koneksi, $_POST['name']));
    $kontak  = trim(mysqli_real_escape_string($koneksi, $_POST['kontak']));
    $email   = trim(mysqli_real_escape_string($koneksi, $_POST['email']));
    $kelamin = trim(mysqli_real_escape_string($koneksi, $_POST['kelamin']));

    $query_edit_mhs = mysqli_query($koneksi, "UPDATE tb_mahasiswa SET
        nama = '$nama',
        kontak = '$kontak',
        email = '$email',
        kelamin = '$kelamin' 
        WHERE nim = '$nim'
    ") or die(mysqli_error($koneksi));

    $query_edit_pengguna = mysqli_query($koneksi, "UPDATE tb_pengguna SET nama = '$nama' WHERE username = $nim") 
    or die(mysqli_error($koneksi));

    if ($query_edit_mhs && $query_edit_pengguna) {
        echo '
        <script>
            alert("Data Mahasiswa Berhasil Diedit");
            window.location.href = "../admin_data_mhs";
        </script>';
    } else {
        $error_msg = mysqli_real_escape_string($koneksi, mysqli_error($koneksi));
        echo '
        <script>
            alert("Gagal mengedit data: ' . $error_msg . '");
            window.location.href = "../admin_data_mhs";
        </script>';
    }
}
?>