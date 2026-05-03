<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * Class Model
 * Gère la connexion à la base de données
 */
abstract class Model
{
    protected ?PDO $pdo = null;

    public function __construct()
    {
        // Connexion à la base de données via variables d'environnement
        $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $db   = $_ENV['DB_NAME'] ?? 'covoiturage_db';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? '';
        $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }
}
