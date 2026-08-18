<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah_mhs'])){
    $nim = trim(mysqli_real_escape_string($koneksi, $_POST['nim']));
    $nama = trim(mysqli_real_escape_string($koneksi, $_POST['nama']));
    $kontak = trim(mysqli_real_escape_string($koneksi, $_POST['kontak']));
    $email = trim(mysqli_real_escape_string($koneksi, $_POST['email']));
    $kelamin = trim(mysqli_real_escape_string($koneksi, $_POST['kelamin']));

    $cek_user = mysqli_query($koneksi, "SELECT nim FROM tb_mahasiswa WHERE nim = '$nim'") or die (mysqli_error($koneksi));
    $rv = mysqli_num_rows($cek_user);

    if ($rv == 1){
        echo '
        <script>
            alert("NIM sudah Terdaftar");
            window.location.href="../admin_data_mhs"
        </script>';
    } else {
        $query_simpan = mysqli_query($koneksi, "INSERT INTO tb_mahasiswa (
            nim, nama, kontak, email, kelamin
        ) VALUES (
            '$nim','$nama','$kontak','$email','$kelamin'
        )") or die(mysqli_error($koneksi));

        // Query buat nambah juga ke tb pengguna
        $username = $nim;
        $sandi = sha1($nim);
        $peran = 'M';
        $pin = 123456;
        $query_pengguna = mysqli_query($koneksi, "INSERT INTO tb_pengguna (
            username, sandi, peran, pin, nama
        ) VALUES (
            '$username', '$sandi', '$peran', $pin, '$nama'
        )") or die(mysqli_error($koneksi));

        echo '
        <script> 
            alert("Data mahasiswa berhasil disimpan");
            window.location.href="../admin_data_mhs"    
        </script>';
    }
}

?>