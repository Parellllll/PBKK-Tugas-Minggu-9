<?= $this->extend('layouts/sbadmin') ?>
<?= $this->section('content') ?>

<h4 class="fw-bold mb-3">Daftar Kelas &amp; Input Nilai</h4>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Tahun Akademik</th><th>Kode MK</th><th>Mata Kuliah</th><th>Kelas</th><th>Jadwal</th><th>Peserta</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($kelas as $k) : ?>
                    <tr>
                        <td><span class="badge <?= (int) $k['is_aktif'] === 1 ? 'bg-success' : 'bg-secondary' ?>"><?= esc($k['nama_ta']) ?></span></td>
                        <td><code><?= esc($k['kode_mk']) ?></code></td>
                        <td class="fw-semibold"><?= esc($k['nama_mk']) ?> (<?= esc($k['sks']) ?> SKS)</td>
                        <td><span class="badge bg-primary"><?= esc($k['nama_kelas']) ?></span></td>
                        <td class="small"><?= esc($k['jadwal']) ?> • <?= esc($k['ruangan']) ?></td>
                        <td><?= esc($k['jumlah_peserta']) ?> / <?= esc($k['kuota']) ?></td>
                        <td class="text-end">
                            <a href="<?= site_url('/dosen/kelas/' . $k['id'] . '/nilai') ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-clipboard-check me-1"></i>Kelola Nilai
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

