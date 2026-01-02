<?php
namespace App\Controllers;

use App\Config\Database;

class ImageController {
    public function index() {
        $navbar = buildNavbar('images');
        
        $titre = "Galerie d'images";

        $image = getAll('t_images');

        ob_start();
        require_once __DIR__ . '/../Views/image.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../Views/partials/layout.php';
    }
}