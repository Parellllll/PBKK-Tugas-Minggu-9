<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Login SIAKAD') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light min-vh-100 d-flex align-items-center py-4" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white mb-2" style="width:60px;height:60px;">
                            <i class="fas fa-university fa-xl"></i>
                        </div>
                        <h4 class="fw-bold text-primary mb-1">SIAKAD CodeIgniter 4</h4>
                        <p class="small text-muted mb-0">Sistem Informasi Akademik — Latihan 2a PBKK D</p>
                    </div>

                    <?= $this->include('partials/flash') ?>

                    <form action="<?= site_url('/login') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username / Email</label>
                            <input type="text" name="identity" class="form-control" value="<?= esc(old('identity')) ?>" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
                            <i class="fas fa-sign-in-alt me-1"></i>Masuk Portal SIAKAD
                        </button>
                    </form>

                    <hr class="my-4">
                    <div class="small bg-light p-3 rounded border">
                        <div class="fw-bold mb-1">Akun Demo (3 Role):</div>
                        <div>• <strong>Admin:</strong> <code>admin</code> / <code>admin123</code></div>
                        <div>• <strong>Dosen:</strong> <code>dosen1</code> / <code>dosen123</code></div>
                        <div>• <strong>Mahasiswa:</strong> <code>farrel</code> / <code>mhs123</code></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

