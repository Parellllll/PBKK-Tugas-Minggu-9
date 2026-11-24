<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h4 class="fw-bold text-primary mb-1">Registrasi Akun Baru</h4>
                <p class="small text-muted mb-4">Akun baru otomatis memiliki role <code>user</code>.</p>

                <form action="<?= site_url('/register') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?= esc(old('nama_lengkap')) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= esc(old('username')) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= esc(old('email')) ?>" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Konfirmasi Password</label>
                            <input type="password" name="password_confirm" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-semibold">Daftar Sekarang</button>
                </form>

                <div class="text-center mt-3 small">
                    Sudah punya akun? <a href="<?= site_url('/login') ?>">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

