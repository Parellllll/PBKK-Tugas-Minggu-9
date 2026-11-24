<?= $this->extend('layouts/sbadmin') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h4 class="fw-bold mb-0">Master Data Mahasiswa</h4>
    <div class="d-flex gap-2">
        <form method="get" class="d-flex gap-2">
            <input type="text" name="q" value="<?= esc($keyword) ?>" class="form-control form-control-sm" placeholder="Cari NRP / nama...">
            <button type="submit" class="btn btn-sm btn-outline-primary">Cari</button>
        </form>
        <a href="<?= site_url('/admin/master/mahasiswa/create') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Tambah Mahasiswa</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>NRP</th><th>Nama</th><th>Prodi</th><th>Angkatan</th><th>Username</th><th>Status</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($mahasiswa as $m) : ?>
                    <tr>
                        <td><code><?= esc($m['nrp']) ?></code></td>
                        <td class="fw-semibold"><?= esc($m['nama']) ?></td>
                        <td class="small"><?= esc($m['nama_prodi']) ?></td>
                        <td><?= esc($m['angkatan']) ?></td>
                        <td><code><?= esc($m['username']) ?></code></td>
                        <td><span class="badge bg-success text-uppercase"><?= esc($m['status']) ?></span></td>
                        <td class="text-end">
                            <form action="<?= site_url('/admin/master/mahasiswa/delete/' . $m['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus mahasiswa dan seluruh KRS-nya?');">
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

