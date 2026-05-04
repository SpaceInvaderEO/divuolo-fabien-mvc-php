<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Ride;

/**
 * Class HomeController
 * Gère l'affichage de la page d'accueil publique
 */
class HomeController extends Controller
{
    /**
     * Affiche la liste des trajets disponibles (non complets et non passés)
     * 
     * @return void
     */
    public function index(): void
    {
        $rideModel = new Ride();
        $rides = $rideModel->getAvailableRides();

        $this->render('home/index', [
            'title' => 'Accueil - Covoiturage Pro',
            'rides' => $rides
        ]);
    }
}
