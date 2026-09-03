<?php
require_once '../database/koneksi.php';
$authority = @$_SESSION['peran'];
if($authority != 'A'){
  echo '<script>
    window.location.href = "../logout.php";
    alert("Anda bukan admin!!! Akan segera di logout-kan");
  </script>';
  exit;
} else {

  $kode_kelas = isset($_GET['data']) ? $_GET['data'] : '';

  $query_info_kelas = mysqli_query($koneksi, "
    SELECT k.*, a.semester, a.tahun, mk.nama_makul, j.nama_jurusan, ds.nama AS nama_dosen
    FROM tb_kelas_makul k
    JOIN tb_akademik a ON k.kode_akd = a.kode_akd
    JOIN tb_makul mk ON k.kode_makul = mk.kode_makul
    JOIN tb_jurusan j ON k.kode_jurusan = j.kode_jurusan
    JOIN tb_dosen ds ON k.nik = ds.nik
    WHERE k.kode_kelas = '$kode_kelas'
  ") or die(mysqli_error($koneksi));

  $info = mysqli_fetch_assoc($query_info_kelas);

  if ($info) {
      $semester_teks = ($info['semester'] == 'GL') ? 'Ganjil' : 'Genap';
      $periode_gabung = $info['tahun'] . ' - ' . $semester_teks;
  } else {
      $periode_gabung = '-';
  }
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
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
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
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">Sistem Manajemen PKL</a>
        </div>
      </div>
      <?php
      include '../sidebar_admin.php';
      ?>
    </div>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
              <div class="card card-primary card-outline">
                  <div class="card-body">
                    <div style="display: flex; gap: 50px;">
                      <table class="table table-borderless">
                        <tr>
                          <th style="padding: 4px 8px; width: 150px;">Nama Kelas</th>
                          <td style="padding: 4px 8px;">: <?= $info['nama_kelas'] ?? '-'; ?></td>
                        </tr>
                        <tr>
                          <th style="padding: 4px 8px;">Periode</th>
                          <td style="padding: 4px 8px;">: <?= $periode_gabung; ?></td>
                        </tr>
                        <tr>
                          <th style="padding: 4px 8px;">Mata Kuliah</th>
                          <td style="padding: 4px 8px;">: <?= $info['nama_makul'] ?? '-'; ?></td>
                        </tr>
                      </table>
                      <table class="table table-borderless">
                        <tr>
                          <th style="padding: 4px 8px; width: 150px;">Jurusan</th>
                          <td style="padding: 4px 8px;">: <?= $info['nama_jurusan'] ?? '-'; ?></td>
                        </tr>
                        <tr>
                          <th style="padding: 4px 8px;">Dosen</th>
                          <td style="padding: 4px 8px;">: <?= $info['nama_dosen'] ?? '-'; ?></td>
                        </tr>
                      </table>
                    </div>
                  </div>
              </div>
              
              <div class="card card-primary card-outline">
                <div class="card-body">
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah">
                    <i class="fas fa-plus"></i> Tambah Pertemuan
                    </button>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr class="text-center">
                    <th width="5%">No</th>
                    <th>Pertemuan ke-</th>
                    <th>Judul Pertemuan</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query_pertemuan = mysqli_query($koneksi, "SELECT * FROM tb_pertemuan WHERE kode_kelas = '$kode_kelas'") or die(mysqli_error($koneksi));

                    $no = 1;
                    $rv = mysqli_num_rows($query_pertemuan);

                    if ($rv > 0){
                      while ($data = mysqli_fetch_assoc($query_pertemuan)){
                  ?>
                        <tr class="text-center">
                            <td><?= $no++ ?></td>
                            <td><?= $data['pertemuan_ke']; ?></td>
                            <td><?= $data['judul_pertemuan']; ?></td>
                            <td><?= date('d-m-Y', strtotime($data['tanggal'])) ?></td>
                            <td>
                              <a href="presensi.php?data=<?= $data['id'] ?>" class="btn btn-warning">
                                <i class="fas fa-qrcode"></i>
                              </a>
                            </td>
                        </tr>
                  <?php
                      }
                    } else {
                  ?>
                        <tr>
                            <td colspan="5" class="text-center">Data tidak ditemukan di kelas ini</td> 
                        </tr>
                  <?php
                    }   
                  ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>

    <?php
        if(isset($_POST['btn_hapus'])){

        }
    ?>

  <!-- MODAL TAMBAH DATA-->
  <div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Pertemuan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <div class="form-group">
                <input type="text" name="kode_kelas" value="<?= $kode_kelas; ?>" hidden>
              <label>Judul Pertemuan</label>
              <input type="text" class="form-control" name="judul_pertemuan" placeholder="Masukkan judul pertemuan" required>
            </div>

            <div class="form-group">
              <label>Tanggal Pertemuan</label>
              <input type="date" class="form-control" name="tanggal" required>
            </div>

          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_tambah_pertemuan" class="btn btn-primary">
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

  <?php
    if (isset($_POST['btn_tambah_pertemuan'])){
        $kode_kelas = trim(mysqli_real_escape_string($koneksi, $_POST['kode_kelas']));
        $tanggal = trim(mysqli_real_escape_string($koneksi, $_POST['tanggal']));
        $judul = trim(mysqli_real_escape_string($koneksi, $_POST['judul_pertemuan']));

        $tgl_skrg = Date('d-m-Y');
        if($tanggal < $tgl_skrg){
            echo '<script>
                alert("Tanggal pertemuan minimal hari ini!")
                window.location.href="../admin_data_kelas_makul/pertemuan.php?data=$kode_kelas";
            </script>';
        }

        $pertemuan_ke = 1;
        $panggil_pertemuan = mysqli_query($koneksi, "SELECT MAX(pertemuan_ke) as pertemuan FROM tb_pertemuan WHERE kode_kelas = '$kode_kelas'")or die(mysqli_error($koneksi));
        $data_pertemuan = mysqli_fetch_array($panggil_pertemuan);
        $pertemuan_terakhir = $data_pertemuan['pertemuan'];

        $status_pertemuan = '1';

        if ($pertemuan_terakhir < 1) {
            $query_simpan = mysqli_query($koneksi, "INSERT INTO tb_pertemuan VALUES 
                (null, '$kode_kelas','$tanggal','$judul', '$status_pertemuan', '$pertemuan_ke')") or die(mysqli_error($koneksi));

            $id_pertemuan = mysqli_insert_id($koneksi);

            $query_peserta = mysqli_query($koneksi, "SELECT nim FROM tb_detail_kls_mk WHERE kode_kelas = '$kode_kelas'")or die(mysqli_error($koneksi));

            $rv = mysqli_num_rows($query_peserta);

            if($rv > 0){
              $status_kehadiran = 'alpha';
              while ($data_peserta = mysqli_fetch_array($query_peserta)) {
                $nim = $data_peserta['nim'];
                $query_simpan_peserta = mysqli_query($koneksi, "INSERT INTO tb_presensi VALUES
                  (null, '$id_pertemuan', '$nim', '$status_kehadiran')
                ")or die(mysqli_error($koneksi));
              }
            }
            
            echo "
                <script>
                    alert('Pertemuan telah berhasil disimpan');
                    window.location.href='../admin_data_kelas_makul/presensi.php?data=$id_pertemuan';
                </script>
            ";
        } else {
            $pertemuan_terakhir++;
            $query_simpan = mysqli_query($koneksi, "INSERT INTO tb_pertemuan VALUES 
                (null, '$kode_kelas','$tanggal','$judul', '$status_pertemuan', '$pertemuan_terakhir')") or die(mysqli_error($koneksi));

            $id_pertemuan = mysqli_insert_id($koneksi);

            $query_peserta = mysqli_query($koneksi, "SELECT nim FROM tb_detail_kls_mk WHERE kode_kelas = '$kode_kelas'")or die(mysqli_error($koneksi));

            $rv = mysqli_num_rows($query_peserta);

            if($rv > 0){
              $status_kehadiran = 'alpha';
              while ($data_peserta = mysqli_fetch_array($query_peserta)) {
                $nim = $data_peserta['nim'];
                $query_simpan_peserta = mysqli_query($koneksi, "INSERT INTO tb_presensi VALUES
                  (null, '$id_pertemuan', '$nim', '$status_kehadiran')
                ")or die(mysqli_error($koneksi));
              }
            }

            echo "
                <script>
                    alert('Pertemuan telah berhasil disimpan');
                    window.location.href='../admin_data_kelas_makul/presensi.php?data=$id_pertemuan';
                </script>
            ";
        }
    }
  ?>
  
  <!-- MODAL IMPOR -->
  <div class="modal fade" id="modal-impor">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Impor Data Mahasiswa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="impor.php" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <input type="text" name="kode_kelas" value="<?= $kode_kelas ?>" hidden>
              <label for="file">Upload File</label>
              <input type="file" class="form-control" name="file_excel" required>
            </div>
            <div class="form-group">
              <label for="template">Download Template Excel</label><br>
              <a href="template/template_mhs_kls_kosongan.xls" class="btn btn-success" download>
                <i class="fas fa-download"></i> 
                Download
              </a>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_impor" class="btn btn-success">
              Impor Data
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

<!-- REQUIRED SCRIPTS -->
<?php
include '../script.php';
?>
</body>
</html>
<?php
}
?>