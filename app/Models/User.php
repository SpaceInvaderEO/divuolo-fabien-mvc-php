<?php

namespace App\Models;

use App\Core\Model;

/**
 * Class User
 * Modèle pour gérer les accès à la table `user`
 */
class User extends Model
{
    /**
     * Recherche un utilisateur par son adresse email
     *
     * @param string $email Adresse email de l'utilisateur
     * @return array<string, mixed>|false Les données de l'utilisateur ou false
     */
    public function findByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `user` WHERE `email` = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }
    
    /**
     * Recherche un utilisateur par son ID
     *
     * @param int $id ID unique de l'utilisateur
     * @return array<string, mixed>|false Les données de l'utilisateur ou false
     */
    public function findById(int $id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `user` WHERE `id_user` = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Récupère tous les utilisateurs triés par nom et prénom
     *
     * @return array<int, array<string, mixed>> Liste exhaustive des utilisateurs
     */
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM `user` ORDER BY `last_name` ASC, `first_name` ASC");
        return $stmt->fetchAll();
    }
}
