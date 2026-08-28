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
  $hal = 'admin_data_makul';
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
                <h3 class="card-title">Data Mata Kuliah</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah-user">
                  <i class="fas fa-plus"></i> 
                  Tambah Data
                </button>
                <a href="tambah.php" type="button" class="btn btn-warning mb-2"> Tambah Data 2</a>
                <a href="reset.php" type="button" class="btn btn-danger mb-2" onclick="return confirm('Anda yakin ingin mereset seluruh data makul? Tindakan ini tidak dapat dikembalikan')">
                  <i class="fas fa-exclamation-triangle"></i> Reset Data
                </a>
                <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-impor">
                  <i class="fas fa-file-excel"></i> 
                  Impor Data
                </button>
                <a href="pdf.php" type="button" class="btn btn-danger mb-2" target="_blank">
                  <i class="fas fa-file-pdf"></i> 
                  Ekspor Data
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
                    <th>Kode Mata Kuliah</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Jumlah SKS</th>
                    <th>Jumlah CPMK</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $panggil_data_user = mysqli_query($koneksi, "SELECT * FROM tb_makul")or die(mysqli_error($koneksi));
                    $no = 1;
                    $rv = mysqli_num_rows($panggil_data_user);
                    if ($rv > 0){
                      while ($data = mysqli_fetch_array($panggil_data_user)){
                        $kode_makul = $data['kode_makul'];
                        $nama_makul = $data['nama_makul'];
                        $jml_sks = $data['jml_sks'];
                        $jml_cpmk = $data['jml_cpmk'];
                  ?>
                        <tr class="text-center">
                            <td><?= $no++ ?></td>
                            <td><?= $kode_makul; ?></td>
                            <td><?= $nama_makul; ?></td>
                            <td><?= $jml_sks; ?></td>
                            <td><?= $jml_cpmk; ?></td>
                            <td>
                              <a href="edit.php?kode=<?= $data['kode_makul']; ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-pen"></i>
                                <!-- Edit -->
                                </a>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-edit" 
                                  data-kode="<?= $data['kode_makul']; ?>" 
                                  data-nama="<?= $data['nama_makul'] ?>"
                                  data-sks="<?= $data['jml_sks']; ?>"
                                  data-cpmk="<?= $data['jml_cpmk']; ?>"
                                >
                                  <i class="fas fa-pen"></i>
                                  <!-- Edit 2 -->
                                </button>
                              <a href="hapus.php?kode=<?= $data['kode_makul']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ga bang?')">
                                <i class="fas fa-trash"></i>
                                <!-- Hapus -->
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

  <!-- MODAL TAMBAH -->
  <div class="modal fade" id="modal-tambah-user">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Mata Kuliah</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="tambah.php" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label for="username">Kode Mata Kuliah</label>
              <input type="text" class="form-control" name="kode_makul" id="kode_makul" placeholder="Masukkan kode makul" required>
            </div>

            <div class="form-group">
              <label for="nama">Nama Mata Kuliah</label>
              <input type="text" class="form-control" name="nama_makul" id="nama_makul" placeholder="Masukkan nama makul" required>
            </div>

            <div class="form-group">
              <label for="nama">Jumlah SKS</label>
              <input type="number" class="form-control" name="jml_sks" id="jml_sks" placeholder="Masukkan jumlah SKS" required>
            </div>

            <div class="form-group">
              <label for="nama">Jumlah CPMK</label>
              <input type="number" class="form-control" name="jml_cpmk" id="jml_cpmk" placeholder="Masukkan jumlah CPMK" required>
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
  <!-- MODAL EDIT -->
  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data Mata Kuliah</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="ubah.php" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label for="username">Kode Mata Kuliah</label>
              <input type="text" class="form-control" name="kode_makul" id="kode_makul" required readonly>
            </div>

            <div class="form-group">
              <label for="nama">Nama Mata Kuliah</label>
              <input type="text" class="form-control" name="nama_makul" id="nama_makul" required>
            </div>

            <div class="form-group">
              <label for="nama">Jumlah SKS</label>
              <input type="number" class="form-control" name="jml_sks" id="jml_sks" required>
            </div>

            <div class="form-group">
              <label for="nama">Jumlah CPMK</label>
              <input type="number" class="form-control" name="jml_cpmk" id="jml_cpmk" required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_edit" class="btn btn-warning">
              <i class="fas fa-pen"></i>
              Edit
            </button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- MODAL IMPOR -->
  <div class="modal fade" id="modal-impor">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Impor Data Mata Kuliah</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="impor.php" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label for="file">Upload File</label>
              <input type="file" class="form-control" name="file_excel" required>
            </div>
            <div class="form-group">
              <label for="template">Download Template Excel</label><br>
              <a href="template/template_data_makul_kosongan.xls" class="btn btn-success" download><i class="fas fa-download"></i> Download</a>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_impor" class="btn btn-success">
              <!-- <i class="fas fa-plus"></i> -->
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
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php
include '../script.php';
?>
<script>
  $('#modal-edit').on('show.bs.modal', function(e){
    var kode = $(e.relatedTarget).data('kode');
    var nama = $(e.relatedTarget).data('nama');
    var sks = $(e.relatedTarget).data('sks');
    var cpmk = $(e.relatedTarget).data('cpmk');

    $(e.currentTarget).find('input[name="kode_makul"]').val(kode);
    $(e.currentTarget).find('input[name="nama_makul"]').val(nama);
    $(e.currentTarget).find('input[name="jml_sks"]').val(sks);
    $(e.currentTarget).find('input[name="jml_cpmk"]').val(cpmk);
  });
</script>
</body>
</html>