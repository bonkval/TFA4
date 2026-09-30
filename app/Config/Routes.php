<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Pages::home');
$routes->get('about', 'Pages::about');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->match(['get', 'post'], 'logout', 'Auth::logout');
$routes->get('customers', 'Customers::index', ['filter' => 'auth']);
$routes->get('customers/new', 'Customers::new', ['filter' => 'auth']);
$routes->post('customers', 'Customers::create', ['filter' => 'auth']);
$routes->get('customers/(:num)/edit', 'Customers::edit/$1', ['filter' => 'auth']);
$routes->post('customers/(:num)', 'Customers::update/$1', ['filter' => 'auth']);
$routes->get('users', 'Users::index', ['filter' => 'auth']);
$routes->get('users/new', 'Users::new', ['filter' => 'auth']);
$routes->post('users', 'Users::create', ['filter' => 'auth']);
$routes->get('users/(:num)/edit', 'Users::edit/$1', ['filter' => 'auth']);
$routes->post('users/(:num)', 'Users::update/$1', ['filter' => 'auth']);
