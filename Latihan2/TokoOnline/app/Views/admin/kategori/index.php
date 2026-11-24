<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Tambah Kategori</div>
            <div class="card-body">
                <form action="<?= site_url('/admin/kategori/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Nama Kategori</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Simpan Kategori</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Daftar Kategori Produk</div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light"><tr><th>Nama</th><th>Slug</th><th class="text-center">Produk</th><th class="text-end">Aksi</th></tr></thead>
                    <tbody>
                        <?php foreach ($kategori as $k) : ?>
                            <tr>
                                <td class="fw-semibold"><?= esc($k['nama']) ?><div class="small text-muted"><?= esc($k['deskripsi']) ?></div></td>
                                <td><code><?= esc($k['slug']) ?></code></td>
                                <td class="text-center"><span class="badge bg-success"><?= esc($k['jumlah_produk']) ?></span></td>
                                <td class="text-end">
                                    <form action="<?= site_url('/admin/kategori/delete/' . $k['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus kategori ini?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

