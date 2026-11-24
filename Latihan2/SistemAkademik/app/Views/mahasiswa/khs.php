<?= $this->extend('layouts/sbadmin') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h4 class="fw-bold mb-0">Kartu Hasil Studi (KHS)</h4>
    <form method="get" class="d-flex align-items-center gap-2">
        <label class="small fw-semibold mb-0">Semester:</label>
        <select name="ta" class="form-select form-select-sm" onchange="this.form.submit()">
            <?php foreach ($semuaTa as $ta) : ?>
                <option value="<?= esc($ta['id']) ?>" <?= (int) $ta['id'] === $selectedTaId ? 'selected' : '' ?>>
                    <?= esc($ta['nama']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm border-left-primary">
            <div class="card-body">
                <div class="small fw-bold text-primary text-uppercase">IPS Semester Ini</div>
                <div class="h3 fw-bold mb-0"><?= number_format($ipsSummary['ips_atau_ipk'], 2) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm border-left-success">
            <div class="card-body">
                <div class="small fw-bold text-success text-uppercase">IPK Kumulatif</div>
                <div class="h3 fw-bold mb-0"><?= number_format($ipkSummary['ips_atau_ipk'], 2) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm border-left-info">
            <div class="card-body">
                <div class="small fw-bold text-info text-uppercase">SKS Semester Ini</div>
                <div class="h3 fw-bold mb-0"><?= esc($ipsSummary['sks_diambil']) ?> SKS <small class="fs-6 text-muted">(<?= esc($ipsSummary['sks_dinilai']) ?> dinilai)</small></div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Mata Kuliah</th>
                    <th class="text-center">SKS</th>
                    <th class="text-center">Nilai Angka</th>
                    <th class="text-center">Huruf</th>
                    <th class="text-center">Bobot</th>
                    <th class="text-center">Mutu (SKS &times; Bobot)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarNilai)) : ?>
                    <tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada data studi pada semester terpilih.</td></tr>
                <?php else : ?>
                    <?php foreach ($daftarNilai as $n) : ?>
                        <?php $mutu = $n['bobot'] !== null ? (float) $n['bobot'] * (int) $n['sks'] : null; ?>
                        <tr>
                            <td><code><?= esc($n['kode_mk']) ?></code></td>
                            <td class="fw-semibold"><?= esc($n['nama_mk']) ?></td>
                            <td class="text-center"><?= esc($n['sks']) ?></td>
                            <td class="text-center"><?= $n['nilai_angka'] !== null ? number_format((float) $n['nilai_angka'], 2) : '-' ?></td>
                            <td class="text-center">
                                <?php if ($n['nilai_huruf']) : ?>
                                    <span class="badge <?= badge_nilai($n['nilai_huruf']) ?>"><?= esc($n['nilai_huruf']) ?></span>
                                <?php else : ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center"><?= $n['bobot'] !== null ? number_format((float) $n['bobot'], 2) : '-' ?></td>
                            <td class="text-center fw-semibold"><?= $mutu !== null ? number_format($mutu, 2) : '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

