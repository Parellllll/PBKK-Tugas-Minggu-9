<?php
$uri  = service('uri')->getPath();
$role = $roleAktif ?? session()->get('user_role');
?>
<aside class="sidebar">
    <a class="sidebar-brand" href="<?= site_url('/' . $role) ?>">
        <i class="fas fa-university fa-lg"></i>
        <div>
            <div class="lh-1">SIAKAD CI4</div>
            <small class="fw-normal opacity-75" style="font-size:.7rem;">Portal <?= esc(ucfirst((string) $role)) ?></small>
        </div>
    </a>

    <?php if ($role === 'admin') : ?>
        <div class="sidebar-heading">Administrator</div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link <?= $uri === 'admin' ? 'active' : '' ?>" href="<?= site_url('/admin') ?>"><i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</a></li>
        </ul>
        <div class="sidebar-heading">Master Data</div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link <?= str_contains($uri, 'master/prodi') ? 'active' : '' ?>" href="<?= site_url('/admin/master/prodi') ?>"><i class="fas fa-building fa-fw"></i> Program Studi</a></li>
            <li class="nav-item"><a class="nav-link <?= str_contains($uri, 'master/tahun-akademik') ? 'active' : '' ?>" href="<?= site_url('/admin/master/tahun-akademik') ?>"><i class="fas fa-calendar-alt fa-fw"></i> Tahun Akademik</a></li>
            <li class="nav-item"><a class="nav-link <?= str_contains($uri, 'master/dosen') ? 'active' : '' ?>" href="<?= site_url('/admin/master/dosen') ?>"><i class="fas fa-chalkboard-teacher fa-fw"></i> Data Dosen</a></li>
            <li class="nav-item"><a class="nav-link <?= str_contains($uri, 'master/mahasiswa') ? 'active' : '' ?>" href="<?= site_url('/admin/master/mahasiswa') ?>"><i class="fas fa-user-graduate fa-fw"></i> Data Mahasiswa</a></li>
            <li class="nav-item"><a class="nav-link <?= str_contains($uri, 'master/matakuliah') ? 'active' : '' ?>" href="<?= site_url('/admin/master/matakuliah') ?>"><i class="fas fa-book fa-fw"></i> Mata Kuliah</a></li>
            <li class="nav-item"><a class="nav-link <?= str_contains($uri, 'master/kelas') ? 'active' : '' ?>" href="<?= site_url('/admin/master/kelas') ?>"><i class="fas fa-door-open fa-fw"></i> Kelas &amp; Jadwal</a></li>
        </ul>
    <?php elseif ($role === 'dosen') : ?>
        <div class="sidebar-heading">Portal Dosen</div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link <?= $uri === 'dosen' ? 'active' : '' ?>" href="<?= site_url('/dosen') ?>"><i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link <?= str_starts_with($uri, 'dosen/kelas') ? 'active' : '' ?>" href="<?= site_url('/dosen/kelas') ?>"><i class="fas fa-clipboard-check fa-fw"></i> Kelas &amp; Input Nilai</a></li>
        </ul>
    <?php elseif ($role === 'mahasiswa') : ?>
        <div class="sidebar-heading">Portal Mahasiswa</div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link <?= $uri === 'mahasiswa' ? 'active' : '' ?>" href="<?= site_url('/mahasiswa') ?>"><i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link <?= str_starts_with($uri, 'mahasiswa/krs') ? 'active' : '' ?>" href="<?= site_url('/mahasiswa/krs') ?>"><i class="fas fa-edit fa-fw"></i> Isi KRS</a></li>
            <li class="nav-item"><a class="nav-link <?= str_starts_with($uri, 'mahasiswa/khs') ? 'active' : '' ?>" href="<?= site_url('/mahasiswa/khs') ?>"><i class="fas fa-file-alt fa-fw"></i> Kartu Hasil Studi</a></li>
            <li class="nav-item"><a class="nav-link <?= str_starts_with($uri, 'mahasiswa/transkrip') ? 'active' : '' ?>" href="<?= site_url('/mahasiswa/transkrip') ?>"><i class="fas fa-award fa-fw"></i> Transkrip &amp; IPK</a></li>
        </ul>
    <?php endif; ?>
</aside>

