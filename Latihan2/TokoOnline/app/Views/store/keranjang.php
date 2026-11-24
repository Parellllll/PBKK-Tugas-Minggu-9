<?= $this->extend('layouts/store') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-3">Keranjang Belanja</h3>

<?php if (empty($items)) : ?>
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
            <h5 class="fw-bold">Keranjang Belanja Masih Kosong</h5>
            <p class="text-muted">Yuk jelajahi katalog produk TokoKita terlebih dahulu.</p>
            <a href="<?= site_url('/') ?>" class="btn btn-success">Belanja Sekarang</a>
        </div>
    </div>
<?php else : ?>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr><th>Produk</th><th>Harga</th><th style="width:150px;">Jumlah</th><th class="text-end">Subtotal</th><th class="text-end">Hapus</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item) : ?>
                                <tr>
                                    <td>
                                        <a href="<?= site_url('/produk/' . $item['slug']) ?>" class="fw-semibold text-dark text-decoration-none"><?= esc($item['nama']) ?></a>
                                        <div class="small text-muted">Kode: <?= esc($item['kode']) ?></div>
                                    </td>
                                    <td><?= format_rupiah($item['harga']) ?></td>
                                    <td>
                                        <form action="<?= site_url('/keranjang/ubah') ?>" method="post" class="d-flex gap-1">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="produk_id" value="<?= esc($item['produk_id']) ?>">
                                            <input type="number" name="qty" value="<?= esc($item['qty']) ?>" min="1" class="form-control form-control-sm">
                                            <button type="submit" class="btn btn-sm btn-outline-success">OK</button>
                                        </form>
                                    </td>
                                    <td class="text-end fw-semibold"><?= format_rupiah($item['harga'] * $item['qty']) ?></td>
                                    <td class="text-end">
                                        <form action="<?= site_url('/keranjang/hapus/' . $item['produk_id']) ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between">
                    <a href="<?= site_url('/') ?>" class="btn btn-outline-secondary btn-sm">&larr; Lanjut Belanja</a>
                    <form action="<?= site_url('/keranjang/kosongkan') ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-outline-danger btn-sm">Kosongkan Keranjang</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Ringkasan Belanja</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <strong><?= format_rupiah($subtotal) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkos Kirim</span>
                        <strong><?= $ongkir === 0 ? '<span class="text-success">GRATIS</span>' : format_rupiah($ongkir) ?></strong>
                    </div>
                    <?php if ($ongkir > 0) : ?>
                        <div class="small text-muted mb-2">
                            Tambah <?= format_rupiah($tokoConfig->gratisOngkirMinimal - $subtotal) ?> lagi untuk gratis ongkir!
                        </div>
                    <?php endif; ?>
                    <hr>
                    <div class="d-flex justify-content-between fs-5 fw-bold mb-3">
                        <span>Total Bayar</span>
                        <span class="text-success"><?= format_rupiah($grandTotal) ?></span>
                    </div>
                    <a href="<?= site_url('/checkout') ?>" class="btn btn-success w-100 fw-semibold">
                        Lanjut ke Checkout &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

