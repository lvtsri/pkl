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
  $hal = 'admin_data_kelas_makul';
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
      $id_pertemuan = isset($_GET['data']) ? $_GET['data'] : '';
      $query_pertemuan = mysqli_query($koneksi, "SELECT * FROM tb_pertemuan WHERE id = '$id_pertemuan'")or die(mysqli_error($koneksi));

      $data_pertemuan = mysqli_fetch_array($query_pertemuan);

      $kode_kelas = $data_pertemuan['kode_kelas'];
      $tgl_pertemuan = $data_pertemuan['tanggal'];
      $judul_pertemuan = $data_pertemuan['judul_pertemuan'];
      $status_pertemuan = $data_pertemuan['status_pertemuan'];
      $pertemuan_ke = $data_pertemuan['pertemuan_ke'];

      // --------------------------------------------
      $query_info = mysqli_query($koneksi, "
        SELECT d.*, mk.nama_makul, kmk.nama_kelas, kmk.kode_akd, j.nama_jurusan
        FROM tb_kelas_makul kmk
        JOIN tb_dosen d ON kmk.nik = d.nik
        JOIN tb_jurusan j ON kmk.kode_jurusan = j.kode_jurusan
        JOIN tb_makul mk ON kmk.kode_makul = mk.kode_makul
        WHERE kmk.kode_kelas = '$kode_kelas'
      ");
      $info = mysqli_fetch_assoc($query_info);

      $nik = $info['nik'];
      $nama_dosen = $info['nama'];
      $makul = $info['nama_makul'];
      $kelas = $info['nama_kelas'];
      $img = $info['img'];
      $jurusan = $info['nama_jurusan'];
    ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 title="kelas_makul">Kelas (Kode: <?= $id_pertemuan; ?>) - <?= $makul; ?></h3>
              </div>
              <div class="card-body">
                <div style="display: flex; gap: 50px; align-items: flex-start;">

                  <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                    <div>
                      <!-- <img src="https://i.pinimg.com/1200x/81/2c/9a/812c9a88615239388cd9648aea1be6a4.jpg" alt="Foto Dosen" width="200"> -->
                      <?php
                          if ($info['kelamin'] == 'P') {
                      ?>
                          <img src="<?= (!empty($img)) ? $img : '../asset_web/img/dosen-woman.jpg'?>" style="width: 230px;">
                      <?php
                          } else {
                      ?>
                          <img src="<?= (!empty($img)) ? $img : '../asset_web/img/dosen-man.jpg'?>" style="width: 230px; object-fit: cover;">
                      <?php
                          }
                      ?>
                    </div>
                    <?php
                      if ($status_pertemuan == '1') {
                    ?>
                    <a href="ubah_status.php?id_pertemuan=<?= $id_pertemuan ?>" class="btn btn-danger w-100" onclick="return confirm('Apakah anda yakin ingin menutup presensi ini?')">Tutup Presensi</a>
                    <?php
                      } else {
                    ?>
                      <a href="ubah_status.php?id_pertemuan=<?= $id_pertemuan ?>" class="btn btn-success w-100" onclick="return confirm('Apakah anda yakin ingin membuka presensi ini?')">Buka Presensi</a>
                    <?php
                      }
                    ?>
                  </div>

                  <table class="table table-sm">
                    <tr>
                      <th style="width: 150px;">NIK</th>
                      <td>: <?= $nik; ?></td>
                    </tr>
                    <tr>
                      <th>Nama</th>
                      <td>: <?= $nama_dosen; ?></td>
                    </tr>
                    <tr>
                      <th>Mata Kuliah</th>
                      <td>: <?= $makul; ?></td>
                    </tr>
                    <tr>
                      <th>Judul Materi</th>
                      <td>: <?= $judul_pertemuan; ?></td>
                    </tr>
                    <tr>
                      <th>Kelas</th>
                      <td>: <?= $kelas; ?></td>
                    </tr>
                    <tr>
                      <th>Jurusan</th>
                      <td>: <?= $jurusan; ?></td>
                    </tr>
                    <tr>
                      <th>Hari</th>
                      <td>: <?= date('l') ?> </td>
                    </tr>
                    <tr>
                      <th>Tanggal</th>
                      <td>: <?= date('d F Y'); ?></td>
                    </tr>
                    <tr>
                      <th>Pertemuan ke</th>
                      <td>: <?= $pertemuan_ke; ?> </td>
                    </tr>
                  </table>

                  <?php
                    include('../asset_web/phpqrcode/qrlib.php');
                    // include('config.php');
                    
                    $isi_qr= $kode_kelas;
                    
                    $fileName = 'QR-presensi-'.$kode_kelas.'-'.round(microtime(true)).'.png';
                    
                    $alamat_tujuan = 'qr/';
                    $alamat_qr = $alamat_tujuan.$fileName;
                    
                    // generating
                    QRcode::png($isi_qr, $alamat_qr); 
                  ?>
                                        
                  <div class="text-center">
                    <div style="border: 1px solid blue;">
                      <img src="<?= $alamat_qr ?>" alt="QR Code" width="200">
                    </div>
                    <div>
                      Scan QR untuk melakukan presensi
                    </div>
                  </div>
                </div>

                <div class="card card-primary card-outline mt-3">
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr class="text-center">
                        <th width="5%">No</th>
                        <th>Mahasiswa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no = 1;
                          $query_presensi = mysqli_query($koneksi, "SELECT * FROM tb_presensi WHERE id_pertemuan = '$id_pertemuan'")or die(mysqli_error($koneksi));
                          while ($data_presensi = mysqli_fetch_array($query_presensi)) {
                            $nim = $data_presensi['nim'];
                            $status = $data_presensi['status_kehadiran'];

                            $query_mhs_presensi = mysqli_query($koneksi, "SELECT * FROM tb_mahasiswa WHERE nim = '$nim'")or die(mysqli_error($koneksi));
                            $data_mhs = mysqli_fetch_array($query_mhs_presensi);
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?=  $nim; ?> - <?= $data_mhs['nama']; ?></td>
                            <td class="text-center">
                            <?php
                              $warna = 'danger';
                              if ($status == 'hadir') {
                                $warna = 'success';
                              } elseif($status == 'izin'){
                                $warna = 'warning';
                              } elseif($status == 'sakit'){
                                $warna = 'primary';
                              } else {
                                $warna = 'danger';
                              }
                            ?>  
                            <span class="badge badge-<?= $warna; ?>">
                              <?= $status ?>
                            </span>
                            </td>
                            <td class="text-center">
                              <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-edit-mhs"
                              data-id = <?= $data_presensi['id']; ?> >
                                <i class="fas fa-pen"></i>  
                                Edit
                              </button>
                            </td>
                        </tr>
                        <?php
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
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

  <!-- MODAL EDIT DATA-->
  <div class="modal fade" id="modal-edit-mhs">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Kehadiran Mahasiswa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="ubah_kehadiran.php" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label>Status</label>
              <input type="text" name="id" hidden>
              <input type="text" name="id_pertemuan" value="<?= $id_pertemuan; ?>" hidden>
              
              <select class="form-control" name="status_kehadiran" required>
                <option value="">-- Pilih Kehadiran --</option>
                <option value="hadir">Hadir</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="alpha">Alpha</option>
              </select>
            </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_edit_mhs" class="btn btn-primary">
              <i class="fas fa-pen"></i>
              Simpan
            </button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- REQUIRED SCRIPTS -->
<?php
include '../script.php';
?>

<script>
  $('#modal-edit-mhs').on('show.bs.modal', function(e){
    var id = $(e.relatedTarget).data('id');

    $(e.currentTarget).find('input[name="id"]').val(id);
  })
</script>

</body>
</html>
<?php
}
?>