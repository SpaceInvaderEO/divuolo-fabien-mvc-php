<?php
/**
 * Front Controller
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Buki\Router\Router;

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
$router->get('/', function () {
    echo "<h1>Bienvenue sur l'application de covoiturage !</h1>";
    echo "<p>Le routeur est correctement installé et configuré.</p>";
});

// Exécution du routeur
$router->run();
