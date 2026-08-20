<?php
    require_once '../database/koneksi.php'; 
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Periode Akademik</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="tambah.php" type="button" class="btn btn-primary mb-2">
                  <i class="fas fa-plus"></i> 
                  Tambah Data
                </a>

                <?php
                  $pengguna = $_SESSION['username'];
                ?>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr class="text-center">
                    <th width="5%">No</th>
                    <th>Kode Akademik</th>
                    <th>Semester</th>
                    <th>Tahun</th>
                    <th>Aktif</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $panggil_data_akademik = mysqli_query($koneksi, "SELECT * FROM tb_akademik")or die(mysqli_error($koneksi));

                    $no = 1;
                    $rv = mysqli_num_rows($panggil_data_akademik);
                    if ($rv > 0){
                        while ($data = mysqli_fetch_array($panggil_data_akademik)){
                            $kode_akd = $data['kode_akd'];
                            $semester = $data['semester'];
                            $tahun = $data['tahun'];
                            $is_active = $data['is_active'];
                            ?>
                            <tr class="text-center">
                                <td><?= $no++ ?></td>
                                <td><?= $kode_akd; ?></td>
                                <td><?= $semester; ?></td>
                                <td><?= $tahun; ?></td>
                                <td><?= $is_active; ?></td>
                                <td>
                                  <a href="edit.php?data=<?= $data['kode_akd']; ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-pen"></i>
                                    Edit
                                  </a>
                                  <a href="hapus.php?data=<?= $data['kode_akd']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ga bang?')">
                                    <i class="fas fa-trash"></i>
                                    Hapus
                                  </a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="7">Data tidak ditemukan</td> 
                        </tr>
                        <?php
                    }   
                    ?>
                    </tbody>
                  <tfoot>

                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
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

  <!-- MODAL TAMBAH -->
  <div class="modal fade" id="modal-tambah-user">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Mahasiswa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="tambah.php" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label for="username">NIM</label>
              <input type="number" class="form-control" name="nim" id="nim" placeholder="Masukkan NIM" required>
            </div>

            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama" required>
            </div>

            <div class="form-group">
              <label for="nama">Kontak</label>
              <input type="number" class="form-control" name="kontak" id="kontak" placeholder="Masukkan kontak" required>
            </div>

            <div class="form-group">
              <label for="nama">Email</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan email" required>
            </div>

            <div class="form-group">
              <label>Jenis Kelamin</label>
              <select class="form-control" name="kelamin" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="P">Perempuan</option>
                <option value="L">Laki-laki</option>
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_tambah_mhs" class="btn btn-primary">
              <i class="fas fa-plus"></i>
              Tambah
            </button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

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