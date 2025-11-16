<?php
namespace App\Controllers;
use App\Config\Database;
use PDO;
use Exception;
use App\classes\User;


class AuthController {
    public function login() {
        $navbar = authNavbar('login');

        $titre = "Connexion";

        ob_start(); 
        require_once __DIR__ . '/../View/auth/login.php';       
        $content = ob_get_clean();

        require_once __DIR__ . '/../View/partials/layout.php';

        //require_once __DIR__ . '/../../controllers/session.php';
        //require_once __DIR__ . '/../../class/user.php';


        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $pdo = Database::connect();

        $value = findBy2( $pdo, '*', 't_users', 'email', $email);

        if (is_array($value) && count($value) == 0) {
            header('Location: ' . BASE_URL . 'Form/Compte/login.php?erreur=L\'utilisateur n\'existe pas.');
            exit();
        }

        $password_hash = $value['password'];

        if (User::verifyPassword($password, $password_hash)) {
            loginUser($value);
            if (isAdmin()) {
                header('Location: ' . BASE_URL . 'admin/dashboard.php?success=Vous êtes connecté en tant qu\'administrateur.');
                exit();
            } 
            header ('Location: ' . BASE_URL . 'compte/dashboard.php?success=Connexion réussi !');
            exit();
        } else {
            header('Location: ' . BASE_URL . 'Form/Compte/login.php?erreur=Le mot de passe est incorrecte !');
            exit();
        }
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