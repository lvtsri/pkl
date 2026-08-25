<?php
    require_once '../database/koneksi.php';
    if (isset($_POST['btn_ubah_foto'])) {
        $nik = trim(mysqli_real_escape_string($koneksi, $_POST['nik']));
        $file = $_FILES['file_foto']['name'];
        $ekstensi = explode('.',$file);
        $nama_file = 'foto-dosen'.round(microtime(true)).'.'.end($ekstensi);

        $alamat_sumber = $_FILES['file_foto']['tmp_name'];
        $alamat_tujuan = '../asset_web/img/'.$nama_file;
        move_uploaded_file($alamat_sumber,$alamat_tujuan);

        $query_update = mysqli_query($koneksi, "UPDATE tb_dosen SET img = '$alamat_tujuan' WHERE nik = '$nik'")or die(mysqli_error($koneksi));

        echo '<script>
            alert("Foto dosen berhasil diubah!");
            window.location.href = "../admin_data_dosen";
        </script>';
    }
?>