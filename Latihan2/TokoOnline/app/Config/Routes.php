<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Storefront Publik (Bootstrap 5)
$routes->get('/', 'KatalogController::index');
$routes->get('/produk/(:segment)', 'KatalogController::detail/$1');

// Keranjang Belanja (Session-based via CartLibrary)
$routes->get('/keranjang', 'KeranjangController::index');
$routes->post('/keranjang/tambah', 'KeranjangController::tambah');
$routes->post('/keranjang/ubah', 'KeranjangController::ubah');
$routes->post('/keranjang/hapus/(:num)', 'KeranjangController::hapus/$1');
$routes->post('/keranjang/kosongkan', 'KeranjangController::kosongkan');

// Autentikasi
$routes->get('/login', 'AuthController::loginForm');
$routes->post('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::registerForm');
$routes->post('/register', 'AuthController::register');
$routes->post('/logout', 'AuthController::logout', ['filter' => 'auth']);

// Checkout & Riwayat Pesanan (Wajib Login — otomatis redirect kembali setelah login!)
$routes->get('/checkout', 'CheckoutController::index', ['filter' => 'auth']);
$routes->post('/checkout/proses', 'CheckoutController::proses', ['filter' => 'auth']);
$routes->get('/pesanan', 'PesananController::index', ['filter' => 'auth']);
$routes->get('/pesanan/(:segment)', 'PesananController::detail/$1', ['filter' => 'auth']);

// Panel Admin (SB Admin 2 — Khusus Role Admin)
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => ['auth', 'role:admin']], static function ($routes) {
    $routes->get('/', 'DashboardController::index');

    $routes->get('kategori', 'KategoriController::index');
    $routes->post('kategori/store', 'KategoriController::store');
    $routes->post('kategori/delete/(:num)', 'KategoriController::delete/$1');

    $routes->get('produk', 'ProdukController::index');
    $routes->get('produk/create', 'ProdukController::create');
    $routes->post('produk/store', 'ProdukController::store');
    $routes->get('produk/edit/(:num)', 'ProdukController::edit/$1');
    $routes->post('produk/update/(:num)', 'ProdukController::update/$1');
    $routes->post('produk/delete/(:num)', 'ProdukController::delete/$1');

    $routes->get('pesanan', 'PesananController::index');
    $routes->get('pesanan/(:segment)', 'PesananController::detail/$1');
    $routes->post('pesanan/(:num)/status', 'PesananController::ubahStatus/$1');
});
