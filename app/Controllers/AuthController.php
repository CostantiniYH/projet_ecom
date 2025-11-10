<?php
namespace App\Controllers;


use App\Config\Database;
use PDO;
use Exception;

class AuthController {
    public function login() {
        $navbar = authNavbar('login');

        $titre = "Connexion";

        ob_start(); 
        require_once __DIR__ . '/../View/auth/login.php';       
        $content = ob_get_clean();

        require_once __DIR__ . '/../View/partials/layout.php';
    }

    public function register() {
        $navbar = authNavbar('register');

        $titre = "Inscription";

        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        $pdo = Database::connect();
        $user = null;
        if ($id) {
            $user = findBy1 ($pdo, 't_users', 'id', $id);
            $user = $user[0] ?? null;
        }

        ob_start(); 
        require_once __DIR__ . '/../View/auth/register.php';       
        $content = ob_get_clean();

        require_once __DIR__ . '/../View/partials/layout.php';
    }

    public function logout() {
        require_once __DIR__ . '/../core/session.php';
        logoutUser();
    }
}