<?= $this->extend('layouts/store') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-3">Riwayat Pesanan Saya</h3>

<?php if (empty($pesanan)) : ?>
    <div class="alert alert-info">Anda belum memiliki riwayat pesanan. <a href="<?= site_url('/') ?>">Mulai belanja sekarang</a>.</div>
<?php else : ?>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr><th>Invoice</th><th>Tanggal</th><th>Penerima</th><th>Total</th><th>Status</th><th class="text-end">Detail</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($pesanan as $p) : ?>
                        <tr>
                            <td><code><?= esc($p['kode_invoice']) ?></code></td>
                            <td class="small"><?= esc($p['created_at']) ?></td>
                            <td><?= esc($p['nama_penerima']) ?></td>
                            <td class="fw-bold text-success"><?= format_rupiah((int) $p['total']) ?></td>
                            <td><span class="badge <?= badge_status_pesanan($p['status']) ?>"><?= esc(label_status_pesanan($p['status'])) ?></span></td>
                            <td class="text-end">
                                <a href="<?= site_url('/pesanan/' . $p['kode_invoice']) ?>" class="btn btn-sm btn-outline-success">Lihat Invoice</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

