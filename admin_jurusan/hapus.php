<?php 
    require_once '../database/koneksi.php';

    $jurusan = @$_GET['kode'];
    if (empty($jurusan)) {
        echo '<script>alert("Data jurusan tidak valid!"); window.location.href="../admin_jurusan";</script>';
        exit;
    }

    $query_jurusan = mysqli_query($koneksi, "SELECT * FROM tb_jurusan WHERE kode_jurusan = '$jurusan'");
    $data = mysqli_fetch_assoc($query_jurusan);
    $nama = $data ? $data['nama_jurusan'] : $jurusan;

    $hapus_jurusan = mysqli_query($koneksi, "DELETE FROM tb_jurusan WHERE kode_jurusan = '$jurusan'") or die (mysqli_error($koneksi));
    
    if ($hapus_jurusan) {
        echo '
        <script>
            alert("Data Pengguna ' . $nama . ' (Kode: ' . $jurusan . ') Berhasil Dihapus");
            window.location.href="../admin_jurusan";
        </script>';
    } else {
        $error_msg = mysqli_real_escape_string($koneksi, mysqli_error($koneksi));
        echo '
        <script>
            alert("Gagal menghapus data: ' . $error_msg . '");
            window.location.href="../admin_jurusan";
        </script>';
    }
?>