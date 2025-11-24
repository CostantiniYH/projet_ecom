<?php
namespace App\Controllers;

class AdminController
{
    private $pdo;
    public function __construct($pdo) {

        $this->pdo = $pdo;
    }

    public function dashboard()
    {
        $navbar = buildNavbar("Dashboard admin");
        $user = getAll($this->pdo, 't_users');
        $categorie = getAll($this->pdo, 't_categories');


        $titre = "Dashboard admin";
        
        ob_start();
        require_once __DIR__ . '/../Views/admin/dashboard.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/partials/layout.php';
        

    }


}