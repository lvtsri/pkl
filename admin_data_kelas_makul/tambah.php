<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah_kelas'])){
    $kode_akd = trim(mysqli_real_escape_string($koneksi, $_POST['kode_akd']));
    $kode_makul = trim(mysqli_real_escape_string($koneksi, $_POST['kode_makul']));
    $kode_jurusan = trim(mysqli_real_escape_string($koneksi, $_POST['kode_jurusan']));
    $nik = trim(mysqli_real_escape_string($koneksi, $_POST['nik']));
    $nama_kelas = trim(mysqli_real_escape_string($koneksi, $_POST['nama_kelas']));

    $query_cek_duplikat = mysqli_query($koneksi, "SELECT * FROM tb_kelas_makul WHERE
        kode_akd = '$kode_akd' AND 
        kode_makul = '$kode_makul' AND 
        kode_jurusan = '$kode_jurusan' AND 
        nik = '$nik' AND 
        nama_kelas = '$nama_kelas' 
    ")or die($koneksi);

    $rv = mysqli_num_rows($query_cek_duplikat);
    if ($rv > 0){
        echo '<script>
            alert("Data tersebut sudah ada!");
            window.location.href="../admin_data_kelas_makul"
        </script>';
    } else {
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
}

?>