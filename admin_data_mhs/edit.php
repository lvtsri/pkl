<?php
require_once '../database/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php 
  include'../css.php';

  $hal ='edit_mhs';
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
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user"></i> Profile
          </a>
          <a href="#" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i> logout
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">Sistem Manajemen</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
    <?php 
    include '../sidebar_admin.php' ?>
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
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Edit Data Mahasiswa</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
              <?php 
              // Caraku
              $pengguna = isset($_GET['user']) ? $_GET['user'] : '';
              $query_mhs = mysqli_query($koneksi, "SELECT * FROM tb_mahasiswa WHERE nim = '$pengguna'");
              $data = mysqli_fetch_assoc($query_mhs);

              if (!$data) {
                  echo '<script>alert("Data tidak ditemukan!"); window.location.href="../admin_data_mhs";</script>';
                  exit;
              }

              $nim = $data['nim'];
              $nama = $data['nama'];
              $kontak = $data['kontak'];
              $email = $data['email'];
              $kelamin = $data['kelamin'];

              // Caranya mas Matien, mirip ternyata, cuma beda yang $_GET
              // $nim = @$_GET['nim'];
              // $query_ambil_mhs = mysqli_query($koneksi, "SELECT * FROM tb_mahasiswa WHERE nim = '$nim'");
              // $data_mhs = mysqli_fetch_array($query_ambil_mhs);

              // $nama = $data_mhs['nama'];
              // $kontak = $data_mhs['kontak'];
              // $email = $data_mhs['email'];
              // $kelamin = $data_mhs['kelamin'];
              ?>

              <form action="ubah.php" method="post">
                  <div class="form-group">
                      <label for="nim">NIM</label>
                      <input type="text" name="nim_disable" class="form-control" id="nim" value="<?= $nim; ?>" disabled>
                      <input type="text" name="nim" class="form-control" id="nim" value="<?= $nim; ?>" hidden>
                  </div>
                  <div class="form-group">
                      <label for="name">Nama</label>
                      <input type="text" name="name" class="form-control" id="name" value="<?= $nama; ?>" placeholder="Masukan Nama" required>
                  </div>
                  <div class="form-group">
                      <label for="kontak">Kontak</label>
                      <input type="text" name="kontak" class="form-control" id="kontak" value="<?= $kontak; ?>" placeholder="Masukan kontak" required>
                  </div>
                  <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" name="email" class="form-control" id="email" value="<?= $email; ?>" placeholder="Masukan email" required>
                  </div>
                  <div class="form-group">
                      <label>Jenis Kelamin</label>
                      <select class="form-control" name="kelamin">
                          <option value="">-- Pilih Jenis Kelamin --</option>
                          <option value="P" <?= ($kelamin == 'P') ? 'selected': ''; ?>>Perempuan</option>
                          <option value="L" <?= ($kelamin == 'L') ? 'selected': ''; ?>>Laki-laki</option>
                      </select>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" name="btn_edit" class="btn btn-primary btn-block">Simpan Perubahan</button>
                  </div>
              </form>
          </div>
              <!-- /.card-body -->
        </div>
        <!-- /.card -->
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
      <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data Mahasiswa</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="tambah.php" method="post">
            
            </form>
      
  <!-- Main Footer -->
    <?php include '../footer.php' ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php include '../script.php' ?>
</body>
</html>