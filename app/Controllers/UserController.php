<?php
namespace App\Controllers;

class UserController
{
    private $pdo;
    public function __construct($pdo) {

        $this->pdo = $pdo;
    }

    public function dashboard()
    {
        require_login();

        if (!isset($_SESSION['user'])) {
            die("Erreur : utilisateur non connecté.");
        } 

        $navbar = buildNavbar("Dashboard");
        $id = $_SESSION['user']['id'];
        $user = $_SESSION['user'];        
        $myProduits = findBy($this->pdo, 't_produits', 'id_user', $id);
        $myImage = findBy($this->pdo, 't_images', 'id_user', $id);

        $titre = "Dashboard";
        
        ob_start();
        require_once __DIR__ . '/../Views/users/dashboard.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/partials/layout.php';
        

    }


}