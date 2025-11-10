<?php
namespace App\Controllers;

use App\Config\Database;
use PDO;
use PDOException;

class ProduitController {
    public function index() {
        $navbar = buildNavbar('produits');

        $id = $_GET['id'] ?? null;
        $pdo = Database::connect();
        $produits = getAllWhere ($pdo, 't_produits', 'deleted_at IS NULL AND quantite > ?', 0);
        $produitID = findBy ($pdo, 't_produits', 'id_categorie', $id); 
        
        $titre = "Produits";

        ob_start(); 
        require_once __DIR__ . '/../View/produits.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../View/partials/layout.php';
    }

    public function show($id) {
        $navbar = buildNavbar('produits');
        $pdo = Database::connect();
        $one = findBy ($pdo, 't_produits', 'id', $id); 
        $one = $one[0];
        
        $titre = "Détails du produit";

        ob_start(); 
        require_once __DIR__ . '/../View/produit_one.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../View/partials/layout.php';
    }
}

