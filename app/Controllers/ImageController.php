<?php
namespace App\Controllers;

use App\Config\Database;

class ImageController {
    public function index() {
        $navbar = buildNavbar('images');
        
        $titre = "Galerie d'images";

        $pdo = Database::connect();
        
        $image = getAll($pdo, 't_images');
        
        ob_start();
        require_once __DIR__ . '/../View/image.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../View/partials/layout.php';
    }
}