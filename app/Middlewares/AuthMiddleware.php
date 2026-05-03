<?php

namespace App\Middlewares;

/**
 * Class AuthMiddleware
 * Vérifie si l'utilisateur est connecté
 */
class AuthMiddleware
{
    public function handle(): bool
    {
        if (!isset($_SESSION['user'])) {
            $_SESSION['flash_message'] = "Vous devez être connecté pour accéder à cette page.";
            $_SESSION['flash_type'] = "warning";
            header('Location: /login');
            exit;
        }

        return true;
    }
}
