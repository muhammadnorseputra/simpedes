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
    $route->get('password', 'Master::users/ganti-password');
    
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

    // Nested router group /app/unit
    $route->group('pegawai', function($route) {
        $route->get('unit', 'Pegawai::index');
        $route->get('detail/(:any)', 'Pegawai::detail/$1');
        $route->post('unit', 'Pegawai::index');
        $route->post('search', 'Pegawai::search');
        // riwayat pendidikan
        $route->get('(:any)/pendidikan', 'Pegawai::riwayat_pendidikan/$1');
        $route->get('(:any)/pendidikan/(:any)', 'Pegawai::riwayat_pendidikan/$1/$2');
        $route->post('(:any)/pendidikan/(:any)', 'Pegawai::riwayat_pendidikan/$1/$2');
        $route->delete('(:any)/pendidikan/(:any)', 'Pegawai::riwayat_pendidikan/$1/$2');
        // riwayat jabatan
        $route->get('(:any)/jabatan', 'Pegawai::riwayat_jabatan/$1');
        $route->get('(:any)/jabatan/(:any)', 'Pegawai::riwayat_jabatan/$1/$2');
        $route->post('(:any)/jabatan/(:any)', 'Pegawai::riwayat_jabatan/$1/$2');
        $route->delete('(:any)/jabatan/(:any)', 'Pegawai::riwayat_jabatan/$1/$2');
        // riwayat keluarga
        $route->get('(:any)/keluarga', 'Pegawai::riwayat_keluarga/$1');
        $route->get('(:any)/keluarga/(:any)/(:any)', 'Pegawai::riwayat_keluarga/$1/$2/$3');
        $route->get('(:any)/keluarga/(:any)/edit/(:any)', 'Pegawai::riwayat_keluarga/$1/$2/$3');
        $route->post('(:any)/keluarga/(:any)/(:any)', 'Pegawai::riwayat_keluarga/$1/$2/$3');
        $route->put('(:any)/keluarga/(:any)/(:any)', 'Pegawai::riwayat_keluarga/$1/$2/$3');
        $route->patch('(:any)/keluarga/(:any)/(:any)', 'Pegawai::riwayat_keluarga/$1/$2/$3');
        $route->delete('(:any)/keluarga/(:any)/(:any)', 'Pegawai::riwayat_keluarga/$1/$2/$3');
        // Riwayat Workshop
        $route->get('(:any)/workshop', 'Pegawai::riwayat_workshop/$1');
        $route->get('(:any)/workshop/(:any)', 'Pegawai::riwayat_workshop/$1/$2');
        $route->post('(:any)/workshop/(:any)', 'Pegawai::riwayat_workshop/$1/$2');
        $route->delete('(:any)/workshop/(:any)', 'Pegawai::riwayat_workshop/$1/$2');
        // Riwayat LHKPN
        $route->get('(:any)/lhkpn', 'Pegawai::riwayat_lhkpn/$1');
        $route->get('(:any)/lhkpn/(:any)', 'Pegawai::riwayat_lhkpn/$1/$2');
        $route->post('(:any)/lhkpn/(:any)', 'Pegawai::riwayat_lhkpn/$1/$2');
        $route->delete('(:any)/lhkpn/(:any)', 'Pegawai::riwayat_lhkpn/$1/$2');
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
    // Nested router group /datatable/riwayat
    $route->group('riwayat', function($route) {
        $route->post('pendidikan', 'AjaxDatatable::riwayat_pendidikan');
        $route->post('jabatan', 'AjaxDatatable::riwayat_jabatan');
        $route->post('keluarga/sutri', 'AjaxDatatable::riwayat_keluarga_sutri');
        $route->post('keluarga/anak', 'AjaxDatatable::riwayat_keluarga_anak');
        $route->post('workshop', 'AjaxDatatable::riwayat_workshop');
        $route->post('lhkpn', 'AjaxDatatable::riwayat_lhkpn');
    });
    // Nested router group /datatable/tunjangan
    $route->group('tunjangan', function($route) {
        $route->post('hitung', 'AjaxDatatable::hitung_tunjangan');
    });
});

$routes->group('select2', function($route) {
    $route->post('desa', 'AjaxSelect2::desa');
    $route->post('kecamatan', 'AjaxSelect2::kecamatan');
    $route->post('unit_kerja', 'AjaxSelect2::unit_kerja');
    $route->post('unit_kerja_list', 'AjaxSelect2::unit_kerja_list');
    $route->post('atasan_jabatan', 'AjaxSelect2::atasan');
    $route->get('pegawai', 'AjaxSelect2::show_pegawai');
    $route->post('pegawai', 'AjaxSelect2::pegawai');
    $route->post('tingkat_pendidikan', 'AjaxSelect2::tingkat_pendidikan');
    $route->post('jurusan_pendidikan', 'AjaxSelect2::jurusan_pendidikan');
    $route->post('jenis_workshop', 'AjaxSelect2::jenis_workshop');
    $route->post('rumpun_diklat', 'AjaxSelect2::rumpun_diklat');
});

$routes->group('cetak', function($route) {
    $route->get('profile/(:any)', 'Pdf::index/$1');
});

$routes->group('pembayaran', function($route) {
    
    $route->get('tunjangan', 'Pembayaran::tunjangan');
    $route->post('tunjangan/filter', 'Pembayaran::filter');

    $route->get('hitung', 'Pembayaran::hitung');
    $route->post('hitung', 'Pembayaran::hitung');
    $route->delete('hitung', 'Pembayaran::hitung');

    $route->post('cetak', 'Pdf::cetak_tt_tunjangan');
});

$routes->group('nominatif', function($route) {
    $route->post('cetak', 'Pdf::cetak_nomperunker');
});