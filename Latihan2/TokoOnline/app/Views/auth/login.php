<?= $this->extend('layouts/store') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-1" style="color:#0f766e;">Login TokoKita</h4>
                <p class="small text-muted mb-4">Masuk untuk melanjutkan checkout atau melacak pesanan.</p>

                <form action="<?= site_url('/login') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username atau Email</label>
                        <input type="text" name="identity" class="form-control" value="<?= esc(old('identity')) ?>" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-semibold">Masuk</button>
                </form>

                <hr class="my-4">
                <div class="small bg-light p-3 rounded border">
                    <div class="fw-bold mb-1">Akun Demo Seeder:</div>
                    <div>• Admin Toko: <code>admin</code> / <code>admin123</code></div>
                    <div>• Customer: <code>farrel</code> / <code>user123</code></div>
                </div>
                <div class="text-center mt-3 small">
                    Belum punya akun? <a href="<?= site_url('/register') ?>">Daftar pelanggan baru</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

