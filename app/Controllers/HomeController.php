<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Ride;

/**
 * Class HomeController
 * Contrôleur de la page d'accueil
 */
class HomeController extends Controller
{
    /**
     * Affiche la liste des trajets disponibles
     */
    public function index()
    {
        $rideModel = new Ride();
        $rides = $rideModel->getAvailableRides();

        $this->render('home/index', [
            'title' => 'Accueil - Covoiturage Pro',
            'rides' => $rides
        ]);
    }
}
