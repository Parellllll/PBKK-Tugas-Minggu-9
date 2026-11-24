<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<a href="<?= site_url('/admin/mahasiswa') ?>" class="btn btn-outline-secondary btn-sm mb-3">
    <i class="fas fa-arrow-left me-1"></i>Kembali
</a>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold text-primary">
        <?= $mode === 'edit' ? 'Edit Biodata Mahasiswa' : 'Tambah Biodata Mahasiswa Baru' ?>
    </div>
    <div class="card-body">
        <form action="<?= $mode === 'edit' ? site_url('/admin/mahasiswa/update/' . $mhs['id']) : site_url('/admin/mahasiswa/store') ?>"
              method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">NRP *</label>
                    <input type="text" name="nrp" class="form-control" value="<?= esc(old('nrp', $mhs['nrp'] ?? '')) ?>" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Nama Lengkap *</label>
                    <input type="text" name="nama" class="form-control" value="<?= esc(old('nama', $mhs['nama'] ?? '')) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email *</label>
                    <input type="email" name="email" class="form-control" value="<?= esc(old('email', $mhs['email'] ?? '')) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Program Studi *</label>
                    <select name="prodi" class="form-select" required>
                        <?php $selectedProdi = old('prodi', $mhs['prodi'] ?? 'Teknik Informatika'); ?>
                        <?php foreach ($daftarProdi as $p) : ?>
                            <option value="<?= esc($p) ?>" <?= $selectedProdi === $p ? 'selected' : '' ?>><?= esc($p) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Angkatan *</label>
                    <input type="number" name="angkatan" min="2015" max="2030" class="form-control" value="<?= esc(old('angkatan', $mhs['angkatan'] ?? 2024)) ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Jenis Kelamin *</label>
                    <?php $jk = old('jenis_kelamin', $mhs['jenis_kelamin'] ?? 'L'); ?>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="L" <?= $jk === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="P" <?= $jk === 'P' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">IPK (0.00 - 4.00) *</label>
                    <input type="number" step="0.01" min="0" max="4" name="ipk" class="form-control" value="<?= esc(old('ipk', $mhs['ipk'] ?? '3.50')) ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Nomor HP</label>
                    <input type="text" name="no_hp" class="form-control" value="<?= esc(old('no_hp', $mhs['no_hp'] ?? '')) ?>">
                </div>
                <div class="col-md-7">
                    <label class="form-label fw-semibold">Alamat</label>
                    <textarea name="alamat" rows="3" class="form-control"><?= esc(old('alamat', $mhs['alamat'] ?? '')) ?></textarea>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Foto Profil (JPG/PNG/WEBP, maks 2MB)</label>
                    <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/webp">
                    <?php if (! empty($mhs['foto']) && is_file(FCPATH . 'uploads/foto/' . $mhs['foto'])) : ?>
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <img src="<?= base_url('uploads/foto/' . $mhs['foto']) ?>" alt="Foto saat ini" class="avatar-circle" style="width:48px;height:48px;">
                            <span class="small text-muted">Foto saat ini tersimpan</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i><?= $mode === 'edit' ? 'Simpan Perubahan' : 'Simpan Data' ?>
                </button>
                <a href="<?= site_url('/admin/mahasiswa') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

