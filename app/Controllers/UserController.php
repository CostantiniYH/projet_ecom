<?php
namespace App\Controllers;

class UserController {
    public function dashboard()
    {
        require_login();

        $navbar = buildNavbar("Dashboard");
        $id = $_SESSION['user']['id'];
        $user = $_SESSION['user'];        
        $myProduits = findBy('t_produits', 'id_user', $id);
        $myImage = findBy('t_images', 'id_user', $id);

        $titre = "Dashboard";
        
        ob_start();
        require_once __DIR__ . '/../Views/users/dashboard.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/partials/layout.php';
    }
}