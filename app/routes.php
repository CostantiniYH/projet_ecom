<?php
declare (strict_types=1);


switch ($uri) {
    case '/':
        $controller = new App\Controllers\HomeController();
        $controller->index();
        break;
    
    case '/categories':
        $controller = new App\Controllers\CategorieController();
        $controller->index();
        break;

    case '/produits':
        $controller = new App\Controllers\ProduitController();
        $controller->index();
        break;

    case '/produit_one':
        $controller = new App\Controllers\ProduitController();
        $controller->show($_GET['id']);
        break;

    case '/images':
        $controller = new App\Controllers\ImageController();
        $controller->index();
        break;
    
    case '/panier':
        $controller = new App\Controllers\PanierController();
        $controller->index();
        break;    
    
    case '/login':
        $controller = new App\Controllers\AuthController();
        $controller->login();
        break;

    case '/register':
        $controller = new App\Controllers\AuthController();
        $controller->register();
        break;
        
    case '/logout':
        $controller = new App\Controllers\AuthController();
        $controller->logout();
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page non trouvée";
        break;
}
