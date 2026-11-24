<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h4 class="fw-bold text-primary mb-1">Login Sistem</h4>
                <p class="small text-muted mb-4">Masuk untuk mengakses profil atau panel SB Admin 2.</p>

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
                    <button type="submit" class="btn btn-primary w-100 fw-semibold">
                        <i class="fas fa-sign-in-alt me-1"></i>Masuk
                    </button>
                </form>

                <hr class="my-4">
                <div class="small bg-light p-3 rounded border">
                    <div class="fw-bold mb-1">Akun Demo Seeder:</div>
                    <div>• Admin: <code>admin</code> / <code>admin123</code></div>
                    <div>• User: <code>farrel</code> / <code>mhs123</code></div>
                </div>
                <div class="text-center mt-3 small">
                    Belum punya akun? <a href="<?= site_url('/register') ?>">Daftar di sini</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

