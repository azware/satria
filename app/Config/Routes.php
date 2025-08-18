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
    $routes->get('/', 'Departemen::index');
    $routes->get('ajax_list', 'Departemen::ajax_list');
    $routes->get('ajax_edit/(:num)', 'Departemen::ajax_edit/$1');
    $routes->post('ajax_save', 'Departemen::ajax_save');
    $routes->delete('ajax_delete/(:num)', 'Departemen::ajax_delete/$1');
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

