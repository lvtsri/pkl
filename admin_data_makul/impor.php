<?php
require '../asset_web/phpexcel-xls/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
require_once '../database/koneksi.php';

if (isset($_POST['btn_impor'])){    //triger setelah btn_impor di klik
    $file = $_FILES['file_excel']['name'];      //nampung nama file yg di upload
    $extension = explode('.', $file);   //pisahin ekstensi dari nama
    
    $nama_file = 'file'.round(microtime(true)).'.'.end($extension);     //buat nama file baru
   
    $alamat_tujuan = 'template/'.$nama_file;    //buat alamat tujuan utk simpan file
    $file_alamat_sumber = $_FILES['file_excel']['tmp_name'];    //alamat sumber file yg di upload
    move_uploaded_file($file_alamat_sumber,$alamat_tujuan);     //pindah file ke projek
    
    $file_excel = PHPExcel_IOFactory :: load($alamat_tujuan);   //baca file excel
    $data_excel = $file_excel-> getActiveSheet()->toArray(null, true, true, true);  //baca data excel

    for ($i=2; $i <= count($data_excel) ; $i++){    //perulangan
        $kode_makul = $data_excel[$i]['B'];
        $nama_makul = $data_excel[$i]['C'];
        $jml_sks = $data_excel[$i]['D'];
        $jml_cpmk = $data_excel[$i]['E'];

        if ($kode_makul == '' || $nama_makul == '' || $jml_sks == '' || $jml_cpmk == '') {
            continue;
        }
        
        $query_cek = mysqli_query($koneksi, "SELECT kode_makul FROM tb_makul WHERE kode_makul='$kode_makul'")or die(mysqli_error($koneksi));

        if (mysqli_num_rows($query_cek)==0) {   //ketika tidak ada data kode matkul
            $query_insert = mysqli_query($koneksi, "INSERT INTO tb_makul VALUES ('$kode_makul', '$nama_makul', '$jml_sks', '$jml_cpmk')")or die(mysqli_error($koneksi));
        }
    }

    echo '<script>
    alert("Data berhasil di impor");
    window.location.href = "../admin_data_makul"
    </script>';
}
?>