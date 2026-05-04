<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Agency;
use App\Models\Ride;

/**
 * Class AdminController
 * Gère les fonctionnalités d'administration
 */
class AdminController extends Controller
{
    private $userModel;
    private $agencyModel;
    private $rideModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->agencyModel = new Agency();
        $this->rideModel = new Ride();
    }

    /**
     * Dashboard administrateur
     */
    public function index()
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
     * Liste des utilisateurs
     */
    public function users()
    {
        $users = $this->userModel->getAll();
        $this->render('admin/users', ['users' => $users]);
    }

    /**
     * Liste des agences
     */
    public function agencies()
    {
        $agencies = $this->agencyModel->getAll();
        $this->render('admin/agencies/index', ['agencies' => $agencies]);
    }

    /**
     * Formulaire de création d'agence
     */
    public function createAgency()
    {
        $this->render('admin/agencies/form', ['title' => 'Ajouter une agence']);
    }

    /**
     * Traitement de la création d'agence
     */
    public function storeAgency()
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
     * Formulaire d'édition d'agence
     */
    public function editAgency($id)
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
     * Traitement de la mise à jour d'agence
     */
    public function updateAgency($id)
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
     * Suppression d'une agence
     */
    public function deleteAgency($id)
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
     * Liste de tous les trajets pour modération
     */
    public function rides()
    {
        $rides = $this->rideModel->getAllRides();
        $this->render('admin/rides', ['rides' => $rides]);
    }

    /**
     * Suppression d'un trajet par l'admin
     */
    public function deleteRide($id)
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
