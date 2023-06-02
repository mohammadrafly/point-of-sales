<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Penjualan App</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Work
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard/transaction') ?>">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Transaksi Penjualan</span></a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Data Transaksi
            </div>
            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard/transaksi/type/tunai') ?>">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Data Transaksi Tunai</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard/transaksi/type/hutang') ?>">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Data Transaksi Piutang</span></a>
            </li>

            <?php if(session()->get('role') === 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard/hutang/supplier') ?>">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Data Transaksi Hutang</span></a>
            </li>
            <?php endif ?>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Master
            </div>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard/items') ?>">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Barang</span></a>
            </li>
            
            <?php if(session()->get('role') === 'admin'): ?>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Data Pengguna
            </div>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard/kasir') ?>">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Kasir</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard/admin') ?>">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Admin</span></a>
            </li>
            <?php endif ?>

            <?php if(session()->get('role') === 'admin'): ?>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Pengaturan
            </div>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard/profile-toko') ?>">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Profil Toko</span></a>
            </li>
            <?php endif ?>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->