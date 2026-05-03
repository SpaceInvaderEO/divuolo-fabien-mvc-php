<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Agency;
use App\Models\Ride;

/**
 * Class RideController
 * Contrôleur pour la gestion des trajets
 */
class RideController extends Controller
{
    /**
     * Affiche le formulaire de création d'un trajet
     */
    public function create()
    {
        $agencyModel = new Agency();
        $agencies = $agencyModel->getAll();

        $this->render('ride/create', [
            'title' => 'Créer un trajet - Covoiturage Pro',
            'agencies' => $agencies
        ]);
    }

    /**
     * Traite la soumission du formulaire de création
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_departure_agency = filter_input(INPUT_POST, 'id_departure_agency', FILTER_VALIDATE_INT);
            $id_arrival_agency = filter_input(INPUT_POST, 'id_arrival_agency', FILTER_VALIDATE_INT);
            $departure_time = $_POST['departure_time'] ?? '';
            $arrival_time = $_POST['arrival_time'] ?? '';
            $total_seats = filter_input(INPUT_POST, 'total_seats', FILTER_VALIDATE_INT);

            // Validation des champs requis
            if (!$id_departure_agency || !$id_arrival_agency || empty($departure_time) || empty($arrival_time) || !$total_seats) {
                $_SESSION['flash_message'] = "Tous les champs sont requis et doivent être valides.";
                $_SESSION['flash_type'] = "danger";
                header('Location: /ride/create');
                exit;
            }

            // Vérification que les agences sont différentes
            if ($id_departure_agency === $id_arrival_agency) {
                $_SESSION['flash_message'] = "L'agence de départ et d'arrivée doivent être différentes.";
                $_SESSION['flash_type'] = "warning";
                header('Location: /ride/create');
                exit;
            }

            // Vérification de la cohérence des dates
            $dep_time_obj = strtotime($departure_time);
            $arr_time_obj = strtotime($arrival_time);
            $now = time();

            if ($dep_time_obj < $now) {
                $_SESSION['flash_message'] = "La date de départ ne peut pas être dans le passé.";
                $_SESSION['flash_type'] = "warning";
                header('Location: /ride/create');
                exit;
            }

            if ($arr_time_obj <= $dep_time_obj) {
                $_SESSION['flash_message'] = "La date d'arrivée doit être ultérieure à la date de départ.";
                $_SESSION['flash_type'] = "warning";
                header('Location: /ride/create');
                exit;
            }

            // Nombre de places positif
            if ($total_seats <= 0) {
                $_SESSION['flash_message'] = "Le nombre de places doit être supérieur à 0.";
                $_SESSION['flash_type'] = "warning";
                header('Location: /ride/create');
                exit;
            }

            // Enregistrement en base
            $rideModel = new Ride();
            $success = $rideModel->insert([
                'departure_time' => $departure_time,
                'arrival_time' => $arrival_time,
                'total_seats' => $total_seats,
                'available_seats' => $total_seats, // Au départ, toutes les places sont disponibles
                'id_departure_agency' => $id_departure_agency,
                'id_arrival_agency' => $id_arrival_agency,
                'id_user' => $_SESSION['user']['id_user']
            ]);

            if ($success) {
                $_SESSION['flash_message'] = "Votre trajet a été publié avec succès !";
                $_SESSION['flash_type'] = "success";
                header('Location: /');
            } else {
                $_SESSION['flash_message'] = "Une erreur est survenue lors de la création du trajet.";
                $_SESSION['flash_type'] = "danger";
                header('Location: /ride/create');
            }
            exit;
        }
    }

    /**
     * Affiche le formulaire de modification d'un trajet
     * 
     * @param int $id
     */
    public function edit(int $id)
    {
        $rideModel = new Ride();
        $ride = $rideModel->findById($id);

        if (!$ride || $ride['id_user'] != $_SESSION['user']['id_user']) {
            $_SESSION['flash_message'] = "Vous n'êtes pas autorisé à modifier ce trajet.";
            $_SESSION['flash_type'] = "danger";
            header('Location: /');
            exit;
        }

        $agencyModel = new Agency();
        $agencies = $agencyModel->getAll();

        $this->render('ride/edit', [
            'title' => 'Modifier le trajet - Covoiturage Pro',
            'ride' => $ride,
            'agencies' => $agencies
        ]);
    }

    /**
     * Traite la soumission de la modification
     * 
     * @param int $id
     */
    public function update(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rideModel = new Ride();
            $ride = $rideModel->findById($id);

            // Vérification de sécurité
            if (!$ride || $ride['id_user'] != $_SESSION['user']['id_user']) {
                $_SESSION['flash_message'] = "Vous n'êtes pas autorisé à modifier ce trajet.";
                $_SESSION['flash_type'] = "danger";
                header('Location: /');
                exit;
            }

            $id_departure_agency = filter_input(INPUT_POST, 'id_departure_agency', FILTER_VALIDATE_INT);
            $id_arrival_agency = filter_input(INPUT_POST, 'id_arrival_agency', FILTER_VALIDATE_INT);
            $departure_time = $_POST['departure_time'] ?? '';
            $arrival_time = $_POST['arrival_time'] ?? '';
            $total_seats = filter_input(INPUT_POST, 'total_seats', FILTER_VALIDATE_INT);

            if (!$id_departure_agency || !$id_arrival_agency || empty($departure_time) || empty($arrival_time) || !$total_seats) {
                $_SESSION['flash_message'] = "Tous les champs sont requis.";
                $_SESSION['flash_type'] = "danger";
                header("Location: /ride/edit/{$id}");
                exit;
            }

            if ($id_departure_agency === $id_arrival_agency) {
                $_SESSION['flash_message'] = "L'agence de départ et d'arrivée doivent être différentes.";
                $_SESSION['flash_type'] = "warning";
                header("Location: /ride/edit/{$id}");
                exit;
            }

            // Calculer la différence de places
            $seatsDiff = $total_seats - $ride['total_seats'];
            $newAvailableSeats = $ride['available_seats'] + $seatsDiff;

            if ($newAvailableSeats < 0) {
                $_SESSION['flash_message'] = "Vous ne pouvez pas réduire le nombre de places autant car certaines sont déjà réservées.";
                $_SESSION['flash_type'] = "danger";
                header("Location: /ride/edit/{$id}");
                exit;
            }

            $success = $rideModel->update($id, [
                'departure_time' => $departure_time,
                'arrival_time' => $arrival_time,
                'total_seats' => $total_seats,
                'available_seats' => $newAvailableSeats,
                'id_departure_agency' => $id_departure_agency,
                'id_arrival_agency' => $id_arrival_agency
            ]);

            if ($success) {
                $_SESSION['flash_message'] = "Le trajet a été mis à jour.";
                $_SESSION['flash_type'] = "success";
                header('Location: /');
            } else {
                $_SESSION['flash_message'] = "Une erreur est survenue lors de la modification.";
                $_SESSION['flash_type'] = "danger";
                header("Location: /ride/edit/{$id}");
            }
            exit;
        }
    }

    /**
     * Supprime un trajet
     * 
     * @param int $id
     */
    public function delete(int $id)
    {
        $rideModel = new Ride();
        $ride = $rideModel->findById($id);

        if (!$ride || $ride['id_user'] != $_SESSION['user']['id_user']) {
            $_SESSION['flash_message'] = "Vous n'êtes pas autorisé à supprimer ce trajet.";
            $_SESSION['flash_type'] = "danger";
            header('Location: /');
            exit;
        }

        $success = $rideModel->delete($id);

        if ($success) {
            $_SESSION['flash_message'] = "Le trajet a été supprimé.";
            $_SESSION['flash_type'] = "info";
        } else {
            $_SESSION['flash_message'] = "Une erreur est survenue lors de la suppression.";
            $_SESSION['flash_type'] = "danger";
        }

        header('Location: /');
        exit;
    }
}
