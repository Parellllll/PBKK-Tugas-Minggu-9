<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div class="p-5 mb-4 bg-primary text-white rounded-4 shadow-sm">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <span class="badge bg-warning text-dark mb-2">PBKK D • Tugas Minggu 9 • Latihan 1</span>
            <h1 class="display-6 fw-bold">Aplikasi Biodata Mahasiswa</h1>
            <p class="lead mb-4">
                Implementasi lengkap pengenalan framework <strong>CodeIgniter 4.7.6</strong>:
                Hello World, Routing &amp; Placeholder, Bootstrap 5, Template SB Admin 2, Model &amp; CRUD,
                Upload Foto, serta Manajemen Akses User berbasis Filter &amp; Role.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a href="<?= site_url('/biodata') ?>" class="btn btn-light text-primary fw-semibold">
                    <i class="fas fa-address-book me-1"></i>Lihat Biodata Mahasiswa
                </a>
                <a href="<?= site_url('/hello/Farrel') ?>" class="btn btn-outline-light">
                    <i class="fas fa-terminal me-1"></i>Demo Hello World
                </a>
                <a href="<?= site_url('/admin') ?>" class="btn btn-warning fw-semibold">
                    <i class="fas fa-lock me-1"></i>Panel SB Admin 2
                </a>
            </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card text-dark border-0 shadow">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small fw-bold mb-3">Ringkasan Data</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Mahasiswa</span>
                        <strong class="text-primary"><?= esc($ringkasan['total']) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Rata-rata IPK</span>
                        <strong class="text-success"><?= number_format($ringkasan['rata_ipk'], 2) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>IPK Tertinggi</span>
                        <strong class="text-info"><?= number_format($ringkasan['max_ipk'], 2) ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Mahasiswa Terbaru</h4>
    <a href="<?= site_url('/biodata') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua &rarr;</a>
</div>

<div class="row g-3">
    <?php foreach ($terbaru as $m) : ?>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <?php if (! empty($m['foto']) && is_file(FCPATH . 'uploads/foto/' . $m['foto'])) : ?>
                        <img src="<?= base_url('uploads/foto/' . $m['foto']) ?>" alt="<?= esc($m['nama']) ?>" class="avatar-circle mb-2" style="width:68px;height:68px;">
                    <?php else : ?>
                        <div class="avatar-circle mb-2" style="width:68px;height:68px;font-size:1.3rem;">
                            <?= esc(strtoupper(substr($m['nama'], 0, 2))) ?>
                        </div>
                    <?php endif; ?>
                    <h6 class="fw-bold mb-1"><?= esc($m['nama']) ?></h6>
                    <div class="small text-muted mb-2"><?= esc($m['nrp']) ?> • <?= esc($m['angkatan']) ?></div>
                    <span class="badge bg-primary-subtle text-primary mb-3"><?= esc($m['prodi']) ?></span>
                    <div>
                        <a href="<?= site_url('/biodata/' . $m['nrp']) ?>" class="btn btn-sm btn-outline-primary w-100">Detail Biodata</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>

