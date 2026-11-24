<?= $this->extend('layouts/sbadmin') ?>
<?= $this->section('content') ?>

<a href="<?= site_url('/dosen/kelas') ?>" class="btn btn-outline-secondary btn-sm mb-3">&larr; Kembali ke Daftar Kelas</a>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h5 class="fw-bold text-primary mb-1"><?= esc($kelas['kode_mk'] . ' — ' . $kelas['nama_mk']) ?></h5>
            <div class="small text-muted">
                Kelas <strong><?= esc($kelas['nama_kelas']) ?></strong> • <?= esc($kelas['sks']) ?> SKS • <?= esc($kelas['jadwal']) ?> (<?= esc($kelas['ruangan']) ?>) • <?= esc($kelas['nama_ta']) ?>
            </div>
        </div>
        <div class="small bg-light border rounded px-3 py-2">
            <strong>Skala ITS:</strong> A (&ge;86), AB (&ge;76), B (&ge;66), BC (&ge;61), C (&ge;56), D (&ge;41), E (&lt;41)
        </div>
    </div>
</div>

<form action="<?= site_url('/dosen/kelas/' . $kelas['id'] . '/nilai') ?>" method="post" class="card border-0 shadow-sm">
    <?= csrf_field() ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>NRP</th>
                    <th>Nama Mahasiswa</th>
                    <th>Prodi</th>
                    <th style="width:160px;">Nilai Angka (0-100)</th>
                    <th class="text-center">Huruf Mutu</th>
                    <th class="text-center">Bobot</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($peserta)) : ?>
                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada mahasiswa mengambil kelas ini.</td></tr>
                <?php else : ?>
                    <?php foreach ($peserta as $p) : ?>
                        <tr>
                            <td><code><?= esc($p['nrp']) ?></code></td>
                            <td class="fw-semibold"><?= esc($p['nama_mahasiswa']) ?></td>
                            <td class="small"><?= esc($p['nama_prodi']) ?></td>
                            <td>
                                <input type="number" step="0.01" min="0" max="100"
                                       name="nilai[<?= esc($p['id']) ?>]"
                                       value="<?= esc($p['nilai_angka'] ?? '') ?>"
                                       class="form-control form-control-sm" placeholder="0 - 100">
                            </td>
                            <td class="text-center">
                                <?php if ($p['nilai_huruf']) : ?>
                                    <span class="badge <?= badge_nilai($p['nilai_huruf']) ?>"><?= esc($p['nilai_huruf']) ?></span>
                                <?php else : ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center"><?= $p['bobot'] !== null ? number_format((float) $p['bobot'], 2) : '-' ?></td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border text-uppercase"><?= esc($p['status']) ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (! empty($peserta)) : ?>
        <div class="card-footer bg-white d-flex justify-content-end">
            <button type="submit" class="btn btn-primary fw-semibold">
                <i class="fas fa-save me-1"></i>Simpan &amp; Konversi Nilai Otomatis
            </button>
        </div>
    <?php endif; ?>
</form>

<?= $this->endSection() ?>

