<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit_mhs'])) {
    $id = trim(mysqli_real_escape_string($koneksi, $_POST['id']));
    $id_pertemuan = trim(mysqli_real_escape_string($koneksi, $_POST['id_pertemuan']));
    $status_kehadiran = trim(mysqli_real_escape_string($koneksi, $_POST['status_kehadiran']));

    $query_edit_status = mysqli_query($koneksi, "UPDATE tb_presensi SET status_kehadiran = '$status_kehadiran' WHERE id = '$id'")or die(mysqli_error($koneksi));

    echo '<script>
        alert("Status kehadiran berhasil diubah")
        window.location.href="../admin_data_kelas_makul/presensi.php?data='.$id_pertemuan.'";
    </script>';
}
?>