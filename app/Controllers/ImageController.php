<?php
namespace App\Controllers;

use App\Config\Database;

class ImageController {
    public function index() {
        $image = getAll('t_images');
        $data = [
            'image' => $image
        ];
        afficher('images', 'Galerie d\'images', 'images', $data);
    }
}