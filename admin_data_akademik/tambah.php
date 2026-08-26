<?php
require_once '../database/koneksi.php';
$authority = @$_SESSION['peran'];
if($authority != 'A'){
  echo '<script>
    window.location.href = "../logout.php";
    alert("Anda bukan admin!!! Akan segera di logout-kan");
  </script>';
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
  include '../css.php';
  $hal = 'admin_data_akademik';
  ?>
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <?= $_SESSION['nama']; ?> - [<?= $_SESSION['peran']; ?>]
          <i class="far fa-user"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profil
          </a>

          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        
        <div class="info">
          <a href="#" class="d-block">Sistem Manajemen PKL</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
        <?php
        include '../sidebar_admin.php';
        ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Periode Akademmik</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="password_lama">Kode Akademik</label>
                                <input type="text" name="kode_akd" class="form-control" placeholder="Masukkan kode makul" required>
                            </div>
                            <div class="form-group">
                                <label>Semester</label>
                                <select class="form-control" name="semester" required>
                                    <option value="">-- Pilih Semester --</option>
                                    <option value="GL">Ganjil</option>
                                    <option value="GN">Genap</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input type="number" name="tahun" class="form-control" placeholder="Masukkan tahun" required>
                            </div>
                            <div class="form-group">
                                <label>Aktif</label>
                                <select class="form-control" name="is_active" required>
                                    <option value="">-- Pilih Aktifasi --</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Non Aktif</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-block" name="btn_tambah"><i class="fas fa-edit"></i> Tambah </button>
                            </div>
                        </form>
                        <?php

                        if (isset($_POST['btn_tambah'])){
                            $kode_akd = trim(mysqli_real_escape_string($koneksi, $_POST['kode_akd']));
                            $semester = trim(mysqli_real_escape_string($koneksi, $_POST['semester']));
                            $tahun = trim(mysqli_real_escape_string($koneksi, $_POST['tahun']));
                            $is_active = trim(mysqli_real_escape_string($koneksi, $_POST['is_active']));

                            $cek_akd = mysqli_query($koneksi, "SELECT kode_akd FROM tb_akademik WHERE kode_akd = '$kode_akd'") or die (mysqli_error($koneksi));
                            $rv = mysqli_num_rows($cek_akd);

                            if ($rv == 1){
                                echo '
                                <script>
                                    alert("Kode Akademi sudah Terdaftar");
                                    window.location.href="../admin_data_akademik"
                                </script>';
                            } else {
                                $query_simpan = mysqli_query($koneksi, "INSERT INTO tb_akademik (
                                    kode_akd, semester, tahun, is_active
                                ) VALUES (
                                    '$kode_akd','$semester','$tahun','$is_active'
                                )") or die(mysqli_error($koneksi));

                                echo '
                                <script> 
                                    alert("Data periode akademi berhasil disimpan");
                                    window.location.href="../admin_data_akademik"    
                                </script>';
                            }
                        }

                        ?>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php
  include '../footer.php';
  ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php
include '../script.php';
?>
</body>
</html>
<?php
}
?>