<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit'])) {

    $username  = trim(mysqli_real_escape_string($koneksi, $_POST['username']) );
    $name  = trim(mysqli_real_escape_string($koneksi, $_POST['name']) );
    $peran  = trim(mysqli_real_escape_string($koneksi, $_POST['peran']) );

    $query_edit = mysqli_query($koneksi,"UPDATE tb_pengguna SET
    nama = '$name',
    peran = '$peran' WHERE username = '$username'")or die(mysqli_error($koneksi));

    echo '<script> alert ("Data Berhasil Diedit");
    window.location.href = "../admin_data_administrator"</script>';
    
}
?>