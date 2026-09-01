<?php
require '../asset_web/phpexcel-xls/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
require_once '../database/koneksi.php';

if (isset($_POST['btn_impor'])){    //triger setelah btn_impor di klik
    $file = $_FILES['file_excel']['name'];      //nampung nama file yg di upload
    $extension = explode('.', $file);   //pisahin ekstensi dari nama
    
    $nama_file = 'file'.round(microtime(true)).'.'.end($extension);    //buat nama file baru

    $alamat_tujuan = 'data_excel/'.$nama_file;    //buat alamat tujuan utk simpan file
    $file_alamat_sumber = $_FILES['file_excel']['tmp_name'];    //alamat sumber file yg di upload
    move_uploaded_file($file_alamat_sumber,$alamat_tujuan);     //pindah file ke projek
    
    $file_excel = PHPExcel_IOFactory :: load($alamat_tujuan);   //baca file excel
    $data_excel = $file_excel-> getActiveSheet()->toArray(null, true, true, true);  //baca data excel

    for ($i=2; $i <= count($data_excel) ; $i++){    //perulangan
        // gapake kode_kelas soalnya AI (auto increment pak)
        $kode_akd = $data_excel[$i]['C'];
        $kode_makul = $data_excel[$i]['D'];
        $kode_jurusan = $data_excel[$i]['E'];
        $nik = $data_excel[$i]['F'];
        $nama_kelas = $data_excel[$i]['G'];
        $nim = $data_excel[$i]['H'];
        
        if ($kode_akd == '' || $kode_makul == '' || $kode_jurusan == '' || $nik == '' || $nama_kelas == '' || $nim == '') {
            continue;
        } else {
            // cek adanya nim dari data impor
            $cek_mhs = mysqli_query($koneksi, "SELECT * FROM tb_mahasiswa WHERE nim = '$nim'")or die(mysqli_error($koneksi));
            $rv_mhs = mysqli_num_rows($cek_mhs);

            if ($rv_mhs > 0) {
                // cek duplikasi data kelas
                $cek_kelas = mysqli_query($koneksi, "SELECT * FROM tb_kelas_makul WHERE 
                    kode_akd = '$kode_akd' AND 
                    kode_makul = '$kode_makul' AND
                    kode_jurusan = '$kode_jurusan' AND
                    nik = '$nik' AND
                    nama_kelas = '$nama_kelas'
                ") or die(mysqli_error($koneksi));

                $rv = mysqli_num_rows($cek_kelas);
                $kode_kelas = "";     //buat nyatain variabel $kode_kelas yg nantinya dipake buat tb_detail_kls_mk

                if ($rv == 0) {     //klo gada data duplikat, jalanin insert data
                    mysqli_query($koneksi, "INSERT INTO tb_kelas_makul VALUES (
                        null, 
                        '$kode_akd', 
                        '$kode_makul', 
                        '$kode_jurusan', 
                        '$nik', 
                        '$nama_kelas'
                    )") or die(mysqli_error($koneksi));
                    
                    // isi variabel $kode_kelas dengan perintah bawaan php ini yg mengambil ai. Fun fact, cuma berfungsi secara single data, karena dia cuma ambil data id terakhir
                    $kode_kelas = mysqli_insert_id($koneksi);
                } else {
                    $dt = mysqli_fetch_assoc($cek_kelas);
                    $kode_kelas = $dt['kode_kelas'];
                }

                // cek data duplikat
                $cek_mhs_detail = mysqli_query($koneksi, "SELECT * FROM tb_detail_kls_mk WHERE kode_kelas = '$kode_kelas' AND nim = '$nim'");
                // klo gada data duplikat jalanin insert
                if (mysqli_num_rows($cek_mhs_detail) == 0) {
                    mysqli_query($koneksi, "INSERT INTO tb_detail_kls_mk VALUES (
                        null, 
                        '$kode_kelas', 
                        '$nim'
                    )") or die(mysqli_error($koneksi));
                }
            }
        }
    }

    echo '<script>
        alert("Data kelas dan mahasiswa berhasil di impor");
        window.location.href = "../admin_data_kelas_makul"
    </script>';
}
?>