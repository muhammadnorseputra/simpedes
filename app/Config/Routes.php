<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('auth', static function ($routes) {
    $routes->get('/', 'Auth::index');
});


