<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div>
        <h3 class="fw-bold mb-0">Direktori Biodata Mahasiswa</h3>
        <small class="text-muted">Pencarian, filter prodi, dan pagination menggunakan Query Builder CI4</small>
    </div>
    <?php if (session()->get('user_role') === 'admin') : ?>
        <a href="<?= site_url('/admin/mahasiswa/create') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Mahasiswa
        </a>
    <?php endif; ?>
</div>

<form method="get" action="<?= site_url('/biodata') ?>" class="card border-0 shadow-sm mb-4">
    <div class="card-body row g-2 align-items-end">
        <div class="col-md-5">
            <label class="form-label small fw-semibold">Kata Kunci</label>
            <input type="text" name="q" value="<?= esc($keyword) ?>" class="form-control" placeholder="Cari NRP, nama, email, atau alamat...">
        </div>
        <div class="col-md-4">
            <label class="form-label small fw-semibold">Program Studi</label>
            <select name="prodi" class="form-select">
                <option value="">Semua Program Studi</option>
                <?php foreach ($daftarProdi as $p) : ?>
                    <option value="<?= esc($p) ?>" <?= $prodiAktif === $p ? 'selected' : '' ?>><?= esc($p) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-grow-1"><i class="fas fa-search me-1"></i>Filter</button>
            <a href="<?= site_url('/biodata') ?>" class="btn btn-outline-secondary">Reset</a>
        </div>
    </div>
</form>

<?php if (empty($mahasiswa)) : ?>
    <div class="alert alert-warning">Data mahasiswa tidak ditemukan untuk kriteria pencarian tersebut.</div>
<?php else : ?>
    <div class="row g-3">
        <?php foreach ($mahasiswa as $m) : ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body d-flex gap-3 align-items-center">
                        <?php if (! empty($m['foto']) && is_file(FCPATH . 'uploads/foto/' . $m['foto'])) : ?>
                            <img src="<?= base_url('uploads/foto/' . $m['foto']) ?>" alt="<?= esc($m['nama']) ?>" class="avatar-circle flex-shrink-0" style="width:64px;height:64px;">
                        <?php else : ?>
                            <div class="avatar-circle flex-shrink-0" style="width:64px;height:64px;">
                                <?= esc(strtoupper(substr($m['nama'], 0, 2))) ?>
                            </div>
                        <?php endif; ?>
                        <div class="min-w-0">
                            <h6 class="fw-bold mb-1 text-truncate"><?= esc($m['nama']) ?></h6>
                            <div class="small text-muted"><?= esc($m['nrp']) ?> • Angkatan <?= esc($m['angkatan']) ?></div>
                            <div class="small text-primary mb-2"><?= esc($m['prodi']) ?></div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success-subtle text-success">IPK <?= number_format((float) $m['ipk'], 2) ?></span>
                                <a href="<?= site_url('/biodata/' . $m['nrp']) ?>" class="btn btn-sm btn-outline-primary py-0 px-2">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-4 d-flex justify-content-end">
        <?= $pager->links('default', 'bootstrap') ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

