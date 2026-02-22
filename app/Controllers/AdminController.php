<?php
namespace App\Controllers;
use PDO;
use PDOException;


class AdminController
{
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function dashboard()  {
        $pdo = $this->pdo;
        // Bloquer la page aux utiliateurs non connectés
        require_login();

        // Vérification que les données de sessions ont bien été enregistrées
        if (!isset($_SESSION['user'])) {
            die("Erreur : utilisateur non connecté.");
        }

        // Interdire la page aux utilisateurs non admin
        if (isAdmin()) {
            getUserSession();
            } else {
            header("Location: login?erreur=L'accès est restraint.");
            exit();
        }

        // Récupérer tous les produits non-archivés pour admin
        function produitDash($pdo) {
            try {
            $sql = "SELECT p.*, c.nom AS nom_categorie FROM t_produits p
            INNER JOIN t_categories c ON p.id_categorie = c.id WHERE deleted_at IS NULL";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([]);
            $produit = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $produit;
            } catch (PDOException $e) {
                echo "Erreur : " .$e->getMessage();
            }
        } 
        
        // Récupérer tous les utilisateurs et les mettre en variable
        $user = getAll($this->pdo, 't_users');
        
        // Récupérer toutes les catégories et les mettre en variable
        $categorie = getAll($this->pdo, 't_categories');
        
        // Mettre en variable les produits
        $produits = produitDash($pdo);

        // Récupérer toutes les images de la galerie et les mettre en variable        
        $image = getAll2($pdo, 't_images');  

        // $navbar = buildNavbar("Dashboard admin");
        $titre = "Dashboard admin";
        
        ob_start();
        require_once __DIR__ . '/../Views/admin/dashboard.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/partials/layout.php';     
    }    
}