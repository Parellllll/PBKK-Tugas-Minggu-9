<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-primary h-100">
            <div class="card-body">
                <div class="text-xs fw-bold text-primary text-uppercase small">Total Mahasiswa</div>
                <div class="h3 fw-bold mb-0"><?= esc($ringkasan['total']) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-success h-100">
            <div class="card-body">
                <div class="text-xs fw-bold text-success text-uppercase small">Rata-rata IPK</div>
                <div class="h3 fw-bold mb-0"><?= number_format($ringkasan['rata_ipk'], 2) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-info h-100">
            <div class="card-body">
                <div class="text-xs fw-bold text-info text-uppercase small">IPK Tertinggi</div>
                <div class="h3 fw-bold mb-0"><?= number_format($ringkasan['max_ipk'], 2) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-warning h-100">
            <div class="card-body">
                <div class="text-xs fw-bold text-warning text-uppercase small">Total Akun User</div>
                <div class="h3 fw-bold mb-0"><?= esc($totalUsers) ?></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold text-primary">Sebaran Program Studi</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Prodi</th><th class="text-end">Jumlah</th><th class="text-end">Rata IPK</th></tr></thead>
                    <tbody>
                        <?php foreach ($ringkasan['per_prodi'] as $row) : ?>
                            <tr>
                                <td><?= esc($row['prodi']) ?></td>
                                <td class="text-end"><span class="badge bg-primary"><?= esc($row['jumlah']) ?></span></td>
                                <td class="text-end"><?= number_format((float) $row['rata_ipk'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-bold text-primary">Data Mahasiswa Terbaru</span>
                <a href="<?= site_url('/admin/mahasiswa') ?>" class="btn btn-sm btn-primary">Kelola Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light"><tr><th>NRP</th><th>Nama</th><th>Prodi</th><th class="text-end">IPK</th></tr></thead>
                        <tbody>
                            <?php foreach ($terbaru as $m) : ?>
                                <tr>
                                    <td><code><?= esc($m['nrp']) ?></code></td>
                                    <td><?= esc($m['nama']) ?></td>
                                    <td class="small"><?= esc($m['prodi']) ?></td>
                                    <td class="text-end fw-semibold"><?= number_format((float) $m['ipk'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

