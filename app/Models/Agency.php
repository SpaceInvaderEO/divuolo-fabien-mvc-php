<?php

namespace App\Models;

use App\Core\Model;

/**
 * Class Agency
 * Modèle pour gérer les accès à la table `agency`
 */
class Agency extends Model
{
    /**
     * Récupère toutes les agences, triées par nom
     *
     * @return array<int, array<string, mixed>> Liste des agences
     */
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM `agency` ORDER BY `name` ASC");
        return $stmt->fetchAll();
    }

    /**
     * Récupère une agence par son ID
     *
     * @param int $id
     * @return array<string, mixed>|false
     */
    public function getById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `agency` WHERE `id_agency` = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Crée une nouvelle agence
     *
     * @param string $name
     * @return bool
     */
    public function create(string $name): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO `agency` (`name`) VALUES (:name)");
        return $stmt->execute(['name' => $name]);
    }

    /**
     * Met à jour une agence
     *
     * @param int $id
     * @param string $name
     * @return bool
     */
    public function update(int $id, string $name): bool
    {
        $stmt = $this->pdo->prepare("UPDATE `agency` SET `name` = :name WHERE `id_agency` = :id");
        return $stmt->execute(['id' => $id, 'name' => $name]);
    }

    /**
     * Supprime une agence
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM `agency` WHERE `id_agency` = :id");
        return $stmt->execute(['id' => $id]);
    }
}
