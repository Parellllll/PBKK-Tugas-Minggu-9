<?= $this->extend('layouts/sbadmin') ?>
<?= $this->section('content') ?>

<a href="<?= site_url('/admin/master/dosen') ?>" class="btn btn-outline-secondary btn-sm mb-3">&larr; Kembali</a>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold text-primary">Form Tambah Dosen (Otomatis Buat Akun Login)</div>
    <div class="card-body">
        <form action="<?= site_url('/admin/master/dosen/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label fw-semibold">NIDN *</label><input type="text" name="nidn" class="form-control" value="<?= esc(old('nidn')) ?>" required></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Gelar Depan</label><input type="text" name="gelar_depan" class="form-control" value="<?= esc(old('gelar_depan')) ?>" placeholder="Dr."></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Gelar Belakang</label><input type="text" name="gelar_belakang" class="form-control" value="<?= esc(old('gelar_belakang')) ?>" placeholder="S.Kom., M.T."></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Nama Lengkap *</label><input type="text" name="nama" class="form-control" value="<?= esc(old('nama')) ?>" required></div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Program Studi *</label>
                    <select name="prodi_id" class="form-select" required>
                        <?php foreach ($prodi as $p) : ?>
                            <option value="<?= esc($p['id']) ?>"><?= esc($p['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4"><label class="form-label fw-semibold">Username Login *</label><input type="text" name="username" class="form-control" value="<?= esc(old('username')) ?>" required></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Email *</label><input type="email" name="email" class="form-control" value="<?= esc(old('email')) ?>" required></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Password Awal *</label><input type="password" name="password" class="form-control" value="dosen123" required></div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Dosen</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

