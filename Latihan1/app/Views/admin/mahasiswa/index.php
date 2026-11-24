<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h4 class="fw-bold mb-0">Data Biodata Mahasiswa</h4>
    <a href="<?= site_url('/admin/mahasiswa/create') ?>" class="btn btn-primary btn-sm">
        <i class="fas fa-plus me-1"></i>Tambah Mahasiswa
    </a>
</div>

<form method="get" action="<?= site_url('/admin/mahasiswa') ?>" class="card border-0 shadow-sm mb-3">
    <div class="card-body row g-2">
        <div class="col-md-5">
            <input type="text" name="q" value="<?= esc($keyword) ?>" class="form-control form-control-sm" placeholder="Cari NRP / nama / email...">
        </div>
        <div class="col-md-4">
            <select name="prodi" class="form-select form-select-sm">
                <option value="">Semua Prodi</option>
                <?php foreach ($daftarProdi as $p) : ?>
                    <option value="<?= esc($p) ?>" <?= $prodiAktif === $p ? 'selected' : '' ?>><?= esc($p) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm flex-grow-1">Cari</button>
            <a href="<?= site_url('/admin/mahasiswa') ?>" class="btn btn-outline-secondary btn-sm">Reset</a>
        </div>
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Foto</th>
                    <th>NRP</th>
                    <th>Nama &amp; Email</th>
                    <th>Prodi</th>
                    <th>Angkatan</th>
                    <th>IPK</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($mahasiswa)) : ?>
                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data mahasiswa.</td></tr>
                <?php else : ?>
                    <?php foreach ($mahasiswa as $m) : ?>
                        <tr>
                            <td>
                                <?php if (! empty($m['foto']) && is_file(FCPATH . 'uploads/foto/' . $m['foto'])) : ?>
                                    <img src="<?= base_url('uploads/foto/' . $m['foto']) ?>" alt="<?= esc($m['nama']) ?>" class="avatar-circle" style="width:40px;height:40px;">
                                <?php else : ?>
                                    <div class="avatar-circle" style="width:40px;height:40px;font-size:.8rem;">
                                        <?= esc(strtoupper(substr($m['nama'], 0, 2))) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><code><?= esc($m['nrp']) ?></code></td>
                            <td>
                                <div class="fw-semibold"><?= esc($m['nama']) ?></div>
                                <div class="small text-muted"><?= esc($m['email']) ?></div>
                            </td>
                            <td class="small"><?= esc($m['prodi']) ?></td>
                            <td><?= esc($m['angkatan']) ?></td>
                            <td><span class="badge bg-success-subtle text-success"><?= number_format((float) $m['ipk'], 2) ?></span></td>
                            <td class="text-end text-nowrap">
                                <a href="<?= site_url('/biodata/' . $m['nrp']) ?>" class="btn btn-sm btn-outline-info" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= site_url('/admin/mahasiswa/edit/' . $m['id']) ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?= site_url('/admin/mahasiswa/delete/' . $m['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus biodata <?= esc($m['nama'], 'js') ?>?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white d-flex justify-content-end">
        <?= $pager->links('default', 'bootstrap') ?>
    </div>
</div>

<?= $this->endSection() ?>

