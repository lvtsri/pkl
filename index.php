<?php
  require_once 'database/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Manajemen PKL | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="asset_web/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="asset_web/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="asset_web/dist/css/adminlte.min.css">
  <!-- SweetAlert2 Theme -->
  <link rel="stylesheet" href="asset_web/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

  <!-- jQuery & Plugin di Head agar siap dipanggil PHP -->
  <script src="asset_web/plugins/jquery/jquery.min.js"></script>
  <script src="asset_web/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="asset_web/plugins/sweetalert2/sweetalert2.min.js"></script>
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Sistem</b> Manajemen PKL</a>
    </div>
    
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="" method="post">
          <!-- Username -->
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <!-- Password -->
          <div class="input-group mb-3">
            <input type="password" name="sandi" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          
          <!-- Button -->
          <div class="social-auth-links text-center mb-3">
            <button type="submit" name="btn_login" class="btn btn-block btn-primary">
              <i class="fas fa-sign-in-alt mr-2"></i> Login
            </button>
          </div>
        </form>
        
        <?php
          // 1. PROSES LOGIN UTAMA (USERNAME & PASSWORD)
          if (isset($_POST['btn_login'])){
            $pengguna = trim(mysqli_real_escape_string($koneksi, $_POST['username']));
            $password = sha1(trim(mysqli_real_escape_string($koneksi, $_POST['sandi'])));

            $query_cek = mysqli_query($koneksi, "SELECT * FROM tb_pengguna WHERE username = '$pengguna' AND sandi = '$password'") or die(mysqli_error($koneksi));

            $rv = mysqli_num_rows($query_cek);
            
            if ($rv == 0){
              // Jika login gagal: Munculkan SweetAlert Toast di pojok kanan atas
              echo '
                <script>
                  $(document).ready(function(){
                    var Toast = Swal.mixin({
                      toast: true,
                      position: "top-end",
                      showConfirmButton: false,
                      timer: 3000
                    });
                    Toast.fire({
                      icon: "error",
                      title: "Username atau Password salah!"
                    });
                  });
                </script>
              ';
            } else {
              // JIKA LOGIN BERHASIL: Simpan session temp_username & panggil modal PIN
              $_SESSION['temp_username'] = $pengguna;

              echo '
              <script>
                $(document).ready(function(){
                  $("#modal-default").modal("show");
                });
              </script>
              ';
            }
          }

          // 2. PROSES VERIFIKASI PIN & REDIRECT KE HOME
          if(isset($_POST['btn_verify_pin'])){
            $input_pin = trim(mysqli_real_escape_string($koneksi, $_POST['pin']));
            $username_aktif = isset($_SESSION['temp_username']) ? $_SESSION['temp_username'] : '';

            $query_pin = mysqli_query($koneksi, "SELECT * FROM tb_pengguna WHERE username = '$username_aktif' AND pin = '$input_pin'");

            if ($username_aktif && mysqli_num_rows($query_pin) > 0){
              // PIN Valid! Ambil peran user
              $data = mysqli_fetch_assoc($query_pin);
              $peran = $data['peran'];

              // Set session utama resmi
              $_SESSION['username'] = $username_aktif;
              $_SESSION['peran'] = $peran;

              // Hapus session temporary
              unset($_SESSION['temp_username']);

              // Redirect langsung berdasarkan peran
              echo '<script>';
              if ($peran == 'M') {
                  echo 'window.location = "home_mahasiswa/";';
              } elseif ($peran == 'A') {
                  echo 'window.location = "home_admin/";';
              } else {
                  echo 'window.location = "home_dosen/";';
              }
              echo '</script>';
            } else {
              // Jika PIN salah, hapus session temporary dan kembalikan ke halaman login
              unset($_SESSION['temp_username']);

              echo '
                <script>
                  alert("PIN Salah! Kembali ke halaman login.");
                  window.location = "index.php";
                </script>
              ';
            }
          }
        ?>
      </div>
    </div>
  </div>

  <!-- MODAL INPUT PIN -->
  <div class="modal fade" id="modal-default" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="" method="post">
          <div class="modal-header">
            <h4 class="modal-title">Verifikasi Keamanan PIN</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p class="text-info">Login berhasil! Masukkan PIN keamanan Anda untuk melanjutkan ke halaman utama:</p>
            <div class="form-group">
              <input type="password" name="pin" class="form-control" placeholder="Masukkan PIN Anda" maxlength="6" required autofocus>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <a href="index.php" class="btn btn-default">Batal</a>
            <button type="submit" name="btn_verify_pin" class="btn btn-primary">Konfirmasi PIN</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- AdminLTE App Script -->
  <script src="asset_web/dist/js/adminlte.min.js"></script>
</body>
</html>