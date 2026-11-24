<header class="topbar d-flex align-items-center justify-content-between px-4">
    <div class="d-flex align-items-center gap-2">
        <span class="fw-bold text-primary"><?= esc($title ?? 'SIAKAD') ?></span>
        <?php if (! empty($tahunAktif)) : ?>
            <span class="badge bg-info-subtle text-info border border-info-subtle">
                <i class="fas fa-calendar me-1"></i>TA Aktif: <?= esc($tahunAktif['nama']) ?>
            </span>
        <?php endif; ?>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div class="text-end small">
            <div class="fw-semibold"><?= esc(session()->get('user_nama')) ?></div>
            <span class="badge bg-primary text-uppercase"><?= esc(session()->get('user_role')) ?></span>
        </div>
        <form action="<?= site_url('/logout') ?>" method="post" class="m-0">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-sign-out-alt me-1"></i>Logout
            </button>
        </form>
    </div>
</header>

