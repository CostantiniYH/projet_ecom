<?php
namespace App\Controllers;

use App\Config\Database;
use App\Views\Components\Carousel;

class HomeController {
    public function index() {
        
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
        $data = [
            'a' => $a
        ];
        afficher('home', 'Accueil', 'home', $data);
    }
}