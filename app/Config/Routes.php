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
});

