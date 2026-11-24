<?= $this->extend('layouts/sbadmin') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold text-primary">Buka Kelas Baru</div>
            <div class="card-body">
                <form action="<?= site_url('/admin/master/kelas/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Tahun Akademik</label>
                        <select name="tahun_akademik_id" class="form-select" required>
                            <?php foreach ($tahunAkademik as $ta) : ?>
                                <option value="<?= esc($ta['id']) ?>" <?= (int) $ta['is_aktif'] === 1 ? 'selected' : '' ?>><?= esc($ta['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Mata Kuliah</label>
                        <select name="mata_kuliah_id" class="form-select" required>
                            <?php foreach ($matakuliah as $mk) : ?>
                                <option value="<?= esc($mk['id']) ?>"><?= esc($mk['kode'] . ' — ' . $mk['nama'] . ' (' . $mk['sks'] . ' SKS)') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Dosen Pengampu</label>
                        <select name="dosen_id" class="form-select" required>
                            <?php foreach ($dosen as $d) : ?>
                                <option value="<?= esc($d['id']) ?>"><?= esc(nama_dosen_lengkap($d)) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label class="form-label small fw-semibold">Nama Kelas</label><input type="text" name="nama_kelas" class="form-control" placeholder="PBKK-E" required></div>
                        <div class="col-6"><label class="form-label small fw-semibold">Kuota</label><input type="number" name="kuota" value="40" min="5" max="200" class="form-control" required></div>
                    </div>
                    <div class="mb-2"><label class="form-label small fw-semibold">Jadwal</label><input type="text" name="jadwal" class="form-control" placeholder="Selasa 10:00-12:30" required></div>
                    <div class="mb-3"><label class="form-label small fw-semibold">Ruangan</label><input type="text" name="ruangan" class="form-control" placeholder="IF-105" required></div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Kelas</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold text-primary">Daftar Kelas &amp; Jadwal</div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr><th>TA</th><th>Mata Kuliah</th><th>Kelas</th><th>Dosen</th><th>Jadwal</th><th>Peserta</th><th class="text-end">Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kelas as $k) : ?>
                            <tr>
                                <td><span class="badge <?= (int) $k['is_aktif'] === 1 ? 'bg-success' : 'bg-secondary' ?>"><?= esc($k['nama_ta']) ?></span></td>
                                <td>
                                    <div class="fw-semibold"><?= esc($k['nama_mk']) ?></div>
                                    <small class="text-muted"><?= esc($k['kode_mk']) ?> • <?= esc($k['sks']) ?> SKS</small>
                                </td>
                                <td><strong><?= esc($k['nama_kelas']) ?></strong></td>
                                <td><?= esc($k['nama_dosen']) ?></td>
                                <td><?= esc($k['jadwal']) ?><br><span class="text-muted"><?= esc($k['ruangan']) ?></span></td>
                                <td><?= esc($k['jumlah_peserta']) ?>/<?= esc($k['kuota']) ?></td>
                                <td class="text-end">
                                    <form action="<?= site_url('/admin/master/kelas/delete/' . $k['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus kelas ini?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

