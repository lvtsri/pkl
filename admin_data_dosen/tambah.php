<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah_admin'])){
    $nik = trim(mysqli_real_escape_string($koneksi, $_POST['nik']));
    $nama = trim(mysqli_real_escape_string($koneksi, $_POST['nama']));
    $kontak = trim(mysqli_real_escape_string($koneksi, $_POST['kontak']));
    $email = trim(mysqli_real_escape_string($koneksi, $_POST['email']));
    $kelamin = trim(mysqli_real_escape_string($koneksi, $_POST['kelamin']));

    $cek_user = mysqli_query($koneksi, "SELECT nik FROM tb_dosen WHERE nik = '$nik'") or die (mysqli_error($koneksi));
    $rv = mysqli_num_rows($cek_user);

    if ($rv == 1){
        echo '
        <script>
            alert("NIK sudah Terdaftar");
            window.location.href="../admin_data_dosen"
        </script>';
    } else {
        $query_simpan = mysqli_query($koneksi, "INSERT INTO tb_dosen (
            nik,
            nama,
            kontak,
            email,
            kelamin
        ) VALUES (
            '$nik',
            '$nama',
            '$kontak',
            '$email',
            '$kelamin'
        )") or die(mysqli_error($koneksi));

        echo '
        <script> 
            alert("Data berhasil disimpan");
            window.location.href="../admin_data_dosen"    
        </script>';
    }
}

?>