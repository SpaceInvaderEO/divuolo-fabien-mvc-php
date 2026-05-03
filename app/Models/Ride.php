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
                u.last_name
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
}
