<?= $this->extend('layouts/sbadmin') ?>
<?= $this->section('content') ?>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-primary h-100">
            <div class="card-body">
                <div class="small fw-bold text-primary text-uppercase">Program Studi</div>
                <div class="h3 fw-bold mb-0"><?= esc($totalProdi) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-success h-100">
            <div class="card-body">
                <div class="small fw-bold text-success text-uppercase">Dosen Aktif</div>
                <div class="h3 fw-bold mb-0"><?= esc($totalDosen) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-info h-100">
            <div class="card-body">
                <div class="small fw-bold text-info text-uppercase">Mahasiswa</div>
                <div class="h3 fw-bold mb-0"><?= esc($totalMahasiswa) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-warning h-100">
            <div class="card-body">
                <div class="small fw-bold text-warning text-uppercase">Mata Kuliah / KRS</div>
                <div class="h3 fw-bold mb-0"><?= esc($totalMataKuliah) ?> <small class="fs-6 text-muted">/ <?= esc($totalKrs) ?> KRS</small></div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-bold text-primary">Kelas Perkuliahan Semester Aktif (<?= esc($tahunAktif['nama'] ?? '-') ?>)</span>
        <a href="<?= site_url('/admin/master/kelas') ?>" class="btn btn-sm btn-primary">Kelola Kelas</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode MK</th>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>Dosen Pengampu</th>
                    <th>Jadwal &amp; Ruang</th>
                    <th class="text-center">Peserta</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kelasAktif as $k) : ?>
                    <tr>
                        <td><code><?= esc($k['kode_mk']) ?></code></td>
                        <td>
                            <div class="fw-semibold"><?= esc($k['nama_mk']) ?></div>
                            <small class="text-muted"><?= esc($k['sks']) ?> SKS</small>
                        </td>
                        <td><span class="badge bg-primary"><?= esc($k['nama_kelas']) ?></span></td>
                        <td><?= esc(nama_dosen_lengkap(['nama' => $k['nama_dosen'], 'gelar_depan' => $k['gelar_depan'], 'gelar_belakang' => $k['gelar_belakang']])) ?></td>
                        <td class="small"><?= esc($k['jadwal']) ?> • <strong><?= esc($k['ruangan']) ?></strong></td>
                        <td class="text-center"><span class="badge bg-info text-dark"><?= esc($k['jumlah_peserta']) ?> / <?= esc($k['kuota']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

