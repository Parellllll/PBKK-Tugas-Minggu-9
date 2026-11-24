<?= $this->extend('layouts/store') ?>
<?= $this->section('content') ?>

<a href="<?= site_url('/pesanan') ?>" class="btn btn-outline-secondary btn-sm mb-3">&larr; Kembali ke Riwayat Pesanan</a>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center py-3">
        <div>
            <h5 class="fw-bold mb-0">Invoice <code><?= esc($pesanan['kode_invoice']) ?></code></h5>
            <small class="text-muted">Dibuat: <?= esc($pesanan['created_at']) ?></small>
        </div>
        <span class="badge <?= badge_status_pesanan($pesanan['status']) ?> fs-6"><?= esc(label_status_pesanan($pesanan['status'])) ?></span>
    </div>
    <div class="card-body">
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="small text-muted">Penerima &amp; Pengiriman</div>
                <div class="fw-bold"><?= esc($pesanan['nama_penerima']) ?> (<?= esc($pesanan['no_hp']) ?>)</div>
                <div class="small"><?= esc($pesanan['alamat_pengiriman']) ?></div>
            </div>
            <div class="col-md-6">
                <div class="small text-muted">Metode Pembayaran</div>
                <div class="fw-bold"><?= esc($tokoConfig->metodePembayaran[$pesanan['metode_pembayaran']] ?? $pesanan['metode_pembayaran']) ?></div>
                <?php if (! empty($pesanan['catatan'])) : ?>
                    <div class="small text-muted">Catatan: <?= esc($pesanan['catatan']) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr><th>Produk</th><th class="text-end">Harga Satuan</th><th class="text-center">Qty</th><th class="text-end">Subtotal</th></tr>
            </thead>
            <tbody>
                <?php foreach ($items as $it) : ?>
                    <tr>
                        <td class="fw-semibold"><?= esc($it['nama_produk_snapshot']) ?></td>
                        <td class="text-end"><?= format_rupiah((int) $it['harga_satuan']) ?></td>
                        <td class="text-center"><?= esc($it['qty']) ?></td>
                        <td class="text-end"><?= format_rupiah((int) $it['subtotal']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr><th colspan="3" class="text-end">Subtotal</th><th class="text-end"><?= format_rupiah((int) $pesanan['subtotal']) ?></th></tr>
                <tr><th colspan="3" class="text-end">Ongkos Kirim</th><th class="text-end"><?= (int) $pesanan['ongkir'] === 0 ? 'GRATIS' : format_rupiah((int) $pesanan['ongkir']) ?></th></tr>
                <tr class="table-success"><th colspan="3" class="text-end">Total Bayar</th><th class="text-end fs-5"><?= format_rupiah((int) $pesanan['total']) ?></th></tr>
            </tfoot>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

