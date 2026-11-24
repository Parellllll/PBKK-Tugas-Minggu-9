<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Biodata Mahasiswa CI4') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/sb-admin-2.css') ?>" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= site_url('/') ?>">
            <i class="fas fa-id-card me-2"></i>Biodata CI4
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= site_url('/') ?>">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('/hello') ?>">Hello World</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('/biodata') ?>">Biodata Mahasiswa</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('/tentang') ?>">Tentang</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <?php if (session()->get('isLoggedIn')) : ?>
                    <?php if (session()->get('user_role') === 'admin') : ?>
                        <a href="<?= site_url('/admin') ?>" class="btn btn-warning btn-sm fw-semibold">
                            <i class="fas fa-tachometer-alt me-1"></i>Panel SB Admin
                        </a>
                    <?php endif; ?>
                    <a href="<?= site_url('/profil') ?>" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-user me-1"></i><?= esc(session()->get('username')) ?>
                    </a>
                    <form action="<?= site_url('/logout') ?>" method="post" class="d-inline">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                    </form>
                <?php else : ?>
                    <a href="<?= site_url('/login') ?>" class="btn btn-light btn-sm fw-semibold text-primary">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
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
    <div class="container d-flex flex-wrap justify-content-between align-items-center small text-muted">
        <span>Latihan 1 PBKK D — CodeIgniter 4.7.6 (Bootstrap 5 + SB Admin 2)</span>
        <span>Farrel Prastita Ramaddhan (5025241219) — Teknik Informatika ITS</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

