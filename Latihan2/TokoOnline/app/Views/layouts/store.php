<?php $cartCount = \Config\Services::cart()->totalQty(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'TokoKita — CodeIgniter 4') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/toko.css') ?>" rel="stylesheet">
</head>
<body class="store-body d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #0f766e;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= site_url('/') ?>">
            <i class="fas fa-store me-2"></i>TokoKita
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#storeNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="storeNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= site_url('/') ?>">Katalog</a></li>
                <?php if (session()->get('isLoggedIn')) : ?>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('/pesanan') ?>">Pesanan Saya</a></li>
                <?php endif; ?>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <a href="<?= site_url('/keranjang') ?>" class="btn btn-outline-light btn-sm position-relative">
                    <i class="fas fa-shopping-cart me-1"></i>Keranjang
                    <?php if ($cartCount > 0) : ?>
                        <span class="badge bg-warning text-dark ms-1"><?= esc($cartCount) ?></span>
                    <?php endif; ?>
                </a>

                <?php if (session()->get('isLoggedIn')) : ?>
                    <?php if (session()->get('user_role') === 'admin') : ?>
                        <a href="<?= site_url('/admin') ?>" class="btn btn-warning btn-sm fw-semibold">
                            <i class="fas fa-tools me-1"></i>Panel Admin
                        </a>
                    <?php endif; ?>
                    <span class="text-white small d-none d-md-inline">Halo, <strong><?= esc(session()->get('username')) ?></strong></span>
                    <form action="<?= site_url('/logout') ?>" method="post" class="d-inline m-0">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                    </form>
                <?php else : ?>
                    <a href="<?= site_url('/login') ?>" class="btn btn-light btn-sm fw-semibold text-success">Login</a>
                    <a href="<?= site_url('/register') ?>" class="btn btn-outline-light btn-sm">Daftar</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<main class="container py-4 flex-grow-1">
    <?= $this->include('partials/flash') ?>
    <?= $this->renderSection('content') ?>
</main>

<footer class="bg-white border-top py-3 mt-auto">
    <div class="container d-flex flex-wrap justify-content-between small text-muted">
        <span>Latihan 2b PBKK D — Toko Online TokoKita (CodeIgniter 4.7.6)</span>
        <span>Farrel Prastita Ramaddhan (5025241219) — Teknik Informatika ITS</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

