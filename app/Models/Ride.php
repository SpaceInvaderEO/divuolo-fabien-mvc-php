<?php

namespace App\Models;

use App\Core\Model;

/**
 * Class Ride
 * Modèle pour gérer les accès à la table `ride`
 */
class Ride extends Model
{
    /**
     * Récupère tous les trajets avec places disponibles et non passés
     *
     * @return array<int, array<string, mixed>> Liste des trajets
     */
    public function getAvailableRides(): array
    {
        $sql = "
            SELECT 
                r.id_ride, 
                r.departure_time, 
                r.arrival_time, 
                r.total_seats, 
                r.available_seats,
                dep_agency.name as departure_agency_name,
                arr_agency.name as arrival_agency_name,
                u.first_name,
                u.last_name,
                u.phone,
                u.email
            FROM `ride` r
            INNER JOIN `agency` dep_agency ON r.id_departure_agency = dep_agency.id_agency
            INNER JOIN `agency` arr_agency ON r.id_arrival_agency = arr_agency.id_agency
            INNER JOIN `user` u ON r.id_user = u.id_user
            WHERE r.available_seats > 0 
              AND r.departure_time > NOW()
            ORDER BY r.departure_time ASC
        ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Insère un nouveau trajet en base de données
     *
     * @param array<string, mixed> $data Données du trajet
     * @return bool
     */
    public function insert(array $data): bool
    {
        $sql = "INSERT INTO `ride` 
                (`departure_time`, `arrival_time`, `total_seats`, `available_seats`, `id_departure_agency`, `id_arrival_agency`, `id_user`) 
                VALUES 
                (:departure_time, :arrival_time, :total_seats, :available_seats, :id_departure_agency, :id_arrival_agency, :id_user)";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'departure_time' => $data['departure_time'],
            'arrival_time' => $data['arrival_time'],
            'total_seats' => $data['total_seats'],
            'available_seats' => $data['available_seats'],
            'id_departure_agency' => $data['id_departure_agency'],
            'id_arrival_agency' => $data['id_arrival_agency'],
            'id_user' => $data['id_user']
        ]);
    }

    /**
     * Récupère un trajet spécifique par son ID
     *
     * @param int $id ID du trajet
     * @return array<string, mixed>|false Le trajet ou false si non trouvé
     */
    public function findById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `ride` WHERE `id_ride` = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Met à jour un trajet existant
     *
     * @param int $id ID du trajet
     * @param array<string, mixed> $data Nouvelles données
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE `ride` 
                SET `departure_time` = :departure_time, 
                    `arrival_time` = :arrival_time, 
                    `total_seats` = :total_seats, 
                    `available_seats` = :available_seats, 
                    `id_departure_agency` = :id_departure_agency, 
                    `id_arrival_agency` = :id_arrival_agency 
                WHERE `id_ride` = :id";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'departure_time' => $data['departure_time'],
            'arrival_time' => $data['arrival_time'],
            'total_seats' => $data['total_seats'],
            'available_seats' => $data['available_seats'],
            'id_departure_agency' => $data['id_departure_agency'],
            'id_arrival_agency' => $data['id_arrival_agency'],
            'id' => $id
        ]);
    }

    /**
     * Supprime un trajet
     *
     * @param int $id ID du trajet
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM `ride` WHERE `id_ride` = :id");
        return $stmt->execute(['id' => $id]);
    }
}
