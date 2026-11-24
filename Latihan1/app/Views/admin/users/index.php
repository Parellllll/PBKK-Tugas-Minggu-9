<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h4 class="fw-bold mb-3">Manajemen Akses Pengguna</h4>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u) : ?>
                    <tr>
                        <td><?= esc($u['id']) ?></td>
                        <td><code><?= esc($u['username']) ?></code></td>
                        <td><?= esc($u['nama_lengkap']) ?></td>
                        <td><?= esc($u['email']) ?></td>
                        <td>
                            <span class="badge <?= $u['role'] === 'admin' ? 'bg-danger' : 'bg-secondary' ?> text-uppercase">
                                <?= esc($u['role']) ?>
                            </span>
                        </td>
                        <td class="text-end">
                            <?php if ((int) $u['id'] === (int) session()->get('user_id')) : ?>
                                <span class="small text-muted">Akun aktif</span>
                            <?php else : ?>
                                <form action="<?= site_url('/admin/users/toggle-role/' . $u['id']) ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                        Jadikan <?= $u['role'] === 'admin' ? 'User' : 'Admin' ?>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

