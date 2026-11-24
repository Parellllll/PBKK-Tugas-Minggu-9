<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-5 text-center">
        <span class="badge bg-success mb-2">Demo Router &amp; Controller</span>
        <h1 class="fw-bold text-primary">Hello, <?= esc($nama) ?>!</h1>
        <p class="lead text-muted mb-4"><?= esc($pesan) ?></p>

        <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
            <a href="<?= site_url('/hello') ?>" class="btn btn-outline-primary">/hello</a>
            <a href="<?= site_url('/hello/Farrel') ?>" class="btn btn-outline-primary">/hello/Farrel</a>
            <a href="<?= site_url('/hello/Teknik%20Informatika%20ITS') ?>" class="btn btn-outline-primary">/hello/Teknik Informatika ITS</a>
        </div>

        <div class="alert alert-info text-start mx-auto" style="max-width: 640px;">
            <strong>Alur MVC:</strong> Permintaan URL <code>/hello/(:segment)</code> diarahkan oleh <code>Config/Routes.php</code>
            ke <code>App\Controllers\HelloController::sapa($nama)</code> lalu dirender oleh view <code>app/Views/hello/index.php</code>.
        </div>
    </div>
</div>

<?= $this->endSection() ?>

