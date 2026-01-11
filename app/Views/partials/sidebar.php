<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url() ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url() ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Addons</div>

    <?php if (App\Libraries\AuthService::can('manage_users')) : ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser">
            <i class="fas fa-fw fa-users"></i>
            <span>Manajemen User</span>
        </a>
        <div id="collapseUser" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= base_url('user') ?>">List User</a>
                <a class="collapse-item" href="<?= base_url('user/add') ?>">Tambah User</a>
            </div>
        </div>
    </li>
    <?php endif; ?>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Barang</span>
        </a>
        <div id="collapsePages" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= base_url('barang') ?>">List Barang</a>
                <a class="collapse-item" href="<?= base_url('barang/addItem') ?>">Tambah Barang</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('barang') ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
