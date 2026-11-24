<?= $this->extend('layouts/sbadmin') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold text-primary">Tambah Mata Kuliah</div>
            <div class="card-body">
                <form action="<?= site_url('/admin/master/matakuliah/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Program Studi</label>
                        <select name="prodi_id" class="form-select" required>
                            <?php foreach ($prodi as $p) : ?>
                                <option value="<?= esc($p['id']) ?>"><?= esc($p['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label small fw-semibold">Kode MK</label><input type="text" name="kode" class="form-control" placeholder="EF234301" required></div>
                    <div class="mb-2"><label class="form-label small fw-semibold">Nama Mata Kuliah</label><input type="text" name="nama" class="form-control" required></div>
                    <div class="row g-2 mb-3">
                        <div class="col-6"><label class="form-label small fw-semibold">SKS</label><input type="number" name="sks" min="1" max="6" value="3" class="form-control" required></div>
                        <div class="col-6"><label class="form-label small fw-semibold">Semester</label><input type="number" name="semester_paket" min="1" max="8" value="3" class="form-control" required></div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Mata Kuliah</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold text-primary">Daftar Mata Kuliah</div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Kode</th><th>Nama Mata Kuliah</th><th>Prodi</th><th>SKS</th><th>Smt</th><th class="text-end">Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($matakuliah as $mk) : ?>
                            <tr>
                                <td><code><?= esc($mk['kode']) ?></code></td>
                                <td class="fw-semibold"><?= esc($mk['nama']) ?></td>
                                <td class="small"><?= esc($mk['kode_prodi']) ?></td>
                                <td><span class="badge bg-primary"><?= esc($mk['sks']) ?></span></td>
                                <td><?= esc($mk['semester_paket']) ?></td>
                                <td class="text-end">
                                    <form action="<?= site_url('/admin/master/matakuliah/delete/' . $mk['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus mata kuliah ini?');">
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

