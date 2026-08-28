<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])){
    $kode_kelas = trim(mysqli_real_escape_string($koneksi, $_POST['kode_kelas']));
    $nim = trim(mysqli_real_escape_string($koneksi, $_POST['nim']));

    $query_cek_duplikat = mysqli_query($koneksi, "SELECT * FROM tb_detail_kls_mk WHERE nim = '$nim'")or die($koneksi);
    

    $rv = mysqli_num_rows($query_cek_duplikat);
    if ($rv > 0){
        echo '<script>
            alert("Data mahasiswa sudah terdaftar!");
            window.location.href="index.php?data=' . $kode_kelas . '"
        </script>';
    } else {
        $query_simpan = mysqli_query($koneksi, "INSERT INTO tb_detail_kls_mk (
            kode_kelas, nim
        ) VALUES (
            '$kode_kelas', '$nim'
        )") or die(mysqli_error($koneksi));

        echo '
        <script> 
            alert("Data mahasiswa berhasil disimpan");
            window.location.href="index.php?data=' . $kode_kelas . '"    
        </script>';
    }
}

?>