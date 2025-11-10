<?php
namespace App\Controllers;
use App\Config\Database;
use PDO;

class PanierController {
    public function index() {
        $navbar = buildNavbar('panier');

        $pdo = Database::connect();
        $titre = "Mon Panier";

        ob_start(); 
        require_once __DIR__ . '/../View/panier.html';
        $content = ob_get_clean();

        require_once __DIR__ . '/../View/partials/layout.php';
    }
}