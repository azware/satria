<nav id="sidebar">
    <div class="sidebar-header">
        <h3><i class="fas fa-users-cog"></i> <span class="sidebar-text">SATRIA</span></h3>
    </div>
    <ul class="list-unstyled components">
        <li class="active">
            <a href="#" class="nav-link" data-url="<?= site_url('dashboard') ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link" data-url="<?= site_url('pegawai') ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Data Pegawai">
                <i class="fas fa-users"></i>
                <span class="sidebar-text">Data Pegawai</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link" data-url="<?= site_url('departemen') ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Departemen">
                <i class="fas fa-building"></i>
                <span class="sidebar-text">Departemen</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link" data-url="<?= site_url('jabatan') ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Jabatan">
                <i class="fas fa-user-tie"></i>
                <span class="sidebar-text">Jabatan</span>
            </a>
        </li>
    </ul>
</nav>

<!-- [BARU] Overlay untuk mode mobile -->
<div class="sidebar-overlay"></div>