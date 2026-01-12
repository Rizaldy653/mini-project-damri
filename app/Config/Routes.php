<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::authenticate');
$routes->post('/logout', 'AuthController::logout'); 

$routes->get('/dashboard', 'DashboardController::index');

$routes->group('barang', ['filter' => 'permission:view_barang'], function($routes) {
    $routes->get('/', 'BarangController::index');
    $routes->get('data', 'BarangController::getData');
    $routes->post('store', 'BarangController::store');
    $routes->get('edit/(:num)', 'BarangController::edit/$1');
    $routes->post('update/(:num)', 'BarangController::update/$1');
    $routes->post('delete/(:num)', 'BarangController::delete/$1');
    $routes->get('addItem', 'BarangController::create');
});

$routes->group('user', ['filter' => 'permission:manage_users'], function($routes) {
    $routes->get('/', 'UserController::index');
    $routes->get('add', 'UserController::add');
    $routes->get('data', 'UserController::data');
    $routes->post('store', 'UserController::store');
    $routes->get('edit/(:num)', 'UserController::edit/$1');
    $routes->post('update/(:num)', 'UserController::update/$1');
});

