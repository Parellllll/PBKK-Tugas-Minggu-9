<?= $this->extend('layouts/sbadmin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Master Data Dosen</h4>
    <a href="<?= site_url('/admin/master/dosen/create') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Tambah Dosen</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>NIDN</th><th>Nama Lengkap</th><th>Prodi</th><th>Username</th><th>Email</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($dosen as $d) : ?>
                    <tr>
                        <td><code><?= esc($d['nidn']) ?></code></td>
                        <td class="fw-semibold"><?= esc(nama_dosen_lengkap($d)) ?></td>
                        <td class="small"><?= esc($d['nama_prodi']) ?></td>
                        <td><code><?= esc($d['username']) ?></code></td>
                        <td class="small"><?= esc($d['email']) ?></td>
                        <td class="text-end">
                            <form action="<?= site_url('/admin/master/dosen/delete/' . $d['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus dosen ini?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

