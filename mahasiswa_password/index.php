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
  // session_start();
  $hal = 'mhs_pass';
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
        include '../sidebar_mahasiswa.php';
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
        <div class="row">
          <div class="col-lg-4">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-lock"></i> Ganti Password
                </h3>
              </div>
              <div class="card-body">
                <form action="" method="post">
                  <div class="form-group">
                    <label for="password_lama">Old Password</label>
                    <?php
                      $pengguna = @$_SESSION['username'];
                    ?>
                    <input type="text" name="pengguna" value="<?= $pengguna; ?>" class="form-control" hidden>
                    <input type="password" name="password_lama" class="form-control" placeholder="Masukkan password lama" required>
                  </div>
                  <div class="form-group">
                    <label for="password_baru">New Password</label>
                    <input type="password" name="password_baru" class="form-control" maxlength="10" placeholder="Masukkan password baru max. 10 char" required>
                  </div>
                  <div class="form-group">
                    <label for="pin2fa">PIN</label>
                    <input type="number" name="pin" class="form-control" maxlength="6" placeholder="Masukkan PIN anda" required>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block" name="btn_edit"><i class="fas fa-edit"></i> Ubah Password</button>
                  </div>
                </form>
                <?php
                  if(isset($_POST['btn_edit'])){  //Trigger btn edit ketika ditekan
                    $pengguna = trim(mysqli_escape_string($koneksi, $_POST['pengguna']));   //simpan value pengguna pada variabel lokal $pengguna
                    // V query panggil pin dan sandi dari tabel pengguna di db
                    $query_pengguna = mysqli_query($koneksi, "SELECT sandi, pin FROM tb_pengguna WHERE username = '$pengguna'") or die(mysqli_error($koneksi));
                    $arr = mysqli_fetch_assoc($query_pengguna);   //mendefinisikan variabel $arr untuk nyimpan array dari query 
                    
                    $sandi = $arr['sandi'];   //menampung value sandi pada array ke dalam variabel $sandi
                    $pin = $arr['pin'];   //menampung value pin pada array ke dalam variabel $pin
                    
                    $input_sandi = sha1(trim(mysqli_real_escape_string($koneksi, $_POST['password_lama'])));    //menyimpan inputan sandi lama
                    $input_sandi_baru = sha1(trim(mysqli_real_escape_string($koneksi, $_POST['password_baru'])));   //menyimpan inputan sandi baru
                    $input_pin = trim(mysqli_real_escape_string($koneksi, $_POST['pin']));    //menyimpan inputan pin
                    
                    if($input_sandi == $sandi && $input_pin == $pin){   //membuat kondisi if inputan sandi lama & pin sesuai dengan yang di db
                      $query_update = mysqli_query($koneksi, "UPDATE tb_pengguna SET sandi = '$input_sandi_baru' WHERE username = '$pengguna'") or die(mysqli_error($koneksi));
                      echo 
                      '<script>
                        alert("Password berhasil diubah!");
                        window.location.href = "../mahasiswa_password";
                      </script>';
                    } else {
                      echo 
                      '<script>
                        alert("Password lama atau PIN salah");
                        window.location.href = "../mahasiswa_password";
                      </script>';
                    }
                  }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

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