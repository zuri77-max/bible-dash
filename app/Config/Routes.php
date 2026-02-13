<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Debug route - remove after testing
$routes->get('css-test', 'CssTest::index');
$routes->get('setup/bibles', 'SetupController::createBiblesTable');

// Shield Auth Routes
service('auth')->routes($routes);

// Admin Routes - Protected by Shield
$routes->group('admin', ['filter' => 'group:admin'], function($routes) {
    $routes->get('/', 'Admin\\Dashboard::index');
    $routes->get('bibles', 'Admin\\BibleManageController::index');
    $routes->get('bibles/delete/(:num)', 'Admin\\BibleManageController::delete/$1');
    $routes->post('bibles/toggle-status/(:num)', 'Admin\\BibleManageController::toggleStatus/$1');
    $routes->post('bibles/update/(:num)', 'Admin\\BibleManageController::update/$1');
    $routes->get('bibleupload', 'Admin\\BibleUpload::index');
    $routes->post('bibleupload/upload', 'Admin\\BibleUpload::upload');
    $routes->get('generate-token', 'Admin\\TokenController::index');
    $routes->post('generate-token', 'Admin\\TokenController::generate');
});

// API Auth Routes (No authentication required)
$routes->group('api/auth', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->post('token', 'AuthController::generateToken');
    $routes->post('revoke', 'AuthController::revokeToken', ['filter' => 'tokens']);
    $routes->get('me', 'AuthController::me', ['filter' => 'tokens']);
});

// API Routes v1 - Protected by Bearer Token (Admin Only)
$routes->group('api/v1', ['filter' => 'tokens', 'namespace' => 'App\Controllers\Api\V1'], function($routes) {
    // Bible Management
    $routes->get('bibles', 'BibleController::index');
    $routes->get('bibles/languages', 'BibleController::languages');
    $routes->get('bibles/check-updates', 'BibleController::checkUpdates');
    $routes->get('bibles/(:num)', 'BibleController::show/$1');
    $routes->get('bibles/(:num)/file-info', 'BibleController::fileInfo/$1');
    $routes->get('bibles/(:num)/download', 'BibleController::download/$1');
});
