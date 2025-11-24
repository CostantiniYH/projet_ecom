<?php
namespace App\Controllers;
use App\Config\Database;
use App\Models\Classes\User;
use PDO;
use Exception;


class AuthController {
    public function login() {
        $navbar = authNavbar('login');

        $titre = "Connexion";

        ob_start(); 
        require_once __DIR__ . '/../Views/auth/login.php';       
        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/partials/layout.php';

        $email = $_POST['email'];
        $password = $_POST['password'];

        $pdo = Database::connect();

        $value = findBy2( $pdo, '*', 't_users', 'email', $email);

        if (is_array($value) && count($value) == 0) {
            header('Location: /login?erreur=L\'utilisateur n\'existe pas.');
            exit();
        }

        $password_hash = $value['password'];

        if (User::verifyPassword($password, $password_hash)) {
            loginUser($value);
            if (isAdmin()) {
                header('Location: admin/dashboard?success=Vous êtes connecté en tant qu\'administrateur.');
                exit();
            } 
            header ('Location: user/dashboard?success=Connexion réussi !');
            exit();
        } else {
            header('Location: /login?erreur=Le mot de passe est incorrecte !');
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
        require_once __DIR__ . '/../Views/auth/register.php';       
        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/partials/layout.php';
    }

    public function logout() {
        require_once __DIR__ . '/../coreTemp/session.php';
        logoutUser();
    }
}