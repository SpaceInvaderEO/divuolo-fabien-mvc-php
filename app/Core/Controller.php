<?php

namespace App\Core;

/**
 * Class Controller
 * Classe parente pour tous les contrôleurs
 */
abstract class Controller
{
    /**
     * Permet de charger une vue
     * 
     * @param string $view Nom du fichier de la vue (sans .php)
     * @param array<string, mixed> $data Données à passer à la vue
     * @return void
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("La vue {$view} n'existe pas.");
        }
    }
}
