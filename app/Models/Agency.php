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
     * Récupère toutes les agences, triées par nom par ordre alphabétique
     *
     * @return array<int, array<string, mixed>> Liste des agences
     */
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM `agency` ORDER BY `name` ASC");
        return $stmt->fetchAll();
    }

    /**
     * Récupère une agence spécifique par son identifiant
     *
     * @param int $id ID de l'agence
     * @return array<string, mixed>|false Les données de l'agence ou false
     */
    public function getById(int $id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `agency` WHERE `id_agency` = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Crée une nouvelle agence dans la base de données
     *
     * @param string $name Nom de la nouvelle agence
     * @return bool True en cas de succès, false sinon
     */
    public function create(string $name): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO `agency` (`name`) VALUES (:name)");
        return $stmt->execute(['name' => $name]);
    }

    /**
     * Met à jour le nom d'une agence existante
     *
     * @param int $id ID de l'agence à modifier
     * @param string $name Nouveau nom de l'agence
     * @return bool True en cas de succès, false sinon
     */
    public function update(int $id, string $name): bool
    {
        $stmt = $this->pdo->prepare("UPDATE `agency` SET `name` = :name WHERE `id_agency` = :id");
        return $stmt->execute(['id' => $id, 'name' => $name]);
    }

    /**
     * Supprime une agence par son identifiant
     *
     * @param int $id ID de l'agence à supprimer
     * @return bool True en cas de succès, false sinon
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM `agency` WHERE `id_agency` = :id");
        return $stmt->execute(['id' => $id]);
    }
}
