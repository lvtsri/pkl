<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah_mhs'])){
    $nim = trim(mysqli_real_escape_string($koneksi, $_POST['nim']));
    $nama = trim(mysqli_real_escape_string($koneksi, $_POST['nama']));
    $kontak = trim(mysqli_real_escape_string($koneksi, $_POST['kontak']));
    $email = trim(mysqli_real_escape_string($koneksi, $_POST['email']));
    $kelamin = trim(mysqli_real_escape_string($koneksi, $_POST['kelamin']));

    $alamat_tujuan = "";
    if (!empty($_FILES['file_foto']['name'])) {
            $file = $_FILES['file_foto']['name'];
            $ekstensi = explode('.', $file);
            $nama_file = 'foto-mhs'.round(microtime(true)).'.'.end($ekstensi);

            $alamat_sumber = $_FILES['file_foto']['tmp_name'];
            $alamat_tujuan = '../asset_web/img/'.$nama_file;            
            move_uploaded_file($alamat_sumber, $alamat_tujuan);
        }

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
            nim, nama, kontak, email, kelamin, img
        ) VALUES (
            '$nim','$nama','$kontak','$email','$kelamin', '$alamat_tujuan'
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