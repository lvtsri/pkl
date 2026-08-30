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
  $hal = 'admin_jurusan';
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
        <?php
         $pengguna = $_SESSION['username'];
        ?>

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Jurusan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <a href="tambah.php" class="btn btn-primary mb-2">
                    <i class="fas fa-plus"></i> 
                    Tambah Data
                </a>
                <a href="excel.php" type="button" class="btn btn-success mb-2" target="_blank">
                  <i class="fas fa-file-excel"></i> 
                  Ekspor Data
                </a>
                <?php
                    $pengguna = $_SESSION['username'];
                ?>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr class="text-center">
                    <th width="5%">No</th>
                    <th>Kode Jurusan</th>
                    <th>Nama Jurusan</th>
                    <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $panggil_data = mysqli_query($koneksi, "SELECT * FROM tb_jurusan")or die(mysqli_error($koneksi));
                    $no = 1;
                    $rv = mysqli_num_rows($panggil_data);
                    if ($rv > 0){
                        while ($data = mysqli_fetch_array($panggil_data)){
                        $kode_jurusan = $data['kode_jurusan'];
                        $nama_jurusan = $data['nama_jurusan'];
                    ?>
                        <tr class="text-center">
                            <td><?= $no++ ?></td>
                            <td><?= $kode_jurusan; ?></td>
                            <td><?= $nama_jurusan; ?></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit"
                                    data-kode="<?= $kode_jurusan; ?>"
                                    data-nama="<?= $nama_jurusan; ?>"
                                >
                                    <i class="fas fa-pen"></i>
                                </button>
                                <a href="hapus.php?kode=<?= $kode_jurusan; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ga bang?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="3">Data tidak ditemukan</td> 
                        </tr>
                        <?php
                    }   
                    ?>
                    </tbody>
                    <tfoot>
                    <!-- kode -->
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
  <!-- MODAL EDIT -->
  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data Jurusan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="ubah.php" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label for="nim">Kode Jurusan</label>
              <input type="number" class="form-control" name="kode_jurusan" required readonly>
            </div>

            <div class="form-group">
              <label for="nama">Nama Jurusan</label>
              <input type="text" class="form-control" name="nama_jurusan" required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_edit" class="btn btn-warning">
              <i class="fas fa-pen"></i>
              Edit Jurusan
            </button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
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
<script>
  $('#modal-edit').on('show.bs.modal', function(e){
    var kode = $(e.relatedTarget).data('kode');
    var nama = $(e.relatedTarget).data('nama');

    $(e.currentTarget).find('input[name="kode_jurusan"]').val(kode);
    $(e.currentTarget).find('input[name="nama_jurusan"]').val(nama);
  });
</script>
</body>
</html>
<?php
}
?>