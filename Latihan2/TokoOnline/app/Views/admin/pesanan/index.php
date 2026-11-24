<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h4 class="fw-bold mb-0">Manajemen Pesanan</h4>
    <form method="get" class="d-flex gap-2">
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <?php foreach ($tokoConfig->daftarStatus as $key => $label) : ?>
                <option value="<?= esc($key) ?>" <?= $statusAktif === $key ? 'selected' : '' ?>><?= esc($label) ?></option>
            <?php endforeach; ?>
        </select>
    </form>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Invoice</th><th>Customer</th><th>Tanggal</th><th class="text-end">Total</th><th>Status</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($pesanan as $p) : ?>
                    <tr>
                        <td><code><?= esc($p['kode_invoice']) ?></code></td>
                        <td>
                            <div class="fw-semibold"><?= esc($p['nama_penerima']) ?></div>
                            <small class="text-muted"><?= esc($p['email']) ?></small>
                        </td>
                        <td class="small"><?= esc($p['created_at']) ?></td>
                        <td class="text-end fw-semibold"><?= format_rupiah((int) $p['total']) ?></td>
                        <td><span class="badge <?= badge_status_pesanan($p['status']) ?>"><?= esc(label_status_pesanan($p['status'])) ?></span></td>
                        <td class="text-end">
                            <a href="<?= site_url('/admin/pesanan/' . $p['kode_invoice']) ?>" class="btn btn-sm btn-outline-success">Kelola</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

