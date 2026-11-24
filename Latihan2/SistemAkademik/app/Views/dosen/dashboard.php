<?= $this->extend('layouts/sbadmin') ?>
<?= $this->section('content') ?>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h4 class="fw-bold text-primary mb-1">Selamat Datang, <?= esc($dosen ? nama_dosen_lengkap($dosen) : session()->get('user_nama')) ?></h4>
        <p class="text-muted mb-0 small">
            NIDN: <code><?= esc($dosen['nidn'] ?? '-') ?></code> • Program Studi: <strong><?= esc($dosen['nama_prodi'] ?? '-') ?></strong>
        </p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm border-left-primary">
            <div class="card-body">
                <div class="small fw-bold text-primary text-uppercase">Kelas Semester Aktif</div>
                <div class="h3 fw-bold mb-0"><?= count($kelasAktif) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm border-left-success">
            <div class="card-body">
                <div class="small fw-bold text-success text-uppercase">Total Mahasiswa Aktif</div>
                <div class="h3 fw-bold mb-0"><?= esc($totalPeserta) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm border-left-info">
            <div class="card-body">
                <div class="small fw-bold text-info text-uppercase">Total Riwayat Kelas</div>
                <div class="h3 fw-bold mb-0"><?= esc($totalKelas) ?></div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold text-primary">Kelas Diampu — <?= esc($tahunAktif['nama'] ?? '-') ?></div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Kode</th><th>Mata Kuliah</th><th>Kelas</th><th>Jadwal &amp; Ruang</th><th>Peserta</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                <?php if (empty($kelasAktif)) : ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada kelas pada semester aktif.</td></tr>
                <?php else : ?>
                    <?php foreach ($kelasAktif as $k) : ?>
                        <tr>
                            <td><code><?= esc($k['kode_mk']) ?></code></td>
                            <td class="fw-semibold"><?= esc($k['nama_mk']) ?> <span class="badge bg-light text-dark border"><?= esc($k['sks']) ?> SKS</span></td>
                            <td><span class="badge bg-primary"><?= esc($k['nama_kelas']) ?></span></td>
                            <td class="small"><?= esc($k['jadwal']) ?> • <?= esc($k['ruangan']) ?></td>
                            <td><?= esc($k['jumlah_peserta']) ?> / <?= esc($k['kuota']) ?></td>
                            <td class="text-end">
                                <a href="<?= site_url('/dosen/kelas/' . $k['id'] . '/nilai') ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-pen me-1"></i>Input Nilai
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

