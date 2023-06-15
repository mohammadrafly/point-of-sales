<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'AuthController::index');
$routes->post('login', 'AuthController::Login');
$routes->group('dashboard', ['filter' => 'auth'],function ($routes) {
    $routes->get('logout', 'DashboardController::Logout');
    $routes->get('/', 'DashboardController::index');
    $routes->match(['POST', 'GET'], 'profile-toko','DashboardController::profileToko');

    $routes->group('items', function ($routes) {
        $routes->match(['POST', 'GET'], '/', 'ItemController::index');
        $routes->get('delete/(:num)', 'ItemController::delete/$1');
        $routes->match(['POST', 'GET'], 'update/(:num)', 'ItemController::update/$1');
    });

    $routes->group('pembelian', function ($routes) {
        $routes->match(['POST', 'GET'], 'list/(:any)', 'PembelianController::index/$1');
        $routes->get('detail/(:num)', 'PembelianController::detail/$1');
        $routes->get('delete/(:num)', 'PembelianController::delete/$1');
    });

    $routes->group('customer', function ($routes) {
        $routes->match(['POST', 'GET'], '/', 'UserController::index');
        $routes->get('delete/(:num)', 'UserController::delete/$1');
        $routes->match(['POST', 'GET'], 'update/(:num)', 'UserController::update/$1');
    });

    $routes->group('kasir', function ($routes) {
        $routes->match(['POST', 'GET'], '/', 'UserController::indexKasir');
        $routes->get('delete/(:num)', 'UserController::deleteKasir/$1');
        $routes->match(['POST', 'GET'], 'update/(:num)', 'UserController::updateKasir/$1');
    });

    $routes->group('admin', function ($routes) {
        $routes->match(['POST', 'GET'], '/', 'UserController::indexAdmin');
        $routes->get('delete/(:num)', 'UserController::deleteAdmin/$1');
        $routes->match(['POST', 'GET'], 'update/(:num)', 'UserController::updateAdmin/$1');
    });

    $routes->group('hutang/supplier', function ($routes) {
        $routes->match(['POST', 'GET'], '/', 'HutangController::index');
        $routes->get('delete/(:num)', 'HutangController::delete/$1');
        $routes->get('details/(:any)', 'HutangController::details/$1');
        $routes->post('bayar/(:num)', 'HutangController::bayar/$1');
    });

    $routes->group('transaksi', function ($routes) {
        $routes->get('type/tunai', 'TransaksiController::index');
        $routes->get('type/hutang', 'TransaksiController::indexHutang');
        $routes->get('details/(:any)', 'TransaksiController::details/$1');
        $routes->post('bayar/(:any)', 'TransaksiController::bayarHutang/$1');
        $routes->get('delete/(:any)', 'TransactionController::delete/$1');
        $routes->match(['POST', 'GET'], 'update/(:num)', 'TransactionController::update/$1');
    });

    $routes->group('export', function ($routes) {
        $routes->post('tunai', 'TransaksiController::exportTunai');
        $routes->post('piutang', 'TransaksiController::exportHutang');
        $routes->post('hutang', 'HutangController::exportHutang');
    });

    $routes->group('transaction', function ($routes) {
        $routes->match(['POST', 'GET'], '/', 'TransactionController::index');
    });
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
