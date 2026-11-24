<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-primary mb-0">Profil Akun Login</h4>
            <span class="badge bg-primary text-uppercase fs-6"><?= esc($user['role'] ?? session()->get('user_role')) ?></span>
        </div>
        <table class="table table-bordered">
            <tr><th style="width:200px;">Username</th><td><?= esc($user['username'] ?? '-') ?></td></tr>
            <tr><th>Nama Lengkap</th><td><?= esc($user['nama_lengkap'] ?? '-') ?></td></tr>
            <tr><th>Email</th><td><?= esc($user['email'] ?? '-') ?></td></tr>
            <tr><th>Hak Akses</th><td><?= ($user['role'] ?? '') === 'admin' ? 'Administrator (Akses Penuh CRUD & Manajemen User)' : 'User Standar (Akses Lihat Biodata & Profil)' ?></td></tr>
        </table>
        <div class="d-flex gap-2">
            <?php if (($user['role'] ?? '') === 'admin') : ?>
                <a href="<?= site_url('/admin') ?>" class="btn btn-primary">Buka Panel SB Admin 2</a>
            <?php endif; ?>
            <a href="<?= site_url('/biodata') ?>" class="btn btn-outline-primary">Lihat Direktori Biodata</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

