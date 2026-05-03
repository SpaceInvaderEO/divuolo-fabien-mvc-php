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
}
