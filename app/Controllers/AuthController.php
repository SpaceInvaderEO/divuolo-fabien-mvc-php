<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

/**
 * Class AuthController
 * Gère l'authentification des utilisateurs (Connexion, Déconnexion, Vérification)
 */
class AuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion si l'utilisateur n'est pas déjà authentifié
     * 
     * @return void
     */
    public function login(): void
    {
        // Si déjà connecté, rediriger vers l'accueil
        if (isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }

        $this->render('auth/login', ['title' => 'Connexion - Covoiturage Pro']);
    }

    /**
     * Traite la soumission du formulaire de connexion et initialise la session utilisateur
     * 
     * @return void
     */
    public function authenticate(): void
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
                unset($user['password']); // On ne stocke pas le mot de passe hashé en session par sécurité
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
     * Déconnecte l'utilisateur en détruisant sa session
     * 
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
        session_destroy();
        
        session_start(); // On redémarre une session pour porter le message flash de déconnexion
        $_SESSION['flash_message'] = "Vous avez été déconnecté.";
        $_SESSION['flash_type'] = "info";
        
        header('Location: /');
        exit;
    }
}
