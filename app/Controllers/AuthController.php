<?php
namespace App\Controllers;
use App\Models\Entites\User;
use App\Models\Services\UserService;
use App\Models\Validations\UserValidator;



class AuthController 
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function login() {
        $navbar = authNavbar('login');

        $titre = "Connexion";

        ob_start(); 
        require_once __DIR__ . '/../Views/auth/login.php';       
        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/partials/layout.php';

        $email = $_POST['email'];
        $password = $_POST['password'];

        $value = User::verifyEmail($email);

        if (is_array($value) && count($value) == 0) {
            header('Location: /login?erreur=L\'utilisateur n\'existe pas.');
            exit();
        }

        $password_hash = $value['password'];

        if (User::verifyPassword($password, $password_hash)) {
            loginUser($value);
            if (isAdmin()) {
                header('Location: /dashboard_admin?success=Vous êtes connecté en tant qu\'administrateur.');
                exit;
            } 
            header ('Location: /dashboard?success=Connexion réussi !');
            exit;
        } else {
            header('Location: /login?erreur=Le mot de passe est incorrecte !');
            exit;
        }
    }

    public function register() {
        $navbar = authNavbar('register');

        $titre = "Inscription";

        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        $user = null;
        if ($id) {
            $user = findBy1 ($this->pdo, 't_users', 'id', $id);
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