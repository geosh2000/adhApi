<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Registro::index');
$routes->get('logout', 'Registro::logout');

// Upload CSV
$routes->get('csv/upload', 'CsvUpload::index');
$routes->post('csv/upload', 'CsvUpload::upload');


// Rutas de logueo
$routes->group('login', function($routes){
    $routes->post('/', 'Log\Login::login', ['as' => 'login.login']);
    $routes->get('out', 'Log\Login::logout', ['as' => 'login.logout']);
    $routes->get('show', 'Log\Login::show', ['as' => 'login.show']);
});

// Rutas protegidas por BearerToken
$routes->group('auth', function($routes){
    $routes->group('log', ['filter' => 'verificarPermiso:dash_logs'], function($routes){
        $routes->get('test', 'Test::index', ['as' => 'log.test.index']);
        $routes->get('show', 'Log\Login::show', ['as' => 'log.auth.show']);
    });
    $routes->get('test', 'Test::index', ['as' => 'test.index']);
    $routes->get('show', 'Log\Login::show', ['as' => 'auth.show']);
});

// Rutas sin proteccion por BearerToken
$routes->group('test', function($routes){
    $routes->post('db', 'Test::dbs', ['as' => 'test.test.dbs']);
    $routes->get('test', 'Test::index', ['as' => 'test.test.index']);
    $routes->get('jwt', 'Test::jwt', ['as' => 'test.test.jwt']);
    $routes->get('show', 'Log\Login::show', ['as' => 'test.auth.show']);
});

// $routes->group('dashboard', ['filter' => 'DashboardFilter'], function($routes){
//     $routes->get('usuario/crear', '\App\Controllers\Web\Usuario::create_user', ['as' => 'usuario.create_user']);
//     $routes->get('usuario/test_password/(:num)', '\App\Controllers\Web\Usuario::test_password/$1', ['as' => 'usuario.test_pw']);
//     $routes->get('peliculas', 'Pelicula::index', ['as' => 'pelicula.index']);
// });
