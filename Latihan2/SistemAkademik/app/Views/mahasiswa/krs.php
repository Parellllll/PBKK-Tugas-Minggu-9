<?= $this->extend('layouts/sbadmin') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div>
        <h4 class="fw-bold mb-0">Kartu Rencana Studi (KRS) — <?= esc($tahunAktif['nama'] ?? '-') ?></h4>
        <small class="text-muted">Beban SKS diambil: <strong><?= esc($sksDiambil) ?> / <?= esc($maxSks) ?> SKS</strong></small>
    </div>
    <div class="progress" style="width: 240px; height: 22px;">
        <?php $pct = $maxSks > 0 ? min(100, (int) round(($sksDiambil / $maxSks) * 100)) : 0; ?>
        <div class="progress-bar bg-primary" style="width: <?= $pct ?>%;"><?= $sksDiambil ?> / <?= $maxSks ?> SKS</div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-bold text-primary">Mata Kuliah yang Diambil Semester Ini</div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Kode</th><th>Mata Kuliah</th><th>Kelas</th><th>Jadwal &amp; Ruang</th><th class="text-center">SKS</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                <?php if (empty($krsDiambil)) : ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada mata kuliah pada KRS semester ini.</td></tr>
                <?php else : ?>
                    <?php foreach ($krsDiambil as $r) : ?>
                        <tr>
                            <td><code><?= esc($r['kode_mk']) ?></code></td>
                            <td class="fw-semibold"><?= esc($r['nama_mk']) ?></td>
                            <td><span class="badge bg-primary"><?= esc($r['nama_kelas']) ?></span></td>
                            <td class="small"><?= esc($r['jadwal']) ?> • <?= esc($r['ruangan']) ?></td>
                            <td class="text-center"><?= esc($r['sks']) ?></td>
                            <td class="text-end">
                                <?php if ($r['nilai_angka'] === null) : ?>
                                    <form action="<?= site_url('/mahasiswa/krs/hapus/' . $r['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Batalkan pengambilan mata kuliah ini?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Batal</button>
                                    </form>
                                <?php else : ?>
                                    <span class="badge bg-success">Sudah Dinilai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold text-success">Daftar Kelas Tersedia untuk Diambil</div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Kode</th><th>Mata Kuliah</th><th>Kelas</th><th>Dosen</th><th>Jadwal</th><th class="text-center">SKS</th><th class="text-center">Kuota</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($kelasTersedia as $k) : ?>
                    <?php $sudah = in_array((int) $k['id'], $kelasDiambil, true); ?>
                    <tr>
                        <td><code><?= esc($k['kode_mk']) ?></code></td>
                        <td class="fw-semibold"><?= esc($k['nama_mk']) ?></td>
                        <td><span class="badge bg-secondary"><?= esc($k['nama_kelas']) ?></span></td>
                        <td class="small"><?= esc(nama_dosen_lengkap(['nama' => $k['nama_dosen'], 'gelar_depan' => $k['gelar_depan'], 'gelar_belakang' => $k['gelar_belakang']])) ?></td>
                        <td class="small"><?= esc($k['jadwal']) ?> (<?= esc($k['ruangan']) ?>)</td>
                        <td class="text-center"><?= esc($k['sks']) ?></td>
                        <td class="text-center"><?= esc($k['jumlah_peserta']) ?> / <?= esc($k['kuota']) ?></td>
                        <td class="text-end">
                            <?php if ($sudah) : ?>
                                <span class="badge bg-success">Diambil</span>
                            <?php elseif ((int) $k['jumlah_peserta'] >= (int) $k['kuota']) : ?>
                                <span class="badge bg-danger">Penuh</span>
                            <?php else : ?>
                                <form action="<?= site_url('/mahasiswa/krs/ambil') ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="kelas_id" value="<?= esc($k['id']) ?>">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus me-1"></i>Ambil
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

