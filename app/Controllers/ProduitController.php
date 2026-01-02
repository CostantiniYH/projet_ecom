<?php
namespace App\Controllers;
use App\Models\Requetes\UserModel;
use App\Models\Validations\UserValidator;
use App\Models\Services\UserService;


class ProduitController {

    public function liste_produits() {
        $navbar = buildNavbar('produits');

        $id = $_GET['id'] ?? null;
        $produits = getAllWhere ('t_produits', 'deleted_at IS NULL AND quantite > ?', 0);
        $produitID = findBy ('t_produits', 'id_categorie', $id); 
        
        $titre = "Produits";

        ob_start(); 
        require_once __DIR__ . '/../Views/produits.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/partials/layout.php';
    }

    public function detail_produit() {
        $navbar = buildNavbar('détail_produits');
        $id = $_GET['id'];
        $one = findBy ('t_produits', 'id', $id); 
        $one = $one[0];
        
        $titre = "Détails du produit";

        ob_start(); 
        require_once __DIR__ . '/../Views/produit_one.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/partials/layout.php';
    }

    public function formProduit() {
        require_login();

        $categories = getAll('t_categories');
        $produits = getAllWhere('t_produits', 'deleted_at IS NULL AND quantite > ?', 0);

        $id = isset($_GET['id']) ? intval($_GET['id']) : null;  // Sécurisation

        $produit = null;
        if ($id) {
            $produit = findBy('t_produits', 'id', $id);
            $produit = $produit[0] ?? null; // Vérifier si le produit existe
            if (!$produit || empty($produit)) {
                die("Produit introuvable.");
            }
        }
        $navbar = buildNavbar('form_produit');

        $titre = "Formulaire Produit";

        ob_start(); 
        require_once __DIR__ . '/../Views/form_produit.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/partials/layout.php';
    }
}

