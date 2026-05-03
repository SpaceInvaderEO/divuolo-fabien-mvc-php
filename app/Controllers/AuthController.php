<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

/**
 * Class AuthController
 * Gère l'authentification des utilisateurs
 */
class AuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion
     */
    public function login()
    {
        // Si déjà connecté, rediriger vers l'accueil
        if (isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }

        $this->render('auth/login', ['title' => 'Connexion - Covoiturage']);
    }

    /**
     * Traite la soumission du formulaire de connexion
     */
    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['flash_message'] = "Veuillez remplir tous les champs.";
                $_SESSION['flash_type'] = "danger";
                header('Location: /login');
                exit;
            }

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Mot de passe correct, on stocke en session
                unset($user['password']); // On ne stocke pas le mot de passe en session
                $_SESSION['user'] = $user;
                
                $_SESSION['flash_message'] = "Bienvenue {$user['first_name']} !";
                $_SESSION['flash_type'] = "success";
                
                header('Location: /');
                exit;
            } else {
                $_SESSION['flash_message'] = "Identifiants incorrects.";
                $_SESSION['flash_type'] = "danger";
                header('Location: /login');
                exit;
            }
        }
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        
        session_start(); // On redémarre une session pour le message flash
        $_SESSION['flash_message'] = "Vous avez été déconnecté.";
        $_SESSION['flash_type'] = "info";
        
        header('Location: /');
        exit;
    }
}
