<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

    $routes->setDefaultNamespace('App\Controllers');
    $routes->setDefaultController('Home');
    $routes->setTranslateURIDashes('index');
    $routes->set404Override();


    $routes->get('/', 'Home::index');
    
    $routes->get('dashboard', 'DashboardController::index');


    $routes->resource('offices', 
    [
        'controller' => 'OfficeController', 
        'except' => 'new,edit',
        'filter' => 'auth'
    ]);

    $routes->resource('tickets', 
    [
        'controller' => 'TicketController', 
        'except' => 'new,edit',
        // 'filter' => 'auth'
    ]);


    service('auth')->routes($routes);
