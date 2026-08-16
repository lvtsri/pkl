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
            <i class="nav-icon fas fa-user"></i>
            <p>Data Pengguna</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="../admin_data_dosen/" class="nav-link
                <?= $aktif = ($hal == 'admin_dosen') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user"></i>
            <p>Data Dosen</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="../admin_data_mhs/" class="nav-link
                <?= $aktif = ($hal == 'admin_mhs') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user"></i>
            <p>Data Mahasiswa</p>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt "></i>
            <p>Keluar</p>
            </a>
        </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->