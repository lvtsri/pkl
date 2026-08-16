<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah_admin'])){
    $username = trim(mysqli_real_escape_string($koneksi, $_POST['username']));
    $nama = trim(mysqli_real_escape_string($koneksi, $_POST['nama']));
    $peran = trim(mysqli_real_escape_string($koneksi, $_POST['peran']));
    $password = sha1($username);
    $pin = '1234';

    $cek_user = mysqli_query($koneksi, "SELECT username FROM tb_pengguna WHERE username = '$username'") or die (mysqli_error($koneksi));
    $rv = mysqli_num_rows($cek_user);

    if ($rv == 1){
        echo '
        <script>
            alert("Username sudah Terdaftar");
            window.location.href="../admin_data_administrator"
        </script>';
    } else {
        $query_simpan = mysqli_query($koneksi, "INSERT INTO tb_pengguna (
            username,
            sandi,
            peran,
            pin,
            nama
        ) VALUES (
            '$username',
            '$password',
            '$peran',
            '$pin',
            '$nama'
        )") or die(mysqli_error($koneksi));

        echo '
        <script> 
            alert("Data berhasil disimpan");
            window.location.href="../admin_data_administrator"    
        </script>';
    }
}

?>