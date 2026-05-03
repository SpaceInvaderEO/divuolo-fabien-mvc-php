<?php

namespace App\Models;

use App\Core\Model;
use PDO;

/**
 * Class User
 * Modèle pour gérer les accès à la table `user`
 */
class User extends Model
{
    /**
     * Recherche un utilisateur par son adresse email
     *
     * @param string $email
     * @return array<string, mixed>|false
     */
    public function findByEmail(string $email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `user` WHERE `email` = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }
    
    /**
     * Recherche un utilisateur par son ID
     *
     * @param int $id
     * @return array<string, mixed>|false
     */
    public function findById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `user` WHERE `id_user` = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
