<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<a href="<?= site_url('/admin/produk') ?>" class="btn btn-outline-secondary btn-sm mb-3">&larr; Kembali</a>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold"><?= $mode === 'edit' ? 'Edit Produk' : 'Tambah Produk Baru' ?></div>
    <div class="card-body">
        <form action="<?= $mode === 'edit' ? site_url('/admin/produk/update/' . $produk['id']) : site_url('/admin/produk/store') ?>"
              method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kode Produk *</label>
                    <input type="text" name="kode" class="form-control" value="<?= esc(old('kode', $produk['kode'] ?? '')) ?>" placeholder="PRD-011" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Nama Produk *</label>
                    <input type="text" name="nama" class="form-control" value="<?= esc(old('nama', $produk['nama'] ?? '')) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kategori *</label>
                    <select name="kategori_id" class="form-select" required>
                        <?php $katSel = (int) old('kategori_id', $produk['kategori_id'] ?? 0); ?>
                        <?php foreach ($kategori as $k) : ?>
                            <option value="<?= esc($k['id']) ?>" <?= $katSel === (int) $k['id'] ? 'selected' : '' ?>><?= esc($k['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Harga (Rp) *</label>
                    <input type="number" name="harga" min="1000" class="form-control" value="<?= esc(old('harga', $produk['harga'] ?? 100000)) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Stok *</label>
                    <input type="number" name="stok" min="0" class="form-control" value="<?= esc(old('stok', $produk['stok'] ?? 10)) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Gambar Produk (JPG/PNG/WEBP, maks 2MB)</label>
                    <input type="file" name="gambar" class="form-control" accept="image/jpeg,image/png,image/webp">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="form-control"><?= esc(old('deskripsi', $produk['deskripsi'] ?? '')) ?></textarea>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_aktif" value="1" id="aktifCheck"
                               <?= (int) old('is_aktif', $produk['is_aktif'] ?? 1) === 1 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="aktifCheck">Tampilkan di katalog toko (Aktif)</label>
                    </div>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i>Simpan Produk</button>
                <a href="<?= site_url('/admin/produk') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

