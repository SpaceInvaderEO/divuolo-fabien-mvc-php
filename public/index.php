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
$router->get('/', function () {
    echo "<h1>Bienvenue sur l'application de covoiturage !</h1>";
    echo "<p>Le routeur est correctement installé et configuré.</p>";
    if (isset($_SESSION['user'])) {
        echo "<p>Connecté en tant que: " . htmlspecialchars($_SESSION['user']['first_name']) . "</p>";
        echo "<a href='/logout'>Se déconnecter</a>";
    } else {
        echo "<a href='/login'>Se connecter</a>";
    }
});

// Routes d'authentification
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@authenticate');
$router->get('/logout', 'AuthController@logout');

// Exécution du routeur
$router->run();
