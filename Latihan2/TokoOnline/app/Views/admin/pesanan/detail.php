<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<a href="<?= site_url('/admin/pesanan') ?>" class="btn btn-outline-secondary btn-sm mb-3">&larr; Kembali ke Daftar Pesanan</a>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-bold">Invoice <code><?= esc($pesanan['kode_invoice']) ?></code></span>
                <span class="badge <?= badge_status_pesanan($pesanan['status']) ?>"><?= esc(label_status_pesanan($pesanan['status'])) ?></span>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Penerima:</strong> <?= esc($pesanan['nama_penerima']) ?> (<?= esc($pesanan['no_hp']) ?>)</p>
                <p class="mb-3"><strong>Alamat:</strong> <?= esc($pesanan['alamat_pengiriman']) ?></p>

                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light"><tr><th>Produk</th><th class="text-end">Harga</th><th class="text-center">Qty</th><th class="text-end">Subtotal</th></tr></thead>
                    <tbody>
                        <?php foreach ($items as $it) : ?>
                            <tr>
                                <td><?= esc($it['nama_produk_snapshot']) ?></td>
                                <td class="text-end"><?= format_rupiah((int) $it['harga_satuan']) ?></td>
                                <td class="text-center"><?= esc($it['qty']) ?></td>
                                <td class="text-end"><?= format_rupiah((int) $it['subtotal']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr><th colspan="3" class="text-end">Ongkir</th><th class="text-end"><?= format_rupiah((int) $pesanan['ongkir']) ?></th></tr>
                        <tr class="table-success"><th colspan="3" class="text-end">Total</th><th class="text-end"><?= format_rupiah((int) $pesanan['total']) ?></th></tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Perbarui Status Pesanan</div>
            <div class="card-body">
                <form action="<?= site_url('/admin/pesanan/' . $pesanan['id'] . '/status') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Status Baru</label>
                        <select name="status" class="form-select">
                            <?php foreach ($tokoConfig->daftarStatus as $key => $label) : ?>
                                <option value="<?= esc($key) ?>" <?= $pesanan['status'] === $key ? 'selected' : '' ?>><?= esc($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Simpan Status</button>
                    <div class="small text-muted mt-2">
                        Jika diubah ke <strong>Dibatalkan</strong>, stok seluruh item pesanan dikembalikan otomatis dalam transaksi database.
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

