<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Halaman Utama & Publik (Bootstrap 5)
$routes->get('/', 'Home::index');
$routes->get('/tentang', 'Home::about');

// Demonstrasi Hello World, Routing & Placeholder
$routes->get('/hello', 'HelloController::index');
$routes->get('/hello/(:segment)', 'HelloController::sapa/$1');

// Biodata Publik (Read-Only + Pencarian & Pagination)
$routes->get('/biodata', 'BiodataController::index');
$routes->get('/biodata/(:segment)', 'BiodataController::detail/$1');

// Autentikasi User
$routes->get('/login', 'AuthController::loginForm');
$routes->post('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::registerForm');
$routes->post('/register', 'AuthController::register');
$routes->post('/logout', 'AuthController::logout', ['filter' => 'auth']);

// Halaman Profil User Login (Semua Role)
$routes->get('/profil', 'ProfilController::index', ['filter' => 'auth']);

// Route Group Panel Admin (SB Admin 2) — Hanya Role Admin
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => ['auth', 'role:admin']], static function ($routes) {
    $routes->get('/', 'DashboardController::index');
    $routes->get('mahasiswa', 'MahasiswaController::index');
    $routes->get('mahasiswa/create', 'MahasiswaController::create');
    $routes->post('mahasiswa/store', 'MahasiswaController::store');
    $routes->get('mahasiswa/edit/(:num)', 'MahasiswaController::edit/$1');
    $routes->post('mahasiswa/update/(:num)', 'MahasiswaController::update/$1');
    $routes->post('mahasiswa/delete/(:num)', 'MahasiswaController::delete/$1');

    $routes->get('users', 'UserController::index');
    $routes->post('users/toggle-role/(:num)', 'UserController::toggleRole/$1');
});
