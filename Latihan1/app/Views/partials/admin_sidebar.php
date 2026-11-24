<?php $uri = service('uri')->getPath(); ?>
<aside class="sidebar">
    <a class="sidebar-brand" href="<?= site_url('/admin') ?>">
        <i class="fas fa-graduation-cap fa-lg"></i>
        <span>SB Admin CI4</span>
    </a>

    <div class="sidebar-heading">Utama</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?= $uri === 'admin' || $uri === 'admin/' ? 'active' : '' ?>" href="<?= site_url('/admin') ?>">
                <i class="fas fa-tachometer-alt fa-fw"></i> Dashboard
            </a>
        </li>
    </ul>

    <div class="sidebar-heading">Manajemen Data</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?= str_starts_with($uri, 'admin/mahasiswa') ? 'active' : '' ?>" href="<?= site_url('/admin/mahasiswa') ?>">
                <i class="fas fa-users fa-fw"></i> Biodata Mahasiswa
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= str_starts_with($uri, 'admin/users') ? 'active' : '' ?>" href="<?= site_url('/admin/users') ?>">
                <i class="fas fa-user-shield fa-fw"></i> Akses User
            </a>
        </li>
    </ul>

    <div class="sidebar-heading">Publik</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url('/biodata') ?>">
                <i class="fas fa-globe fa-fw"></i> Lihat Halaman Publik
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url('/hello/Farrel') ?>">
                <i class="fas fa-code fa-fw"></i> Demo Hello World
            </a>
        </li>
    </ul>
</aside>

