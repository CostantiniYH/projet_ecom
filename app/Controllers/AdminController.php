<?php
namespace App\Controllers;

class AdminController
{
    public function dashboard()
    {
        $navbar = buildNavbar("Dashboard admin");
        $user = getAll('t_users');
        $categorie = getAll('t_categories');


        $titre = "Dashboard admin";
        
        ob_start();
        require_once __DIR__ . '/../Views/admin/dashboard.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/partials/layout.php';
        

    }


}