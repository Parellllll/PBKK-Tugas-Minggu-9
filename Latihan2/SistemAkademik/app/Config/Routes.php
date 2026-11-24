<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Root redirect sesuai status login / role
$routes->get('/', 'AuthController::redirectHome');
$routes->get('/login', 'AuthController::loginForm');
$routes->post('/login', 'AuthController::login');
$routes->post('/logout', 'AuthController::logout', ['filter' => 'auth']);

// Route Group Admin (bersarang + namespace)
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => ['auth', 'role:admin']], static function ($routes) {
    $routes->get('/', 'DashboardController::index');

    $routes->group('master', static function ($routes) {
        // Prodi
        $routes->get('prodi', 'ProdiController::index');
        $routes->post('prodi/store', 'ProdiController::store');
        $routes->post('prodi/delete/(:num)', 'ProdiController::delete/$1');

        // Tahun Akademik
        $routes->get('tahun-akademik', 'TahunAkademikController::index');
        $routes->post('tahun-akademik/store', 'TahunAkademikController::store');
        $routes->post('tahun-akademik/aktifkan/(:num)', 'TahunAkademikController::aktifkan/$1');

        // Dosen
        $routes->get('dosen', 'DosenController::index');
        $routes->get('dosen/create', 'DosenController::create');
        $routes->post('dosen/store', 'DosenController::store');
        $routes->post('dosen/delete/(:num)', 'DosenController::delete/$1');

        // Mahasiswa
        $routes->get('mahasiswa', 'MahasiswaController::index');
        $routes->get('mahasiswa/create', 'MahasiswaController::create');
        $routes->post('mahasiswa/store', 'MahasiswaController::store');
        $routes->post('mahasiswa/delete/(:num)', 'MahasiswaController::delete/$1');

        // Mata Kuliah
        $routes->get('matakuliah', 'MataKuliahController::index');
        $routes->post('matakuliah/store', 'MataKuliahController::store');
        $routes->post('matakuliah/delete/(:num)', 'MataKuliahController::delete/$1');

        // Kelas / Jadwal
        $routes->get('kelas', 'KelasController::index');
        $routes->post('kelas/store', 'KelasController::store');
        $routes->post('kelas/delete/(:num)', 'KelasController::delete/$1');
    });
});

// Route Group Dosen (namespace + role:dosen)
$routes->group('dosen', ['namespace' => 'App\Controllers\Dosen', 'filter' => ['auth', 'role:dosen']], static function ($routes) {
    $routes->get('/', 'DashboardController::index');
    $routes->get('kelas', 'NilaiController::daftarKelas');
    $routes->get('kelas/(:num)/nilai', 'NilaiController::formNilai/$1');
    $routes->post('kelas/(:num)/nilai', 'NilaiController::simpanNilai/$1');
});

// Route Group Mahasiswa (namespace + role:mahasiswa)
$routes->group('mahasiswa', ['namespace' => 'App\Controllers\Mahasiswa', 'filter' => ['auth', 'role:mahasiswa']], static function ($routes) {
    $routes->get('/', 'DashboardController::index');
    $routes->get('krs', 'KrsController::index');
    $routes->post('krs/ambil', 'KrsController::ambil');
    $routes->post('krs/hapus/(:num)', 'KrsController::hapus/$1');
    $routes->get('khs', 'KhsController::index');
    $routes->get('transkrip', 'KhsController::transkrip');
});
