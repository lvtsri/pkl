<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah_kelas'])){
    $kode_akd = trim(mysqli_real_escape_string($koneksi, $_POST['kode_akd']));
    $kode_makul = trim(mysqli_real_escape_string($koneksi, $_POST['kode_makul']));
    $kode_jurusan = trim(mysqli_real_escape_string($koneksi, $_POST['kode_jurusan']));
    $nik = trim(mysqli_real_escape_string($koneksi, $_POST['nik']));
    $nama_kelas = trim(mysqli_real_escape_string($koneksi, $_POST['nama_kelas']));

    $query_simpan = mysqli_query($koneksi, "INSERT INTO tb_kelas_makul (
        kode_akd, kode_makul, kode_jurusan, nik, nama_kelas
    ) VALUES (
        '$kode_akd', '$kode_makul', '$kode_jurusan', '$nik','$nama_kelas'
    )") or die(mysqli_error($koneksi));

    echo '
    <script> 
        alert("Data kelas matkul berhasil disimpan");
        window.location.href="../admin_data_kelas_makul"    
    </script>';
}

?>