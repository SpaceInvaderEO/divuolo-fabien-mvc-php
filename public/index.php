<?php
/**
 * Front Controller
 */

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Buki\Router\Router;
use Dotenv\Dotenv;

// Chargement des variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Instanciation du routeur
$router = new Router([
    'paths' => [
        'controllers' => __DIR__ . '/../app/Controllers',
    ],
    'namespaces' => [
        'controllers' => 'App\Controllers',
    ]
]);

// Route d'accueil
$router->get('/', 'HomeController@index');

// Routes d'authentification
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@authenticate');
$router->get('/logout', 'AuthController@logout');

// Routes protégées par authentification (Trajets)
$router->group('/ride', function($router) {
    $router->get('/create', 'RideController@create', ['before' => 'App\Middlewares\AuthMiddleware']);
    $router->post('/store', 'RideController@store', ['before' => 'App\Middlewares\AuthMiddleware']);
    
    // Modification et suppression
    $router->get('/edit/[:id]', 'RideController@edit', ['before' => 'App\Middlewares\AuthMiddleware']);
    $router->post('/update/[:id]', 'RideController@update', ['before' => 'App\Middlewares\AuthMiddleware']);
    $router->any('/delete/[:id]', 'RideController@delete', ['before' => 'App\Middlewares\AuthMiddleware']);
});

// Routes d'administration
$router->group('/admin', function($router) {
    $router->get('/', 'AdminController@index', ['before' => 'App\Middlewares\AdminMiddleware']);
    
    // Gestion des utilisateurs
    $router->get('/users', 'AdminController@users', ['before' => 'App\Middlewares\AdminMiddleware']);
    
    // Gestion des agences
    $router->get('/agencies', 'AdminController@agencies', ['before' => 'App\Middlewares\AdminMiddleware']);
    $router->get('/agencies/create', 'AdminController@createAgency', ['before' => 'App\Middlewares\AdminMiddleware']);
    $router->post('/agencies/store', 'AdminController@storeAgency', ['before' => 'App\Middlewares\AdminMiddleware']);
    $router->get('/agencies/edit/[:id]', 'AdminController@editAgency', ['before' => 'App\Middlewares\AdminMiddleware']);
    $router->post('/agencies/update/[:id]', 'AdminController@updateAgency', ['before' => 'App\Middlewares\AdminMiddleware']);
    $router->any('/agencies/delete/[:id]', 'AdminController@deleteAgency', ['before' => 'App\Middlewares\AdminMiddleware']);
    
    // Modération des trajets
    $router->get('/rides', 'AdminController@rides', ['before' => 'App\Middlewares\AdminMiddleware']);
    $router->any('/rides/delete/[:id]', 'AdminController@deleteRide', ['before' => 'App\Middlewares\AdminMiddleware']);
});

// Exécution du routeur
$router->run();
