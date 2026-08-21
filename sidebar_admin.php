    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <li class="nav-item">
            <a href="../home_admin/" class="nav-link 
                <?php 
                    if($hal == 'beranda_admin'){
                        echo 'active';
                    } 
                ?>
            ">
            <i class="nav-icon fas fa-tachometer-alt "></i>
            <p>Beranda</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="../admin_data_administrator/" class="nav-link
                <?= $aktif = ($hal == 'admin_admin') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>Data Pengguna</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="../admin_data_dosen/" class="nav-link
                <?= $aktif = ($hal == 'admin_dosen') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Data Dosen</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="../admin_data_mhs/" class="nav-link
                <?= $aktif = ($hal == 'admin_mhs') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>Data Mahasiswa</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="../admin_data_makul/" class="nav-link
                <?= $aktif = ($hal == 'admin_data_makul') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-book-open"></i>
            <p>Mata Kuliah</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="../admin_data_kelas_makul/" class="nav-link
                <?= $aktif = ($hal == 'admin_data_kelas_makul') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-book"></i>
            <p>Kelas Mata Kuliah</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="../admin_data_akademik/" class="nav-link
                <?= $aktif = ($hal == 'admin_data_akademik') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-calendar"></i>
            <p>Periode Akademik</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="../admin_password/" class="nav-link
                <?= $aktif = ($hal == 'admin_pass') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-lock"></i>
            <p>Ganti Password</p>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="../logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt "></i>
            <p>Keluar</p>
            </a>
        </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->