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
    
    
        $routes->get('dashboard', 'DashboardController::index', ['filter' => 'groupfilter:admin']);

        $routes->post('offices/list', 'OfficeController::list', ['filter' => 'groupfilter:admin']);
        $routes->post('roles/list', 'RoleController::list', ['filter' => 'groupfilter:admin']);

        $routes->post('tickets/list', 'TicketController::list', ['filter' => 'auth']);


        $routes->resource('roles', 
        [
            'controller' => 'RoleController', 
            'except' => 'new,edit',
            'filter' => 'groupfilter:admin'
        ]);


    $routes->resource('offices', 
    [
        'controller' => 'OfficeController', 
        'except' => 'new,edit',
        'filter' => 'groupfilter:admin'
    ]);

    $routes->resource('tickets', 
    [
        'controller' => 'TicketController', 
        'except' => 'new,edit',
        // 'filter' => 'auth'
    ]);


    service('auth')->routes($routes);
