<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<a href="<?= site_url('/biodata') ?>" class="btn btn-outline-secondary btn-sm mb-3">
    <i class="fas fa-arrow-left me-1"></i>Kembali ke Direktori
</a>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="bg-primary text-white p-4 d-flex flex-wrap align-items-center gap-4">
        <?php if (! empty($mhs['foto']) && is_file(FCPATH . 'uploads/foto/' . $mhs['foto'])) : ?>
            <img src="<?= base_url('uploads/foto/' . $mhs['foto']) ?>" alt="<?= esc($mhs['nama']) ?>" class="avatar-circle avatar-lg border border-3 border-white">
        <?php else : ?>
            <div class="avatar-circle avatar-lg border border-3 border-white">
                <?= esc(strtoupper(substr($mhs['nama'], 0, 2))) ?>
            </div>
        <?php endif; ?>
        <div>
            <span class="badge bg-warning text-dark mb-1"><?= esc($mhs['prodi']) ?></span>
            <h3 class="fw-bold mb-1"><?= esc($mhs['nama']) ?></h3>
            <div class="opacity-75">NRP: <?= esc($mhs['nrp']) ?> • Angkatan <?= esc($mhs['angkatan']) ?></div>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="small text-muted">Email</div>
                <div class="fw-semibold"><?= esc($mhs['email']) ?></div>
            </div>
            <div class="col-md-6">
                <div class="small text-muted">Jenis Kelamin</div>
                <div class="fw-semibold"><?= $mhs['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></div>
            </div>
            <div class="col-md-6">
                <div class="small text-muted">Nomor HP</div>
                <div class="fw-semibold"><?= esc($mhs['no_hp'] ?: '-') ?></div>
            </div>
            <div class="col-md-6">
                <div class="small text-muted">Indeks Prestasi Kumulatif (IPK)</div>
                <div class="fw-bold text-success fs-5"><?= number_format((float) $mhs['ipk'], 2) ?></div>
            </div>
            <div class="col-12">
                <div class="small text-muted">Alamat</div>
                <div class="fw-semibold"><?= esc($mhs['alamat'] ?: '-') ?></div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

