<?php
namespace App\Controllers;

use App\Config\BD;
use PDO;
use PDOException;

class CategorieController {
    private function getAllCategoriesWithProductCount() {
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
    
    public function index() {
        $categories = $this->getAllCategoriesWithProductCount();
        $data = [
            'categories' => $categories
        ];
        afficher('categories', 'Catégories', 'categories', $data);
    }
}