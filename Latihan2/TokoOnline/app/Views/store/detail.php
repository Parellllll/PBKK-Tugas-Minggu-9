<?= $this->extend('layouts/store') ?>
<?= $this->section('content') ?>

<a href="<?= site_url('/') ?>" class="btn btn-outline-secondary btn-sm mb-3">&larr; Kembali ke Katalog</a>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="row g-4 align-items-center">
            <div class="col-md-5">
                <?php if (! empty($produk['gambar']) && is_file(FCPATH . 'uploads/produk/' . $produk['gambar'])) : ?>
                    <img src="<?= base_url('uploads/produk/' . $produk['gambar']) ?>" alt="<?= esc($produk['nama']) ?>" class="img-fluid rounded-3 w-100" style="max-height:360px;object-fit:cover;">
                <?php else : ?>
                    <div class="product-thumb rounded-3" style="height:300px;">
                        <div class="text-center">
                            <i class="fas fa-box-open fa-4x mb-2 opacity-75"></i>
                            <div class="fw-bold"><?= esc($produk['kode']) ?></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-7">
                <span class="badge bg-success-subtle text-success mb-2"><?= esc($produk['nama_kategori']) ?></span>
                <h2 class="fw-bold mb-2"><?= esc($produk['nama']) ?></h2>
                <div class="text-muted small mb-3">
                    Kode: <code><?= esc($produk['kode']) ?></code> • Terjual: <strong><?= esc($produk['total_terjual'] ?? 0) ?></strong> unit
                </div>
                <div class="display-6 fw-bold text-success mb-3"><?= format_rupiah((int) $produk['harga']) ?></div>
                <p class="mb-4"><?= esc($produk['deskripsi']) ?></p>

                <div class="mb-3">
                    Status Stok:
                    <?php if ((int) $produk['stok'] > 0) : ?>
                        <span class="badge bg-success">Tersedia (<?= esc($produk['stok']) ?> unit)</span>
                    <?php else : ?>
                        <span class="badge bg-danger">Stok Habis</span>
                    <?php endif; ?>
                </div>

                <?php if ((int) $produk['stok'] > 0) : ?>
                    <form action="<?= site_url('/keranjang/tambah') ?>" method="post" class="d-flex align-items-center gap-2" style="max-width:320px;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="produk_id" value="<?= esc($produk['id']) ?>">
                        <input type="number" name="qty" value="1" min="1" max="<?= esc($produk['stok']) ?>" class="form-control" style="width:90px;">
                        <button type="submit" class="btn btn-success fw-semibold flex-grow-1">
                            <i class="fas fa-cart-plus me-1"></i>Tambah ke Keranjang
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if (! empty($terkait)) : ?>
    <h5 class="fw-bold mb-3">Produk Sejenis</h5>
    <div class="row g-3">
        <?php foreach ($terkait as $t) : ?>
            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="fw-bold"><a href="<?= site_url('/produk/' . $t['slug']) ?>" class="text-dark text-decoration-none"><?= esc($t['nama']) ?></a></h6>
                        <div class="text-success fw-bold"><?= format_rupiah((int) $t['harga']) ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

