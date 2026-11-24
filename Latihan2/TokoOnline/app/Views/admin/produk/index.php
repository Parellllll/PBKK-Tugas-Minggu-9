<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h4 class="fw-bold mb-0">Kelola Produk &amp; Stok</h4>
    <div class="d-flex gap-2">
        <form method="get" class="d-flex gap-2">
            <input type="text" name="q" value="<?= esc($keyword) ?>" class="form-control form-control-sm" placeholder="Cari produk...">
            <button type="submit" class="btn btn-sm btn-outline-success">Cari</button>
        </form>
        <a href="<?= site_url('/admin/produk/create') ?>" class="btn btn-success btn-sm"><i class="fas fa-plus me-1"></i>Tambah Produk</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Kode</th><th>Nama Produk</th><th>Kategori</th><th class="text-end">Harga</th><th class="text-center">Stok</th><th class="text-center">Terjual</th><th>Status</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($produk as $p) : ?>
                    <tr>
                        <td><code><?= esc($p['kode']) ?></code></td>
                        <td class="fw-semibold"><?= esc($p['nama']) ?></td>
                        <td class="small"><?= esc($p['nama_kategori']) ?></td>
                        <td class="text-end"><?= format_rupiah((int) $p['harga']) ?></td>
                        <td class="text-center"><span class="badge <?= (int) $p['stok'] <= 5 ? 'bg-danger' : 'bg-success' ?>"><?= esc($p['stok']) ?></span></td>
                        <td class="text-center"><?= esc($p['total_terjual'] ?? 0) ?></td>
                        <td><span class="badge <?= (int) $p['is_aktif'] === 1 ? 'bg-primary' : 'bg-secondary' ?>"><?= (int) $p['is_aktif'] === 1 ? 'Aktif' : 'Nonaktif' ?></span></td>
                        <td class="text-end text-nowrap">
                            <a href="<?= site_url('/admin/produk/edit/' . $p['id']) ?>" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                            <form action="<?= site_url('/admin/produk/delete/' . $p['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus produk ini?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white d-flex justify-content-end"><?= $pager->links('default', 'bootstrap') ?></div>
</div>

<?= $this->endSection() ?>

