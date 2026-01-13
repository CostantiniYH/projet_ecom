<?php
namespace App\Controllers;
use App\Config\Database;
use PDO;

class PanierController {
    public function index() {
        afficher('panier', 'Mon Panier', 'panier');
    }
}