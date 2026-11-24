<?= $this->extend('layouts/sbadmin') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold text-primary">Tambah Program Studi</div>
            <div class="card-body">
                <form action="<?= site_url('/admin/master/prodi/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Kode Prodi</label>
                        <input type="text" name="kode" class="form-control" placeholder="Misal: SI" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Nama Program Studi</label>
                        <input type="text" name="nama" class="form-control" placeholder="Misal: Sistem Informasi" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Fakultas</label>
                        <input type="text" name="fakultas" class="form-control" value="FTEIC — ITS" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Jenjang</label>
                        <select name="jenjang" class="form-select">
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="D4">D4</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Prodi</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold text-primary">Daftar Program Studi</div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Kode</th><th>Nama Prodi</th><th>Fakultas</th><th>Jenjang</th><th class="text-end">Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($prodi as $p) : ?>
                            <tr>
                                <td><code><?= esc($p['kode']) ?></code></td>
                                <td class="fw-semibold"><?= esc($p['nama']) ?></td>
                                <td class="small"><?= esc($p['fakultas']) ?></td>
                                <td><span class="badge bg-secondary"><?= esc($p['jenjang']) ?></span></td>
                                <td class="text-end">
                                    <form action="<?= site_url('/admin/master/prodi/delete/' . $p['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus prodi ini?');">
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
    </div>
</div>

<?= $this->endSection() ?>

