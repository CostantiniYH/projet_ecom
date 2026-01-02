<?php
namespace App\Controllers;

use App\Config\Database;
use App\Views\Components\Carousel;

class HomeController {
    public function index() {
        $navbar = buildNavbar('home');
        
        $categories = getAll ('t_categories');                
        $a = [];        
        foreach ($categories as $categorie) {
            $files = glob('uploads/' . $categorie['nom'] . '/*.jpg');            
            foreach ($files as $file) {
                $fileName = basename($file, pathinfo($file, PATHINFO_EXTENSION));
                $text = ucwords(str_replace(['_', '-', '.'], ' ', $fileName));
                $a[] = [
                    'link' => $file,
                    'text' => '',
                    'id' => $categorie['id']
                ];
            }
        }

        $titre = "Accueil";

        ob_start(); 
        require_once __DIR__ . '/../Views/home.php';       
        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/partials/layout.php';
    }
}