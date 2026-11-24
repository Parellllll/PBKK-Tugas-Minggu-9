<?= $this->extend('layouts/sbadmin') ?>
<?= $this->section('content') ?>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h4 class="fw-bold text-primary mb-1"><?= esc($mahasiswa['nama'] ?? session()->get('user_nama')) ?></h4>
            <div class="small text-muted">
                NRP: <code><?= esc($mahasiswa['nrp'] ?? '-') ?></code> •
                <?= esc($mahasiswa['nama_prodi'] ?? '-') ?> •
                Angkatan <?= esc($mahasiswa['angkatan'] ?? '-') ?>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= site_url('/mahasiswa/krs') ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit me-1"></i>Isi KRS</a>
            <a href="<?= site_url('/mahasiswa/khs') ?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-file-alt me-1"></i>Lihat KHS</a>
            <a href="<?= site_url('/mahasiswa/transkrip') ?>" class="btn btn-outline-success btn-sm"><i class="fas fa-award me-1"></i>Transkrip</a>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-primary h-100">
            <div class="card-body">
                <div class="small fw-bold text-primary text-uppercase">IPK Kumulatif</div>
                <div class="h2 fw-bold mb-0"><?= number_format($ipkData['ips_atau_ipk'], 2) ?></div>
                <small class="text-muted"><?= esc(predikat_ipk($ipkData['ips_atau_ipk'])) ?></small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-success h-100">
            <div class="card-body">
                <div class="small fw-bold text-success text-uppercase">SKS Lulus / Dinilai</div>
                <div class="h2 fw-bold mb-0"><?= esc($ipkData['sks_dinilai']) ?> <small class="fs-6 text-muted">SKS</small></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-info h-100">
            <div class="card-body">
                <div class="small fw-bold text-info text-uppercase">SKS Semester Aktif</div>
                <div class="h2 fw-bold mb-0"><?= esc($sksAktif) ?> / <?= esc($akademikConfig->maxSksPerSemester) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-warning h-100">
            <div class="card-body">
                <div class="small fw-bold text-warning text-uppercase">Total Nilai Mutu</div>
                <div class="h2 fw-bold mb-0"><?= number_format($ipkData['total_mutu'], 2) ?></div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold text-primary">KRS Aktif — <?= esc($tahunAktif['nama'] ?? '-') ?></div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Kode MK</th><th>Mata Kuliah</th><th>Kelas</th><th>Dosen</th><th>Jadwal</th><th class="text-center">SKS</th><th class="text-center">Nilai</th></tr>
            </thead>
            <tbody>
                <?php if (empty($krsAktif)) : ?>
                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada mata kuliah diambil pada semester ini.</td></tr>
                <?php else : ?>
                    <?php foreach ($krsAktif as $row) : ?>
                        <tr>
                            <td><code><?= esc($row['kode_mk']) ?></code></td>
                            <td class="fw-semibold"><?= esc($row['nama_mk']) ?></td>
                            <td><span class="badge bg-primary"><?= esc($row['nama_kelas']) ?></span></td>
                            <td class="small"><?= esc(nama_dosen_lengkap(['nama' => $row['nama_dosen'], 'gelar_depan' => $row['gelar_depan'], 'gelar_belakang' => $row['gelar_belakang']])) ?></td>
                            <td class="small"><?= esc($row['jadwal']) ?> (<?= esc($row['ruangan']) ?>)</td>
                            <td class="text-center"><?= esc($row['sks']) ?></td>
                            <td class="text-center">
                                <?php if ($row['nilai_huruf']) : ?>
                                    <span class="badge <?= badge_nilai($row['nilai_huruf']) ?>"><?= esc($row['nilai_huruf']) ?></span>
                                <?php else : ?>
                                    <span class="badge bg-light text-muted border">Belum dinilai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

