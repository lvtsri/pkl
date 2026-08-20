<?php
require_once  '../database/koneksi.php';
$pengguna_login = $_SESSION['username'];
$pengguna = @$_GET['user'];

if (empty($pengguna)) {
    header("Location:../admin_data_administrator/");
    exit;
}

$cek_admin = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM tb_pengguna WHERE peran= 'A'")or die(mysqli_error($koneksi));

$data = mysqli_fetch_assoc($cek_admin);
$jumlah = $data['jumlah'];

$cek_target = mysqli_query($koneksi, "SELECT peran FROM tb_pengguna WHERE username = '$pengguna'")or die(mysqli_error($koneksi));
$data_target = mysqli_fetch_assoc($cek_target);
$peran_target = $data_target['peran'];


if ($pengguna_login == $pengguna) {
    echo '<script>
        alert("Gagal: Anda tidak dapat menghapus akun Anda sendiri saat sedang login"); 
        window.location.href="../admin_data_administrator/";
    </script>';
} elseif ($peran_target == 'A' && $jumlah <= 1) {
    echo '<script>
        alert("Gagal: Akun Admin ini adalah satu-satunya yang tersisa dan tidak boleh dihapus!"); 
        window.location.href="../admin_data_administrator/";
    </script>';
} else {
    if ($peran_target == 'M') {
        mysqli_query($koneksi, "DELETE FROM tb_mahasiswa WHERE nim = '$pengguna'") or die(mysqli_error($koneksi));
    } elseif ($peran_target == 'D') {
        mysqli_query($koneksi, "DELETE FROM tb_dosen WHERE nik = '$pengguna'") or die(mysqli_error($koneksi));
    }
    mysqli_query($koneksi, "DELETE FROM tb_pengguna WHERE username = '$pengguna'") or die (mysqli_error($koneksi));
    
    echo '<script>
        alert("Data Pengguna '.$pengguna.' Berhasil Dihapus!");
        window.location.href="../admin_data_administrator/";
    </script>';
}
?> 