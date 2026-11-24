<?= $this->extend('layouts/store') ?>
<?= $this->section('content') ?>

<div class="p-4 p-md-5 mb-4 text-white rounded-4 shadow-sm" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <span class="badge bg-warning text-dark mb-2">Gratis Ongkir minimal belanja Rp 250.000</span>
            <h1 class="display-6 fw-bold">TokoKita — Perlengkapan Produktivitas &amp; Kampus</h1>
            <p class="mb-0 opacity-90">
                Aplikasi Toko Online CodeIgniter 4.7.6 dengan filter &amp; sorting katalog, subquery produk terlaris,
                keranjang belanja berbasis Library/Service, serta checkout transaksi stok atomik.
            </p>
        </div>
    </div>
</div>

<form method="get" action="<?= site_url('/') ?>" class="card border-0 shadow-sm mb-4">
    <div class="card-body row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Cari Produk</label>
            <input type="text" name="q" value="<?= esc($filters['q']) ?>" class="form-control form-control-sm" placeholder="Keyboard, SSD, buku...">
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Kategori</label>
            <select name="kategori" class="form-select form-select-sm">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategori as $kat) : ?>
                    <option value="<?= esc($kat['slug']) ?>" <?= $filters['kategori'] === $kat['slug'] ? 'selected' : '' ?>>
                        <?= esc($kat['nama']) ?> (<?= esc($kat['jumlah_produk']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small fw-semibold">Min Harga</label>
            <input type="number" name="min_harga" value="<?= esc($filters['min_harga']) ?>" class="form-control form-control-sm" placeholder="0">
        </div>
        <div class="col-md-2">
            <label class="form-label small fw-semibold">Urutkan</label>
            <select name="sort" class="form-select form-select-sm">
                <option value="terbaru"  <?= $filters['sort'] === 'terbaru'  ? 'selected' : '' ?>>Terbaru</option>
                <option value="terlaris" <?= $filters['sort'] === 'terlaris' ? 'selected' : '' ?>>Terlaris</option>
                <option value="termurah" <?= $filters['sort'] === 'termurah' ? 'selected' : '' ?>>Harga Termurah</option>
                <option value="termahal" <?= $filters['sort'] === 'termahal' ? 'selected' : '' ?>>Harga Termahal</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-1">
            <button type="submit" class="btn btn-success btn-sm flex-grow-1">Filter</button>
            <a href="<?= site_url('/') ?>" class="btn btn-outline-secondary btn-sm">Reset</a>
        </div>
    </div>
</form>

<?php if (empty($produk)) : ?>
    <div class="alert alert-warning">Tidak ada produk yang cocok dengan filter pencarian Anda.</div>
<?php else : ?>
    <div class="row g-3">
        <?php foreach ($produk as $p) : ?>
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm overflow-hidden">
                    <a href="<?= site_url('/produk/' . $p['slug']) ?>" class="text-decoration-none">
                        <?php if (! empty($p['gambar']) && is_file(FCPATH . 'uploads/produk/' . $p['gambar'])) : ?>
                            <img src="<?= base_url('uploads/produk/' . $p['gambar']) ?>" alt="<?= esc($p['nama']) ?>" class="w-100 product-thumb">
                        <?php else : ?>
                            <div class="product-thumb flex-column">
                                <i class="fas fa-box-open fa-3x mb-2 opacity-75"></i>
                                <small class="fw-semibold"><?= esc($p['kode']) ?></small>
                            </div>
                        <?php endif; ?>
                    </a>
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-success-subtle text-success align-self-start mb-1"><?= esc($p['nama_kategori']) ?></span>
                        <h6 class="fw-bold mb-1">
                            <a href="<?= site_url('/produk/' . $p['slug']) ?>" class="text-dark text-decoration-none"><?= esc($p['nama']) ?></a>
                        </h6>
                        <div class="small text-muted mb-2">
                            Stok: <strong><?= esc($p['stok']) ?></strong> • Terjual: <?= esc($p['total_terjual'] ?? 0) ?>
                        </div>
                        <div class="fs-5 fw-bold text-success mt-auto mb-3"><?= format_rupiah((int) $p['harga']) ?></div>
                        <div class="d-flex gap-1">
                            <a href="<?= site_url('/produk/' . $p['slug']) ?>" class="btn btn-outline-secondary btn-sm">Detail</a>
                            <?php if ((int) $p['stok'] > 0) : ?>
                                <form action="<?= site_url('/keranjang/tambah') ?>" method="post" class="flex-grow-1">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="produk_id" value="<?= esc($p['id']) ?>">
                                    <input type="hidden" name="qty" value="1">
                                    <button type="submit" class="btn btn-success btn-sm w-100">
                                        <i class="fas fa-cart-plus me-1"></i>+ Keranjang
                                    </button>
                                </form>
                            <?php else : ?>
                                <button class="btn btn-secondary btn-sm flex-grow-1" disabled>Stok Habis</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-4 d-flex justify-content-end">
        <?= $pager->links('default', 'bootstrap') ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

