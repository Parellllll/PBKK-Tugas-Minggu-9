<?= $this->extend('layouts/store') ?>
<?= $this->section('content') ?>

<h3 class="fw-bold mb-3">Checkout Pesanan</h3>

<form action="<?= site_url('/checkout/proses') ?>" method="post">
    <?= csrf_field() ?>
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Informasi Pengiriman &amp; Pembayaran</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Penerima *</label>
                            <input type="text" name="nama_penerima" class="form-control" value="<?= esc(old('nama_penerima', $user['nama_lengkap'] ?? '')) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nomor HP *</label>
                            <input type="text" name="no_hp" class="form-control" value="<?= esc(old('no_hp', $user['no_hp'] ?? '')) ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Alamat Pengiriman Lengkap *</label>
                            <textarea name="alamat_pengiriman" rows="3" class="form-control" required><?= esc(old('alamat_pengiriman', $user['alamat_default'] ?? '')) ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Metode Pembayaran *</label>
                            <select name="metode_pembayaran" class="form-select" required>
                                <?php foreach ($tokoConfig->metodePembayaran as $key => $label) : ?>
                                    <option value="<?= esc($key) ?>" <?= old('metode_pembayaran') === $key ? 'selected' : '' ?>><?= esc($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Catatan (Opsional)</label>
                            <input type="text" name="catatan" class="form-control" value="<?= esc(old('catatan')) ?>" placeholder="Misal: warna / patokan rumah">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Ringkasan Item</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush mb-3">
                        <?php foreach ($items as $it) : ?>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <div>
                                    <div class="fw-semibold"><?= esc($it['nama']) ?></div>
                                    <small class="text-muted"><?= esc($it['qty']) ?> &times; <?= format_rupiah($it['harga']) ?></small>
                                </div>
                                <span class="fw-semibold"><?= format_rupiah($it['harga'] * $it['qty']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="d-flex justify-content-between mb-1"><span>Subtotal</span><span><?= format_rupiah($subtotal) ?></span></div>
                    <div class="d-flex justify-content-between mb-2"><span>Ongkos Kirim</span><span><?= $ongkir === 0 ? 'GRATIS' : format_rupiah($ongkir) ?></span></div>
                    <hr>
                    <div class="d-flex justify-content-between fs-5 fw-bold mb-3">
                        <span>Total Bayar</span>
                        <span class="text-success"><?= format_rupiah($grandTotal) ?></span>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-semibold py-2">
                        <i class="fas fa-check-circle me-1"></i>Konfirmasi &amp; Buat Pesanan
                    </button>
                    <div class="small text-muted text-center mt-2">
                        Transaksi diproses secara atomik dengan validasi stok real-time.
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?= $this->endSection() ?>

