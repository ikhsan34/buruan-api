<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
// $routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index', ['filter' => 'auth']);

/*
 * --------------------------------------------------------------------
 * API
 * --------------------------------------------------------------------
 */
// $routes->resource();
$routes->add('register', 'API/User::register');
$routes->add('login', 'API/User::login');
$routes->post('reGenToken', 'API/Token::reGenToken');

// $routes->resource('API/Client'); // Equivalent to the following:
$routes->get('client', 'Client::index', ['filter' => 'auth']);
$routes->post('client', 'Client::store', ['filter' => 'auth']);
$routes->get('client/(:num)', 'Client::show/$1', ['filter' => 'auth']);
$routes->put('client/(:num)', 'Client::update/$1', ['filter' => 'auth']);
$routes->delete('client/(:num)', 'Client::destroy/$1', ['filter' => 'auth']);

// Reminder
$routes->post('reminder', 'Client::insertReminder', ['filter' => 'auth']);
$routes->get('reminder', 'Client::showReminder');
$routes->get('reminder/user/(:num)', 'Client::showReminderByUserId/$1', ['filter' => 'auth']);
$routes->get('reminder/group/(:num)', 'Client::showReminderByGroupId/$1', ['filter' => 'auth']);
$routes->put('reminder/(:num)', 'Client::updateReminder/$1', ['filter' => 'auth']);

// Group
$routes->post('group', 'Client::createGroup', ['filter' => 'auth']);
$routes->get('group', 'Client::showGroup', ['filter' => 'auth']);
$routes->post('group/join', 'Client::joinGroup', ['filter' => 'auth']);
$routes->delete('group/(:num)/user/(:num)', 'Client::leaveGroup/$1/$2', ['filter' => 'auth']);

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
