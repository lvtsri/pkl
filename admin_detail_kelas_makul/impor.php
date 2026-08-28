<?php
require '../asset_web/phpexcel-xls/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
require_once '../database/koneksi.php';

if (isset($_POST['btn_impor'])){    //triger setelah btn_impor di klik
    $kode_kelas = trim(mysqli_real_escape_string($koneksi, $_POST['kode_kelas']));

    $file = $_FILES['file_excel']['name'];      //nampung nama file yg di upload
    $extension = explode('.', $file);   //pisahin ekstensi dari nama
    
    $nama_file = 'file'.round(microtime(true)).'.'.end($extension);     //buat nama file baru
    $alamat_tujuan = 'data_excel/'.$nama_file;    //buat alamat tujuan utk simpan file
    $file_alamat_sumber = $_FILES['file_excel']['tmp_name'];    //alamat sumber file yg di upload

    move_uploaded_file($file_alamat_sumber,$alamat_tujuan);     //pindah file ke projek
    
    $file_excel = PHPExcel_IOFactory :: load($alamat_tujuan);   //baca file excel
    $data_excel = $file_excel-> getActiveSheet()->toArray(null, true, true, true);  //baca data excel

    for ($i=2; $i <= count($data_excel); $i++){    //perulangan
        $nim = trim($data_excel[$i]['B']);

        if ($kode_kelas == '' || $nim == '') {
            continue;
        }

        $cek_duplikat = mysqli_query($koneksi, "SELECT * FROM tb_detail_kls_mk WHERE kode_kelas = '$kode_kelas' AND nim = '$nim'");
        $rv = mysqli_num_rows($cek_duplikat);
        
        if ($rv == 0) {
            mysqli_query($koneksi, "INSERT INTO tb_detail_kls_mk (kode_kelas, nim) VALUES ('$kode_kelas', '$nim')") or die(mysqli_error($koneksi));
        }
    }
    echo '<script>
        alert("Data mahasiswa berhasil di impor");
        window.location.href = "index.php?data=' . $kode_kelas . '"
    </script>';
}
?>