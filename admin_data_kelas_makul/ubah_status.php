<?php
require_once '../database/koneksi.php';

$authority = @$_SESSION['peran'];
if($authority != 'A'){
    echo '<script>
        window.location.href = "../logout.php";
        alert("Anda bukan admin!!! Akan segera di logout-kan");
    </script>';
    exit;
}

if (isset($_GET['id_pertemuan'])) {
    $id_pertemuan = $_GET['id_pertemuan'];

    $query = mysqli_query($koneksi, "SELECT status_pertemuan FROM tb_pertemuan WHERE id = '$id_pertemuan'");
    $data_status = mysqli_fetch_assoc($query);

    if ($data_status) {
        $status_sekarang = $data_status['status_pertemuan'];

        if ($status_sekarang == '1') {
            $status_baru = '0';
        } else {
            $status_baru = '1';
        }
        $query_update = mysqli_query($koneksi, "UPDATE tb_pertemuan SET status_pertemuan = '$status_baru' WHERE id = '$id_pertemuan'")or die(mysqli_error($koneksi));

        if ($query_update) {
            echo 
            '<script>
                alert("Status presensi pertemuan telah berubah!");
                window.location.href="../admin_data_kelas_makul/presensi.php?data='.$id_pertemuan.'";
            </script>';
        } else {
            echo 
            '<script>
                alert("Gagal mengubah status presensi");
                window.location.href="../admin_data_kelas_makul/presensi.php?data='.$id_pertemuan.'";
            </script>';
        }
    } else {
        echo 
        '<script>
            alert("Data presensi tidak ditemukan!");
            window.location.href="../admin_data_kelas_makul/presensi.php?data='.$id_pertemuan.'";
        </script>';
    }
}

?>