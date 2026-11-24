<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h3 class="fw-bold text-primary mb-3">Tentang Latihan 1 — Pengenalan CodeIgniter 4</h3>
        <p>Aplikasi ini disusun untuk memenuhi <strong>Tugas Minggu 9</strong> mata kuliah <strong>Pemrograman Berbasis Kerangka Kerja (PBKK) Kelas D</strong>, Departemen Teknik Informatika, Institut Teknologi Sepuluh Nopember.</p>

        <div class="row g-3 my-3">
            <div class="col-md-6">
                <div class="p-3 bg-light rounded border">
                    <h6 class="fw-bold mb-2">Identitas Mahasiswa</h6>
                    <table class="table table-sm table-borderless mb-0">
                        <tr><td class="text-muted">Nama</td><td>: <strong>Farrel Prastita Ramaddhan</strong></td></tr>
                        <tr><td class="text-muted">NRP</td><td>: 5025241219</td></tr>
                        <tr><td class="text-muted">Kelas</td><td>: PBKK D</td></tr>
                        <tr><td class="text-muted">Prodi</td><td>: Teknik Informatika ITS</td></tr>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-light rounded border">
                    <h6 class="fw-bold mb-2">Topik Latihan 1 yang Diimplementasikan</h6>
                    <ol class="small mb-0 ps-3">
                        <li>Instalasi, Konfigurasi &amp; Hello World CodeIgniter 4</li>
                        <li>Fungsi Router, Placeholder, Route Group &amp; Controller</li>
                        <li>Bootstrap 5 untuk View Aplikasi Publik</li>
                        <li>Template SB Admin 2 (Layout, Section, Partial View)</li>
                        <li>Model, Validasi, Query Builder, CRUD &amp; Pagination</li>
                        <li>Penanganan File Upload (Foto Profil Mahasiswa)</li>
                        <li>Autentikasi &amp; Hak Akses User (Filter Auth &amp; Role)</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

