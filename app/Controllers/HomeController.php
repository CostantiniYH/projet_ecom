<?php
namespace App\Controllers;

use App\Config\Database;

class HomeController {
    public function index() {
        //$navbar = buildNavbar('home');

        $pdo = Database::connect();        
        $categories = getAll ($pdo, 't_categories');                
        $a = [];        
        foreach ($categories as $categorie) {
            $files = glob('uploads/' . $categorie['nom'] . '/*.{jpg}', GLOB_BRACE);            
            foreach ($files as $file) {
                $fileName = basename($file, pathinfo($file, PATHINFO_EXTENSION));
                $text = ucwords(str_replace(['_', '-', '.'], ' ', $fileName));
                $a[] = [
                    'link' => $file,
                    'text' => $text,
                    'id' => $categorie['id']
                ];
            }
        }
        
        $titre = "Accueil";

        ob_start(); 
        require_once __DIR__ . '/../View/home.php';       
        $content = ob_get_clean();

        require_once __DIR__ . '/../View/partials/layout.php';
    }
}