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
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Mahasiswa</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah-user">
                  <i class="fas fa-plus"></i> 
                  Tambah Data
                </button>
                <a href="reset.php" type="button" class="btn btn-danger mb-2" onclick="return confirm('Anda yakin mereset seluruh data mahasiswa? Tindakan ini tidak dapat dikembalikan')">
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

                <?php
                  $pengguna = $_SESSION['username'];
                ?>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr class="text-center">
                    <th width="5%">No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Email</th>
                    <th>Jenis Kelamin</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $panggil_data_user = mysqli_query($koneksi, "SELECT * FROM tb_mahasiswa")or die(mysqli_error($koneksi));

                    $no = 1;
                    $rv = mysqli_num_rows($panggil_data_user);
                    if ($rv > 0){
                        while ($data = mysqli_fetch_array($panggil_data_user)){
                            $nim = $data['nim'];
                            $nama = $data['nama'];
                            $kontak = $data['kontak'];
                            $email = $data['email'];
                            $kelamin = $data['kelamin'];
                            $img = $data['img'];
                            ?>
                            <tr class="text-center">
                                <td><?= $no++ ?></td>
                                <td><?= $nim; ?></td>
                                <td><?= $nama; ?></td>
                                <td><?= $kontak; ?></td>
                                <td><?= $email; ?></td>
                                <td>
                                  <?php
                                  if ($kelamin == 'P'){
                                    echo 'Perempuan';
                                  } else {
                                    echo 'Laki-laki';
                                  }
                                  ?>
                                </td>
                                <td>
                                  <!-- Cara 1:-->
                                  <!-- <?php
                                    if ($kelamin == 'P') {
                                      echo '<button type="button" class="btn" data-toggle="modal" data-target="#modal-ubah-foto" data-nim="<?= $nim; ?>">
                                        <img src="../asset_web/img/mhs-woman.jpg" width="60" alt="Perempuan">
                                      </button>';
                                    } else {
                                      echo '<button type="button" class="btn" data-toggle="modal" data-target="#modal-ubah-foto" data-nim="<?= $nim; ?>">
                                        <img src="../asset_web/img/mhs-man.jpg" width="60" alt="Laki-laki">
                                      </button>';
                                    }
                                  ?> -->

                                  <!-- Cara 2:  -->
                                  <!-- <button type="button" class="btn" data-toggle="modal" data-target="#modal-ubah-foto" data-nim="<?= $nim; ?>">
                                    <?= ($kelamin == 'P') ? '<img src="../asset_web/img/mhs-woman.jpg" width="60">' :
                                    '<img src="../asset_web/img/mhs-man.jpg" width="60">' ?>
                                  </button> -->

                                  <!-- Cara 3:-->
                                  <button type="button" class="btn" data-toggle="modal" data-target="#modal-ubah-foto" data-nim="<?= $nim; ?>">
                                    <?php
                                      if ($kelamin == 'P') {
                                    ?>
                                      <img src="<?= (!empty($img))?$img : '../asset_web/img/mhs-woman.jpg'?>" style="width: 60px; height: 60px; object-fit: cover;">
                                    <?php
                                      } else {
                                    ?>
                                      <img src="<?= (!empty($img))?$img : '../asset_web/img/mhs-man.jpg'?>" style="width: 60px; height: 60px; object-fit: cover;">
                                    <?php
                                      }
                                    ?>
                                  </button>
                                </td>
                                <td>
                                  <a href="profil.php?user=<?= $data['nim']; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                  </a>
                                  <a href="edit.php?user=<?= $data['nim']; ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-pen"></i>
                                  </a>
                                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-edit" 
                                    data-nim="<?= $data['nim']; ?>" 
                                    data-nama="<?= $data['nama'] ?>"
                                    data-kontak="<?= $data['kontak']; ?>"
                                    data-email="<?= $data['email']; ?>"
                                    data-kelamin="<?= $data['kelamin']; ?>"
                                  >
                                    <i class="fas fa-pen"></i>
                                  </button>
                                  <a href="hapus.php?user=<?= $data['nim']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ga bang?')">
                                    <i class="fas fa-trash"></i>
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
        <form action="tambah.php" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label for="username">NIM</label>
              <input type="number" class="form-control" name="nim" id="nim" placeholder="Masukkan NIM" required>
            </div>

            <div class="form-group">
              <label for="nama">Nama Mahasiswa</label>
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

            <div class="form-group">
              <label for="img">Foto</label>
              <input type="file" class="form-control" name="file_foto">
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
          <h4 class="modal-title">Edit Data Mahasiswa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="ubah.php" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label for="nim">NIM</label>
              <input type="number" class="form-control" name="nim" id="nim" required readonly>
            </div>

            <div class="form-group">
              <label for="nama">Nama Mahasiswa</label>
              <input type="text" class="form-control" name="nama" id="nama" required>
            </div>

            <div class="form-group">
              <label for="kontak">Kontak</label>
              <input type="number" class="form-control" name="kontak" id="kontak" required>
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="email" id="email" required>
            </div>
            
            <div class="form-group">
              <label>Jenis Kelamin</label>
              <select class="form-control" name="kelamin" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="P">Perempuan</option>
                <option value="L">Laki-laki</option>
              </select>
            </div>

            <div class="form-group">
              <label for="img">Foto</label>
              <input type="file" class="form-control" name="img" id="img">
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
          <h4 class="modal-title">Impor Data Mahasiswa</h4>
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
              <a href="template/template_data_mhs_kosongan.xls" class="btn btn-success" download><i class="fas fa-download"></i> Download</a>
            </div>
          </div>
          <!-- btn -->
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
              NIM : 
              <input type="text" name="nim" >
            </div>
            <div class="form-group">
              <label for="file">Upload File</label>
              <input type="file" class="form-control" name="file_foto" required>
            </div>
          </div>
          <!-- btn -->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_ubah_foto" class="btn btn-success">
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
  $('#modal-edit').on('show.bs.modal', function(e){
    var nim = $(e.relatedTarget).data('nim');
    var nama = $(e.relatedTarget).data('nama');
    var kontak = $(e.relatedTarget).data('kontak');
    var email = $(e.relatedTarget).data('email');
    var kelamin = $(e.relatedTarget).data('kelamin');

    $(e.currentTarget).find('input[name="nim"]').val(nim);
    $(e.currentTarget).find('input[name="nama"]').val(nama);
    $(e.currentTarget).find('input[name="kontak"]').val(kontak);
    $(e.currentTarget).find('input[name="email"]').val(email);
    $(e.currentTarget).find('select[name="kelamin"]').val(kelamin);
  });

  $('#modal-ubah-foto').on('show.bs.modal', function(e){
    var nim = $(e.relatedTarget).data('nim');

    $(e.currentTarget).find('input[name="nim"]').val(nim);
  });
</script>
</body>
</html>