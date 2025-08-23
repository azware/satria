<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

// Route untuk memuat kerangka/template utama
$routes->get('/', 'Home::template');

// Route untuk AJAX dashboard
$routes->get('/dashboard', 'Dashboard::index');

// Routes untuk AJAX
$routes->group('pegawai', function ($routes) {
    $routes->get('/', 'Pegawai::index');
    $routes->get('ajax_list', 'Pegawai::ajax_list');
    $routes->get('ajax_edit/(:num)', 'Pegawai::ajax_edit/$1');
    $routes->post('ajax_save', 'Pegawai::ajax_save');
    $routes->delete('ajax_delete/(:num)', 'Pegawai::ajax_delete/$1');
});

// Routes untuk Departemen
$routes->group('departemen', function ($routes) {
    $routes->get('/', 'Departemen::index'); // <-- Untuk menampilkan halaman utama
    $routes->get('ajax_list', 'Departemen::ajax_list'); // <-- Untuk mengambil data tabel
    $routes->get('ajax_edit/(:num)', 'Departemen::ajax_edit/$1'); // <-- Untuk mengambil data edit
    $routes->post('ajax_save', 'Departemen::ajax_save'); // <-- Untuk menyimpan data (tambah/edit)
    $routes->delete('ajax_delete/(:num)', 'Departemen::ajax_delete/$1'); // <-- Untuk menghapus data
});

// Routes untuk Divisi
$routes->group('divisi', function ($routes) {
    $routes->get('/', 'Divisi::index');
    $routes->get('ajax_list', 'Divisi::ajax_list');
    $routes->get('ajax_edit/(:num)', 'Divisi::ajax_edit/$1');
    $routes->post('ajax_save', 'Divisi::ajax_save');
    $routes->delete('ajax_delete/(:num)', 'Divisi::ajax_delete/$1');
});

// Routes untuk Jabatan
$routes->group('jabatan', function ($routes) {
    $routes->get('/', 'Jabatan::index');
    $routes->get('ajax_list', 'Jabatan::ajax_list');
    $routes->get('ajax_edit/(:num)', 'Jabatan::ajax_edit/$1');
    $routes->post('ajax_save', 'Jabatan::ajax_save');
    $routes->delete('ajax_delete/(:num)', 'Jabatan::ajax_delete/$1');
});

//$routes->get('/test-db', 'TestDB::index');

