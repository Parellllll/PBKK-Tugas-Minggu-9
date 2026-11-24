<?php $uri = service('uri')->getPath(); ?>
<aside class="sidebar">
    <a class="sidebar-brand" href="<?= site_url('/admin') ?>">
        <i class="fas fa-shopping-bag fa-lg"></i>
        <span>Admin TokoKita</span>
    </a>

    <div class="sidebar-heading">Ringkasan</div>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link <?= $uri === 'admin' ? 'active' : '' ?>" href="<?= site_url('/admin') ?>"><i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</a></li>
    </ul>

    <div class="sidebar-heading">Katalog &amp; Penjualan</div>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link <?= str_starts_with($uri, 'admin/kategori') ? 'active' : '' ?>" href="<?= site_url('/admin/kategori') ?>"><i class="fas fa-tags fa-fw"></i> Kategori</a></li>
        <li class="nav-item"><a class="nav-link <?= str_starts_with($uri, 'admin/produk') ? 'active' : '' ?>" href="<?= site_url('/admin/produk') ?>"><i class="fas fa-box-open fa-fw"></i> Produk &amp; Stok</a></li>
        <li class="nav-item"><a class="nav-link <?= str_starts_with($uri, 'admin/pesanan') ? 'active' : '' ?>" href="<?= site_url('/admin/pesanan') ?>"><i class="fas fa-receipt fa-fw"></i> Pesanan</a></li>
    </ul>

    <div class="sidebar-heading">Toko</div>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link" href="<?= site_url('/') ?>"><i class="fas fa-store fa-fw"></i> Lihat Storefront</a></li>
    </ul>
</aside>

