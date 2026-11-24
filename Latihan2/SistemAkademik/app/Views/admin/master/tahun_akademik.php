<?= $this->extend('layouts/sbadmin') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold text-primary">Tambah Tahun Akademik</div>
            <div class="card-body">
                <form action="<?= site_url('/admin/master/tahun-akademik/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Kode</label>
                        <input type="text" name="kode" class="form-control" placeholder="Misal: 20252" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Nama Tahun Akademik</label>
                        <input type="text" name="nama" class="form-control" placeholder="Misal: 2025/2026 Genap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Semester</label>
                        <select name="semester" class="form-select">
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold text-primary">Daftar Tahun Akademik</div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Kode</th><th>Nama</th><th>Semester</th><th>Status</th><th class="text-end">Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $ta) : ?>
                            <tr>
                                <td><code><?= esc($ta['kode']) ?></code></td>
                                <td class="fw-semibold"><?= esc($ta['nama']) ?></td>
                                <td><?= esc($ta['semester']) ?></td>
                                <td>
                                    <?php if ((int) $ta['is_aktif'] === 1) : ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <?php if ((int) $ta['is_aktif'] !== 1) : ?>
                                        <form action="<?= site_url('/admin/master/tahun-akademik/aktifkan/' . $ta['id']) ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-success">Aktifkan</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

