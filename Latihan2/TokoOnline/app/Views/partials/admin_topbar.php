<header class="topbar d-flex align-items-center justify-content-between px-4">
    <div class="fw-bold" style="color: #0f766e;"><?= esc($title ?? 'Panel Admin TokoKita') ?></div>
    <div class="d-flex align-items-center gap-3">
        <div class="text-end small">
            <div class="fw-semibold"><?= esc(session()->get('user_nama')) ?></div>
            <span class="badge bg-success text-uppercase"><?= esc(session()->get('user_role')) ?></span>
        </div>
        <form action="<?= site_url('/logout') ?>" method="post" class="m-0">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
        </form>
    </div>
</header>

