<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Agency;
use App\Models\Ride;

/**
 * Class AdminController
 * Gère les fonctionnalités d'administration (Dashboard, Utilisateurs, Agences, Modération)
 */
class AdminController extends Controller
{
    /** @var User */
    private User $userModel;
    
    /** @var Agency */
    private Agency $agencyModel;
    
    /** @var Ride */
    private Ride $rideModel;

    /**
     * Initialise les modèles nécessaires
     */
    public function __construct()
    {
        $this->userModel = new User();
        $this->agencyModel = new Agency();
        $this->rideModel = new Ride();
    }

    /**
     * Affiche le tableau de bord administrateur avec les statistiques
     * 
     * @return void
     */
    public function index(): void
    {
        $usersCount = count($this->userModel->getAll());
        $agenciesCount = count($this->agencyModel->getAll());
        $ridesCount = count($this->rideModel->getAllRides());

        $this->render('admin/index', [
            'usersCount' => $usersCount,
            'agenciesCount' => $agenciesCount,
            'ridesCount' => $ridesCount
        ]);
    }

    /**
     * Affiche la liste complète des utilisateurs
     * 
     * @return void
     */
    public function users(): void
    {
        $users = $this->userModel->getAll();
        $this->render('admin/users', ['users' => $users]);
    }

    /**
     * Affiche la liste des agences
     * 
     * @return void
     */
    public function agencies(): void
    {
        $agencies = $this->agencyModel->getAll();
        $this->render('admin/agencies/index', ['agencies' => $agencies]);
    }

    /**
     * Affiche le formulaire de création d'une nouvelle agence
     * 
     * @return void
     */
    public function createAgency(): void
    {
        $this->render('admin/agencies/form', ['title' => 'Ajouter une agence']);
    }

    /**
     * Traite la soumission du formulaire de création d'agence
     * 
     * @return void
     */
    public function storeAgency(): void
    {
        $name = trim($_POST['name'] ?? '');

        if (empty($name)) {
            $_SESSION['flash_message'] = "Le nom de l'agence est obligatoire.";
            $_SESSION['flash_type'] = "danger";
            header('Location: /admin/agencies/create');
            exit;
        }

        if ($this->agencyModel->create($name)) {
            $_SESSION['flash_message'] = "L'agence a été créée avec succès.";
            $_SESSION['flash_type'] = "success";
            header('Location: /admin/agencies');
            exit;
        } else {
            $_SESSION['flash_message'] = "Erreur lors de la création de l'agence.";
            $_SESSION['flash_type'] = "danger";
            header('Location: /admin/agencies/create');
            exit;
        }
    }

    /**
     * Affiche le formulaire d'édition d'une agence existante
     * 
     * @param int $id ID de l'agence à modifier
     * @return void
     */
    public function editAgency(int $id): void
    {
        $agency = $this->agencyModel->getById($id);
        if (!$agency) {
            header('Location: /admin/agencies');
            exit;
        }

        $this->render('admin/agencies/form', [
            'title' => 'Modifier une agence',
            'agency' => $agency
        ]);
    }

    /**
     * Traite la mise à jour des données d'une agence
     * 
     * @param int $id ID de l'agence
     * @return void
     */
    public function updateAgency(int $id): void
    {
        $name = trim($_POST['name'] ?? '');

        if (empty($name)) {
            $_SESSION['flash_message'] = "Le nom de l'agence est obligatoire.";
            $_SESSION['flash_type'] = "danger";
            header("Location: /admin/agencies/edit/$id");
            exit;
        }

        if ($this->agencyModel->update($id, $name)) {
            $_SESSION['flash_message'] = "L'agence a été modifiée avec succès.";
            $_SESSION['flash_type'] = "success";
            header('Location: /admin/agencies');
            exit;
        } else {
            $_SESSION['flash_message'] = "Erreur lors de la modification de l'agence.";
            $_SESSION['flash_type'] = "danger";
            header("Location: /admin/agencies/edit/$id");
            exit;
        }
    }

    /**
     * Supprime une agence de la base de données
     * 
     * @param int $id ID de l'agence
     * @return void
     */
    public function deleteAgency(int $id): void
    {
        if ($this->agencyModel->delete($id)) {
            $_SESSION['flash_message'] = "L'agence a été supprimée.";
            $_SESSION['flash_type'] = "success";
        } else {
            $_SESSION['flash_message'] = "Erreur : impossible de supprimer l'agence (elle est peut-être liée à des trajets).";
            $_SESSION['flash_type'] = "danger";
        }
        header('Location: /admin/agencies');
        exit;
    }

    /**
     * Affiche la liste de tous les trajets pour modération
     * 
     * @return void
     */
    public function rides(): void
    {
        $rides = $this->rideModel->getAllRides();
        $this->render('admin/rides', ['rides' => $rides]);
    }

    /**
     * Supprime un trajet par un administrateur
     * 
     * @param int $id ID du trajet
     * @return void
     */
    public function deleteRide(int $id): void
    {
        if ($this->rideModel->delete($id)) {
            $_SESSION['flash_message'] = "Le trajet a été supprimé par l'administrateur.";
            $_SESSION['flash_type'] = "success";
        } else {
            $_SESSION['flash_message'] = "Erreur lors de la suppression du trajet.";
            $_SESSION['flash_type'] = "danger";
        }
        header('Location: /admin/rides');
        exit;
    }
}
