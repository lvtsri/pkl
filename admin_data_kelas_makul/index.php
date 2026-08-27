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
        <!-- isi idk -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  
  <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <form action="" method="post">
                <div class="row">
                    <div class="col-2">
                        <?php 
                        $panggil_periode_akademik = mysqli_query($koneksi, "SELECT * FROM tb_akademik" )or die(mysqli_error($koneksi));

                        ?>
                        <div class="form-group">                    
                            <select class="form-control" name="semester" id="">
                              <option value="">-- Pilih periode --</option>
                                <?php 
                                while ($data_periode = mysqli_fetch_array($panggil_periode_akademik)){
                                    $kode_akd = $data_periode['kode_akd'];
                                    $semester = $data_periode['semester'];
                                    $tahun = $data_periode['tahun'];?>
                                <option value="<?= $kode_akd; ?>">
                                  <?= $tahun?> - <?= ($semester == 'GL')? 'Ganjil' : 'Genap'?>
                                </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                      <button type="submit" name="btn_cari" class="btn btn-warning mb-2"><i class="fas fa-search"></i> Tampilkan Data</button>
                      <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah-data">
                        <i class="fas fa-plus"></i> 
                        Tambah Data
                      </button>
                    </div>
                </div>
            </form>
            <?php 
            if (isset($_POST['btn_cari'])){
              $filter = trim(mysqli_real_escape_string($koneksi, $_POST['semester']));
            ?>
            <div class="row">
              <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Data Kelas Mata Kuliah untuk Periode Akademik: <?= $filter; ?></h3>
                    </div>
                    <div class="card-body">
                <?php
                  $pengguna = $_SESSION['username'];
                ?>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr class="text-center">
                      <th width="5%">No</th>
                      <th>Nama Kelas</th>
                      <th>Periode Akademik</th>
                      <th>Mata Kuliah</th>
                      <th>Jurusan</th>
                      <th>Dosen</th>
                      <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                      $panggil_kelas = mysqli_query($koneksi, "SELECT * FROM tb_kelas_makul WHERE kode_akd = '$filter'")or die(mysqli_error($koneksi));
                      $query_akd = mysqli_query($koneksi, "SELECT * FROM tb_akademik WHERE kode_akd = '$kode_akd'")or die(mysqli_error($koneksi));
                      $query_makul = mysqli_query($koneksi, "SELECT * FROM tb_makul")or die(mysqli_error($koneksi));
                      $query_jurusan = mysqli_query($koneksi, "SELECT * FROM tb_jurusan")or die(mysqli_error($koneksi));
                      $query_dosen = mysqli_query($koneksi, "SELECT * FROM tb_dosen")or die(mysqli_error($koneksi));

                      // $data_akd = mysqli_fetch_assoc($query_akd);
                      // $data_makul = mysqli_fetch_assoc($query_makul);
                      // $data_jurusan = mysqli_fetch_assoc($query_jurusan);
                      // $data_dosen = mysqli_fetch_assoc($query_dosen);
            
                      $no = 1;
                      $rv = mysqli_num_rows($panggil_kelas);
                      if ($rv > 0){
                          while ($data = mysqli_fetch_array($panggil_kelas)){
                              $kode_kelas = $data['kode_kelas'];
                              $kode_akd = $data['kode_akd'];
                              $kode_makul = $data['kode_makul'];
                              $kode_jurusan = $data['kode_jurusan'];
                              $nik = $data['nik'];
                              $nama_kelas = $data['nama_kelas'];

                              $query_akd = mysqli_query($koneksi, "SELECT * FROM tb_akademik WHERE kode_akd = '$kode_akd'");
                              $data_akd = mysqli_fetch_assoc($query_akd);

                              $query_makul = mysqli_query($koneksi, "SELECT * FROM tb_makul WHERE kode_makul = '$kode_makul'");
                              $data_makul = mysqli_fetch_assoc($query_makul);

                              $query_jurusan = mysqli_query($koneksi, "SELECT * FROM tb_jurusan WHERE kode_jurusan = '$kode_jurusan'");
                              $data_jurusan = mysqli_fetch_assoc($query_jurusan);

                              $query_dosen = mysqli_query($koneksi, "SELECT * FROM tb_dosen WHERE nik = '$nik'");
                              $data_dosen = mysqli_fetch_assoc($query_dosen);
                              ?>
                              <tr class="text-center">
                                  <td><?= $no++ ?></td>
                                  <td><?= $nama_kelas; ?></td>
                                  <td><?= $kode_akd; ?> - <?= $data_akd['semester'] == 'GN' ? 'Genap' : 'Ganjil'; ?></td>
                                  <td><?= $kode_makul; ?> - <?= $data_makul['nama_makul']; ?></td>
                                  <td><?= $kode_jurusan; ?> - <?= $data_jurusan['nama_jurusan']; ?></td>
                                  <td><?= $nik; ?> - <?= $data_dosen['nama']; ?></td>
                                  <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit"
                                      data-kode="<?= $kode_kelas ?>"
                                      data-akademik="<?= $kode_akd ?>"
                                      data-makul="<?= $kode_makul ?>"
                                      data-jurusan="<?= $kode_jurusan ?>"
                                      data-nik="<?= $nik ?>"
                                      data-kelas="<?= $nama_kelas ?>"
                                      >
                                      <i class="fas fa-pen"></i>
                                      Edit
                                    </button>
                                    <a href="hapus.php?data=<?= $data['kode_kelas']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ga bang?')">
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
                      <!--  -->
                    </tfoot>
                  </table>
                    </div>
                </div>
              </div>
            </div>
            <?php 
            }
            ?>
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

  <!-- MODAL TAMBAH DATA-->
  <div class="modal fade" id="modal-tambah-data">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Kelas Mata Kuliah</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="tambah.php" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label>Kode Akademik</label>
              <select class="form-control" name="kode_akd" required>
                <option value="">-- Pilih Kode Akademik --</option>
                  <?php 
                    $query_akademik = mysqli_query($koneksi, "SELECT * FROM tb_akademik");
                    while($data_akademik = mysqli_fetch_array($query_akademik)){
                      $kode_akd = $data_akademik['kode_akd'];
                      $semester = $data_akademik['semester'];
                      $tahun = $data_akademik['tahun'];
                    ?>

                    <option value="<?= $kode_akd; ?>">
                      <?= $tahun ?> - <?= ($semester == 'GL')? 'Ganjil' : 'Genap' ?>
                    </option>
                  ?>
                  <?php
                    }
                  ?>
              </select>
            </div>

            <div class="form-group">
              <label>Kode Mata Kuliahk</label>
              <select class="form-control" name="kode_makul" required>
                <option value="">-- Pilih Kode Mata Kuliah --</option>
                  <?php 
                    $query_makul = mysqli_query($koneksi, "SELECT * FROM tb_makul");
                    while($data_makul = mysqli_fetch_array($query_makul)){
                  ?>
                  <option value="<?= $data_makul['kode_makul'] ?>">
                    <?= $data_makul['kode_makul'] ?> - <?= $data_makul['nama_makul'] ?>
                  </option>
                  <?php
                  }
                  ?>
              </select>
            </div>

            <div class="form-group">
              <label>Kode Jurusan</label>
              <select class="form-control" name="kode_jurusan" required>
                <option value="">-- Pilih Kode Jurusan --</option>
                  <?php 
                    $query_jurusan = mysqli_query($koneksi, "SELECT * FROM tb_jurusan");
                    while($data_jurusan = mysqli_fetch_array($query_jurusan)): 
                  ?>
                  <option value="<?= $data_jurusan['kode_jurusan'] ?>">
                    <?= $data_jurusan['kode_jurusan'] ?> - <?= $data_jurusan['nama_jurusan'] ?>
                  </option>
                  <?php endwhile; ?>
              </select>
            </div>

            <div class="form-group">
              <label>NIK Dosen</label>
              <select class="form-control" name="nik" required>
                <option value="">-- Pilih NIK --</option>
                  <?php 
                    $query_dosen = mysqli_query($koneksi, "SELECT * FROM tb_dosen");
                    while($data_dosen = mysqli_fetch_array($query_dosen)): 
                  ?>
                  <option value="<?= $data_dosen['nik'] ?>">
                    <?= $data_dosen['nik'] ?> - <?= $data_dosen['nama'] ?>
                  </option>
                  <?php endwhile; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="nama">Nama Kelas</label>
              <input type="text" class="form-control" name="nama_kelas" placeholder="Masukkan Nama Kelas" required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_tambah_kelas" class="btn btn-primary">
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

  <!-- MODAL EDIT DATA-->
  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data Kelas Mata Kuliah</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="ubah.php" method="post">
          <div class="modal-body">
            <div class="form-group">
              <input type="text" name="kode_kelas" hidden required>
              <label>Kode Akademik</label>
              <select class="form-control" name="kode_akd" required>
                <option value="">-- Pilih Kode Akademik --</option>
                  <?php 
                    $query_akademik = mysqli_query($koneksi, "SELECT * FROM tb_akademik");
                    while($data_akademik = mysqli_fetch_array($query_akademik)){
                      $kode_akd = $data_akademik['kode_akd'];
                      $semester = $data_akademik['semester'];
                      $tahun = $data_akademik['tahun'];?>  

                    <option value="<?= $kode_akd; ?>">
                      <?= $tahun ?> - <?= ($semester == 'GL')? 'Ganjil' : 'Genap' ?>
                    </option>
                  ?>
                  <?php
                    }
                  ?>
              </select>
            </div>

            <div class="form-group">
              <label>Kode Mata Kuliah</label>
              <select class="form-control" name="kode_makul" required>
                <option value="">-- Pilih Kode Mata Kuliah --</option>
                  <?php 
                    $query_makul = mysqli_query($koneksi, "SELECT * FROM tb_makul");
                    while($data_makul = mysqli_fetch_array($query_makul)){
                  ?>
                  <option value="<?= $data_makul['kode_makul'] ?>">
                    <?= $data_makul['kode_makul'] ?> - <?= $data_makul['nama_makul'] ?>
                  </option>
                  <?php
                  }
                  ?>
              </select>
            </div>

            <div class="form-group">
              <label>Kode Jurusan</label>
              <select class="form-control" name="kode_jurusan" required>
                <option value="">-- Pilih Kode Jurusan --</option>
                  <?php 
                    $query_jurusan = mysqli_query($koneksi, "SELECT * FROM tb_jurusan");
                    while($data_jurusan = mysqli_fetch_array($query_jurusan)): 
                  ?>
                  <option value="<?= $data_jurusan['kode_jurusan'] ?>">
                    <?= $data_jurusan['kode_jurusan'] ?> - <?= $data_jurusan['nama_jurusan'] ?>
                  </option>
                  <?php endwhile; ?>
              </select>
            </div>

            <div class="form-group">
              <label>NIK Dosen</label>
              <select class="form-control" name="nik" required>
                <option value="">-- Pilih NIK --</option>
                  <?php 
                    $query_dosen = mysqli_query($koneksi, "SELECT * FROM tb_dosen");
                    while($data_dosen = mysqli_fetch_array($query_dosen)): 
                  ?>
                  <option value="<?= $data_dosen['nik'] ?>">
                    <?= $data_dosen['nik'] ?> - <?= $data_dosen['nama'] ?>
                  </option>
                  <?php endwhile; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="nama">Nama Kelas</label>
              <input type="text" class="form-control" name="nama_kelas"required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_edit_kelas" class="btn btn-primary">
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
    var kode_kelas = $(e.relatedTarget).data('kode');
    var kode_akd = $(e.relatedTarget).data('akademik');
    var kode_makul = $(e.relatedTarget).data('makul');
    var kode_jurusan = $(e.relatedTarget).data('jurusan');
    var nik = $(e.relatedTarget).data('nik');
    var nama_kelas = $(e.relatedTarget).data('kelas');

    $(e.currentTarget).find('input[name="kode_kelas"]').val(kode_kelas);
    $(e.currentTarget).find('select[name="kode_akd"]').val(kode_akd);
    $(e.currentTarget).find('select[name="kode_makul"]').val(kode_makul);
    $(e.currentTarget).find('select[name="kode_jurusan"]').val(kode_jurusan);
    $(e.currentTarget).find('select[name="nik"]').val(nik);
    $(e.currentTarget).find('input[name="nama_kelas"]').val(nama_kelas);
  });
</script>
</body>
</html>