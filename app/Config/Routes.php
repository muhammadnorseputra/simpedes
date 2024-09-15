<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $route
 */
$routes->get('/', 'Auth::index', ['filter' => 'redirectIfAuthenticated']);
$routes->get('logout', 'Auth::logout');

$routes->group('auth', ['filter' => 'redirectIfAuthenticated'], function ($routes) {
    $routes->get('/', 'Auth::index');
    $routes->post('action', 'Auth::action');
});

$routes->group('app', function($route) {
    $route->get('dashboard', 'Dashboard::index');
    
    // Nested router group /app/master
    $route->group('master', function($route) {
        // route jabatan
        $route->get('jabatan', 'Master::jabatan');
        $route->get('jabatan/edit/(:num)', 'Master::jabatan/$1');
        $route->post('jabatan', 'Master::jabatan');
        $route->put('jabatan', 'Master::jabatan');
        $route->delete('jabatan', 'Master::jabatan');
        // route pegawai
        $route->get('pegawai', 'Master::pegawai');
        $route->get('pegawai/peremajaan', 'Master::pegawai/peremajaan');
        $route->post('pegawai/peremajaan', 'Master::pegawai/peremajaan');
        $route->put('pegawai/peremajaan', 'Master::pegawai/peremajaan');
        $route->patch('pegawai/peremajaan', 'Master::pegawai/peremajaan');
        // route users
        $route->get('users', 'Master::users');
        $route->put('users/(:any)', 'Master::users/$1');
        $route->patch('users', 'Master::users');
        $route->post('users', 'Master::users');
    });

    // Nested router group /app/referensi
    $route->group('referensi', function($route) {
        $route->get('agama', 'Referensi::agama');
        $route->get('kecamatan', 'Referensi::kecamatan');
        $route->get('desa', 'Referensi::desa');
        $route->get('jenis_workshop', 'Referensi::jenis_workshop');
        $route->get('tingkat_pendidikan', 'Referensi::tingkat_pendidikan');
        $route->get('jurusan_pendidikan', 'Referensi::jurusan_pendidikan');
        $route->get('rumpun_diklat', 'Referensi::rumpun_diklat');
        // route satuan_unit_kerja
        $route->get('satuan_unit_kerja', 'Referensi::satuan_unit_kerja');
        $route->get('satuan_unit_kerja/edit/(:num)', 'Referensi::satuan_unit_kerja/edit/$1');
        $route->post('satuan_unit_kerja', 'Referensi::simpan_satuan_unit_kerja');
        $route->delete('satuan_unit_kerja', 'Referensi::hapus_satuan_unit_kerja');
        $route->put('satuan_unit_kerja', 'Referensi::update_satuan_unit_kerja');
        $route->patch('satuan_unit_kerja/(:num)', 'Referensi::update_satuan_unit_kerja/$1');
    });
});

$routes->group('datatable', function($route) {
    $route->post('agama', 'AjaxDatatable::agama');
    $route->post('kecamatan', 'AjaxDatatable::kecamatan');
    $route->post('desa', 'AjaxDatatable::desa');
    $route->post('jenis_workshop', 'AjaxDatatable::jenis_workshop');
    $route->post('tingkat_pendidikan', 'AjaxDatatable::tingkat_pendidikan');
    $route->post('jurusan_pendidikan', 'AjaxDatatable::jurusan_pendidikan');
    $route->post('rumpun_diklat', 'AjaxDatatable::rumpun_diklat');
    $route->post('satuan_unit_kerja', 'AjaxDatatable::satuan_unit_kerja');
    // Nested router group /datatable/master
    $route->group('master', function($route) {
        $route->post('jabatan', 'AjaxDatatable::jabatan');
        $route->post('pegawai', 'AjaxDatatable::pegawai');
        $route->post('users', 'AjaxDatatable::users');
    });
});

$routes->group('select2', function($route) {
    $route->post('desa', 'AjaxSelect2::desa');
    $route->post('kecamatan', 'AjaxSelect2::kecamatan');
    $route->post('unit_kerja', 'AjaxSelect2::unit_kerja');
    $route->post('atasan_jabatan', 'AjaxSelect2::atasan');
    $route->get('pegawai', 'AjaxSelect2::show_pegawai');
    $route->post('pegawai', 'AjaxSelect2::pegawai');
});