<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-primary h-100">
            <div class="card-body">
                <div class="small fw-bold text-uppercase" style="color:#0f766e;">Total Omzet</div>
                <div class="h4 fw-bold mb-0"><?= format_rupiah($statistik['total_omzet']) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-success h-100">
            <div class="card-body">
                <div class="small fw-bold text-success text-uppercase">Total Pesanan</div>
                <div class="h3 fw-bold mb-0"><?= esc($statistik['total_pesanan']) ?> <small class="fs-6 text-warning">(<?= esc($statistik['pending_count']) ?> pending)</small></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-info h-100">
            <div class="card-body">
                <div class="small fw-bold text-info text-uppercase">Produk / Kategori</div>
                <div class="h3 fw-bold mb-0"><?= esc($totalProduk) ?> <small class="fs-6 text-muted">/ <?= esc($totalKategori) ?></small></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-warning h-100">
            <div class="card-body">
                <div class="small fw-bold text-warning text-uppercase">Pelanggan Terdaftar</div>
                <div class="h3 fw-bold mb-0"><?= esc($totalCustomer) ?></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold text-danger">Peringatan Stok Menipis (&le; 5)</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Kode</th><th>Produk</th><th class="text-end">Stok</th></tr></thead>
                    <tbody>
                        <?php if (empty($stokMenipis)) : ?>
                            <tr><td colspan="3" class="text-center py-3 text-muted">Semua stok produk aman.</td></tr>
                        <?php else : ?>
                            <?php foreach ($stokMenipis as $s) : ?>
                                <tr>
                                    <td><code><?= esc($s['kode']) ?></code></td>
                                    <td><?= esc($s['nama']) ?></td>
                                    <td class="text-end"><span class="badge bg-danger"><?= esc($s['stok']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-bold">Pesanan Terbaru</span>
                <a href="<?= site_url('/admin/pesanan') ?>" class="btn btn-sm btn-success">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light"><tr><th>Invoice</th><th>Customer</th><th>Total</th><th>Status</th><th></th></tr></thead>
                    <tbody>
                        <?php foreach (array_slice($pesananTerbaru, 0, 5) as $p) : ?>
                            <tr>
                                <td><code><?= esc($p['kode_invoice']) ?></code></td>
                                <td><?= esc($p['nama_penerima']) ?></td>
                                <td class="fw-semibold"><?= format_rupiah((int) $p['total']) ?></td>
                                <td><span class="badge <?= badge_status_pesanan($p['status']) ?>"><?= esc(label_status_pesanan($p['status'])) ?></span></td>
                                <td class="text-end"><a href="<?= site_url('/admin/pesanan/' . $p['kode_invoice']) ?>" class="btn btn-sm btn-outline-success">Detail</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

