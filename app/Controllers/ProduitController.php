<?php
namespace App\Controllers;

use App\Config\Database;
use PDO;
use PDOException;

class ProduitController {
    public function liste_produits() {
        $navbar = buildNavbar('produits');

        $id = $_GET['id'] ?? null;
        $pdo = Database::connect();
        $produits = getAllWhere ($pdo, 't_produits', 'deleted_at IS NULL AND quantite > ?', 0);
        $produitID = findBy ($pdo, 't_produits', 'id_categorie', $id); 
        
        $titre = "Produits";

        ob_start(); 
        require_once __DIR__ . '/../Views/produits.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/partials/layout.php';
    }

    public function detail_produit() {
        $navbar = buildNavbar('détail_produits');
        $pdo = Database::connect();
        $id = $_GET['id'];
        $one = findBy ($pdo, 't_produits', 'id', $id); 
        $one = $one[0];
        
        $titre = "Détails du produit";

        ob_start(); 
        require_once __DIR__ . '/../Views/produit_one.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/partials/layout.php';
    }
}

