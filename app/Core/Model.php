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
        // Connexion à la base de données (idéalement via variables d'environnement plus tard)
        $host = '127.0.0.1';
        $db   = 'covoiturage_db';
        $user = 'root';
        $pass = ''; // Modifiez avec votre mot de passe si nécessaire
        $charset = 'utf8mb4';

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
