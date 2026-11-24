<?= $this->extend('layouts/store') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-1" style="color:#0f766e;">Registrasi Pelanggan</h4>
                <p class="small text-muted mb-4">Buat akun TokoKita untuk belanja &amp; pantau riwayat pesanan.</p>

                <form action="<?= site_url('/register') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label fw-semibold">Nama Lengkap *</label><input type="text" name="nama_lengkap" class="form-control" value="<?= esc(old('nama_lengkap')) ?>" required></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Username *</label><input type="text" name="username" class="form-control" value="<?= esc(old('username')) ?>" required></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Email *</label><input type="email" name="email" class="form-control" value="<?= esc(old('email')) ?>" required></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Nomor HP</label><input type="text" name="no_hp" class="form-control" value="<?= esc(old('no_hp')) ?>"></div>
                        <div class="col-12"><label class="form-label fw-semibold">Alamat Pengiriman Default</label><textarea name="alamat_default" rows="2" class="form-control"><?= esc(old('alamat_default')) ?></textarea></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Password *</label><input type="password" name="password" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Konfirmasi Password *</label><input type="password" name="password_confirm" class="form-control" required></div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-semibold mt-4">Buat Akun</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

