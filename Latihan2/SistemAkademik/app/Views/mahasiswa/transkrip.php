<?= $this->extend('layouts/sbadmin') ?>
<?= $this->section('content') ?>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h4 class="fw-bold text-primary mb-1">Transkrip Akademik Sementara</h4>
            <div class="small text-muted">
                <strong><?= esc($mahasiswa['nama'] ?? '-') ?></strong> (NRP <?= esc($mahasiswa['nrp'] ?? '-') ?>) • <?= esc($mahasiswa['nama_prodi'] ?? '-') ?>
            </div>
        </div>
        <div class="text-end">
            <div class="small text-muted">Indeks Prestasi Kumulatif (IPK)</div>
            <div class="h3 fw-bold text-success mb-0"><?= number_format($ipkSummary['ips_atau_ipk'], 2) ?></div>
            <span class="badge bg-success-subtle text-success"><?= esc(predikat_ipk($ipkSummary['ips_atau_ipk'])) ?></span>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Semester</th>
                    <th>Kode</th>
                    <th>Mata Kuliah</th>
                    <th class="text-center">SKS</th>
                    <th class="text-center">Nilai Angka</th>
                    <th class="text-center">Huruf</th>
                    <th class="text-center">Bobot</th>
                    <th class="text-center">Mutu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($semuaKrs as $row) : ?>
                    <?php $mutu = $row['bobot'] !== null ? (float) $row['bobot'] * (int) $row['sks'] : null; ?>
                    <tr>
                        <td class="small"><?= esc($row['nama_ta']) ?></td>
                        <td><code><?= esc($row['kode_mk']) ?></code></td>
                        <td class="fw-semibold"><?= esc($row['nama_mk']) ?></td>
                        <td class="text-center"><?= esc($row['sks']) ?></td>
                        <td class="text-center"><?= $row['nilai_angka'] !== null ? number_format((float) $row['nilai_angka'], 2) : '-' ?></td>
                        <td class="text-center">
                            <?php if ($row['nilai_huruf']) : ?>
                                <span class="badge <?= badge_nilai($row['nilai_huruf']) ?>"><?= esc($row['nilai_huruf']) ?></span>
                            <?php else : ?>
                                <span class="badge bg-light text-muted border">Berjalan</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center"><?= $row['bobot'] !== null ? number_format((float) $row['bobot'], 2) : '-' ?></td>
                        <td class="text-center fw-semibold"><?= $mutu !== null ? number_format($mutu, 2) : '-' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="table-light fw-bold">
                <tr>
                    <td colspan="3" class="text-end">Total Kumulatif Dinilai</td>
                    <td class="text-center"><?= esc($ipkSummary['sks_dinilai']) ?> SKS</td>
                    <td colspan="3" class="text-end">IPK = <?= number_format($ipkSummary['total_mutu'], 2) ?> / <?= max(1, $ipkSummary['sks_dinilai']) ?> =</td>
                    <td class="text-center text-success"><?= number_format($ipkSummary['ips_atau_ipk'], 2) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

