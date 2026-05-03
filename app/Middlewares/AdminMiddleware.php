<?php

namespace App\Middlewares;

/**
 * Class AdminMiddleware
 * Vérifie si l'utilisateur est connecté ET est un administrateur
 */
class AdminMiddleware
{
    public function handle(): bool
    {
        if (!isset($_SESSION['user'])) {
            $_SESSION['flash_message'] = "Vous devez être connecté pour accéder à cette page.";
            $_SESSION['flash_type'] = "warning";
            header('Location: /login');
            exit;
        }

        if (!isset($_SESSION['user']['is_admin']) || $_SESSION['user']['is_admin'] != 1) {
            $_SESSION['flash_message'] = "Accès refusé. Vous n'avez pas les droits d'administration.";
            $_SESSION['flash_type'] = "danger";
            header('Location: /');
            exit;
        }

        return true;
    }
}
