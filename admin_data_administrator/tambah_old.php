<?php
require_once '../database/koneksi.php';

if (isset($_POST['username'])) {
    $username   = mysqli_real_escape_string($koneksi, $_POST['username']);
    $peran      = mysqli_real_escape_string($koneksi, $_POST['peran']);
    $pin        = mysqli_real_escape_string($koneksi, $_POST['pin']);
    $password   = $_POST['password'];
    $repassword = $_POST['repassword'];

    // 1. Cek apakah username sudah ada di database
    $cek_username = mysqli_query($koneksi, "SELECT * FROM tb_pengguna WHERE username = '$username'");
    if (mysqli_num_rows($cek_username) > 0) {
        echo "<script>
                alert('Username tersebut sudah digunakan! Silakan gunakan username lain.'); 
                window.location='index.php';
            </script>";
        exit;
    }

    // 2. Validasi konfirmasi password
    if ($password !== $repassword) {
        echo "<script>
                alert('Konfirmasi password tidak sesuai!'); 
                window.location='index.php';
            </script>";
        exit;
    }

    // 3. Enkripsi password menggunakan SHA-1
    $password_hashed = sha1($password);

    // 4. Query insert ke database
    $query = "INSERT INTO tb_pengguna (username, password, peran, pin) VALUES ('$username', '$password_hashed', '$peran', '$pin')";
    $result = mysqli_query($koneksi, $query);

    // 5. Cek keberhasilan penyimpanan
    if ($result) {
        echo "<script>
                alert('Data pengguna berhasil ditambahkan!'); 
                window.location='index.php';
            </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan data: " . mysqli_error($koneksi) . "'); 
                window.location='index.php';
            </script>";
    }
} else {
    header("Location: index.php");
    exit;
}
?>