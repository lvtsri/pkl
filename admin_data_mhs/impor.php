<?php
require '../asset_web/phpexcel-xls/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
require_once '../database/koneksi.php';

if (isset($_POST['btn_impor'])){    //triger setelah btn_impor di klik
    $file = $_FILES['file_excel']['name'];      //nampung nama file yg di upload
    $extension = explode('.', $file);   //pisahin nama file berdasarkan titik
    
    $nama_file = 'file'.round(microtime(true)).'.'.end($extension);     //buat nama file baru
   
    $alamat_tujuan = 'template/'.$nama_file;    //buat alamat tujuan utk simpan file
    $file_alamat_sumber = $_FILES['file_excel']['tmp_name'];    //alamat sumber file yg di upload
    move_uploaded_file($file_alamat_sumber,$alamat_tujuan);     //pindah file ke projek
    
    $file_excel = PHPExcel_IOFactory :: load($alamat_tujuan);   //baca file excel
    $data_excel = $file_excel-> getActiveSheet()->toArray(null, true, true, true);  //baca data excel

    for ($i=2; $i <= count($data_excel) ; $i++){    //perulangan
        $nim = $data_excel[$i]['B'];
        $nama = $data_excel[$i]['C'];
        $kontak = $data_excel[$i]['D'];
        $email = $data_excel[$i]['E'];
        $kelamin = $data_excel[$i]['F'];

        if ($nim == '' || $nama == '' || $kontak == '' || $email == '' || $kelamin == '') {
            continue;
        }
        
        $query_cek = mysqli_query($koneksi, "SELECT nim FROM tb_mahasiswa WHERE nim='$nim'")or die(mysqli_error($koneksi));

        if (mysqli_num_rows($query_cek)==0) {   //ketika tidak ada data kode matkul
            $query_insert = mysqli_query($koneksi, "INSERT INTO tb_mahasiswa VALUES ('$nim', '$nama', '$kontak', '$email', '$kelamin')")or die(mysqli_error($koneksi));
            
            $username = $nim;
            $sandi = sha1($nim);
            $peran = 'M';
            $pin = 123456;
            $query_pengguna = mysqli_query($koneksi, "INSERT INTO tb_pengguna (username, sandi, peran, pin, nama) VALUES ('$username', '$sandi', '$peran', $pin, '$nama')") or die(mysqli_error($koneksi));
        }
    }

    echo '<script>
    alert("Data mahasiswa berhasil di impor");
    window.location.href = "../admin_data_mhs"
    </script>';
}
?>