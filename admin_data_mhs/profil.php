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
  $hal = 'admin_mhs';
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
    <?php
        $mahasiswa = @$_GET['user'];

        $query_ambil_data = mysqli_query($koneksi, "SELECT * FROM tb_mahasiswa WHERE nim = '$mahasiswa'");
        $data = mysqli_fetch_assoc($query_ambil_data);
        if(!$data){
            echo '<script>
                alert("Data mahasiswa tidak ditemukan!");
                window.location.href="../admin_data_mhs";
                exit;
            </script>';
        }

        $nim = $data['nim'];
        $nama = $data['nama'];
        $kontak = $data['kontak'];
        $email = $data['email'];
        $kelamin = $data['kelamin'];
        $img = $data['img'];
    ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Profil Mahasiswa</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 text-center">
                            <!-- <img src="../asset_web/img/mhs-woman.jpg" alt="Foto Profil" class="img-fluid shadow-sm" width="150"> -->
                            <?php
                                if ($kelamin == 'P') {
                            ?>
                                <img src="<?= (!empty($img))?$img : '../asset_web/img/mhs-woman.jpg'?>" style="width: 190px; height: 190px; object-fit: cover;">
                            <?php
                                } else {
                            ?>
                                <img src="<?= (!empty($img))?$img : '../asset_web/img/mhs-man.jpg'?>" style="width: 190px; height: 190px; object-fit: cover;">
                            <?php
                                }
                            ?>
                        </div>
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-ubah-foto" data-nim="<?= $nim; ?>">
                            <i class="fas fa-camera"></i> Edit Foto
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Data Profil</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th style="width: 20%;">NIM</th>
                                <td>: <?= $nim ?></td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>: <?= $nama ?></td>
                            </tr>
                            <tr>
                                <th>Kontak</th>
                                <td>: <?= $kontak ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>: <?= $email ?></td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>: <?= ($kelamin == 'P') ? 'Perempuan' : 'Laki-laki'; ?></td>
                            </tr>
                        </table>
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

  <!-- MODAL UBAH FOTO MHS -->
  <div class="modal fade" id="modal-ubah-foto">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ubah Foto Mahasiswa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="ubah_foto.php" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label for="file">Upload File</label>
                <input type="text" name="nim" hidden>
              <input type="file" class="form-control" name="file_foto" required>
            </div>
          </div>
          <!-- btn -->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_ubah_foto" class="btn btn-primary">
              Ubah Foto
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
<script>
  $('#modal-ubah-foto').on('show.bs.modal', function(e){
    var nim = $(e.relatedTarget).data('nim');

    $(e.currentTarget).find('input[name="nim"]').val(nim);
  });
</script>
</body>
</html>
<?php
}
?>
