<?php
namespace App\Controllers;
use App\Models\Requetes\UserModel;
use App\Models\Validations\UserValidator;
use App\Models\Services\UserService;


class ProduitController {

    public function liste_produits() {
        $id = $_GET['id'] ?? null;
        $produits = getAllWhere ('t_produits', 'deleted_at IS NULL AND quantite > ?', 0);
        $produitID = findBy ('t_produits', 'id_categorie', $id); 
        $data = [
            'id' => $id,
            'produits' => $produits,
            'produitID' => $produitID
        ];
        afficher('produits', 'Produits', 'produits', $data);
    }

    public function detail_produit() {
        $id = $_GET['id'];
        $one = findBy ('t_produits', 'id', $id); 
        $one = $one[0];
        $data = [
            'id' => $id,
            'one' => $one
        ];
        afficher('détail_produits', 'Détails du produit', 'produit_one', $data);
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
        $data = [
            'categories' => $categories,
            'produits' => $produits,
            'id' => $id,
            'produit' => $produit
        ];
        afficher('form_produit', 'Formulaire Produit', 'form_produit', $data);
    }
}

