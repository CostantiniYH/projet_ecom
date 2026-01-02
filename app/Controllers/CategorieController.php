<?php
namespace App\Controllers;

use App\Config\Database;
use PDO;
use PDOException;

class CategorieController {
    public function index() {
        $navbar = buildNavbar('categories');
        $titre = "Catégories";
        
        function getAllCategoriesWithProductCount() {
        try {
            $sql = "SELECT c.id, c.nom, c.image, COUNT(p.id) AS nombre_produits
            FROM t_categories c
            LEFT JOIN t_produits p ON p.id_categorie = c.id
            GROUP BY c.id, c.nom
            ORDER BY c.nom ASC";
            $stmt = BD::co()->prepare($sql);
            $stmt->execute([]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
        $categories = getAllCategoriesWithProductCount();
        ob_start();
        require_once __DIR__ . '/../Views/categories.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../Views/partials/layout.php';
    }
}