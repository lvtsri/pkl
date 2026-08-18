<?php 
    require_once '../database/koneksi.php';

    // Ambil parameter NIM dari URL (?user=...)
    $pengguna = @$_GET['user'];

    // Jika parameter kosong
    if (empty($pengguna)) {
        echo '<script>alert("Data pengguna tidak valid!"); window.location.href="../admin_data_mhs";</script>';
        exit;
    }

    // Ambil data mahasiswa berdasarkan NIM (untuk menampilkan nama di alert)
    $query_mhs = mysqli_query($koneksi, "SELECT * FROM tb_mahasiswa WHERE nim = '$pengguna'");
    $data = mysqli_fetch_assoc($query_mhs);
    $nama = $data ? $data['nama'] : $pengguna;

    $hapus_mhs = mysqli_query($koneksi, "DELETE FROM tb_mahasiswa WHERE nim = '$pengguna'") or die (mysqli_error($koneksi));
    // Tambah query ini buat hapus di tb pengguna
    $hapus_pengguna = mysqli_query($koneksi, "DELETE FROM tb_pengguna WHERE username = '$pengguna'") or die (mysqli_error($koneksi));

    if ($hapus_mhs && $hapus_pengguna) {
        echo '
        <script>
            alert("Data Pengguna ' . $nama . ' (NIM: ' . $pengguna . ') Berhasil Dihapus");
            window.location.href="../admin_data_mhs";
        </script>';
    } else {
        $error_msg = mysqli_real_escape_string($koneksi, mysqli_error($koneksi));
        echo '
        <script>
            alert("Gagal menghapus data: ' . $error_msg . '");
            window.location.href="../admin_data_mhs";
        </script>';
    }
?>