<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin TokoKita') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/toko.css') ?>" rel="stylesheet">
</head>
<body class="sb-admin">
<div id="wrapper">
    <?= $this->include('partials/admin_sidebar') ?>

    <div id="content-wrapper">
        <?= $this->include('partials/admin_topbar') ?>

        <main class="container-fluid p-4 flex-grow-1">
            <?= $this->include('partials/flash') ?>
            <?= $this->renderSection('content') ?>
        </main>

        <footer class="bg-white border-top py-3 px-4 small text-muted d-flex justify-content-between">
            <span>Panel Admin SB Admin 2 — TokoKita CI4</span>
            <span>Farrel Prastita Ramaddhan (5025241219)</span>
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

