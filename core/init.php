<?php
// require dirname(__DIR__) . '/../test_db.php';
// print_r(dirname(__DIR__));

$configFile = dirname(__DIR__) . '/app/config/config.php';
if (file_exists($configFile)) {
    require $configFile;
}

require dirname(__DIR__) . '/routes/web.php';
require dirname(__DIR__) . '/routes/auth.php';
require dirname(__DIR__) . '/routes/user.php';
require dirname(__DIR__) . '/routes/admin.php';

require dirname(__DIR__) . '/app/coreTemp/session.php';
require dirname(__DIR__) . '/app/Views/partials/navbarBuilder.php'; 
require dirname(__DIR__) . '/app/Models/Requetes/ProduitModel.php';
use App\Config\Database;

$pdo = Database::connect();

$router = new Core\Routing\Router($pdo);
$router->run();


require dirname(__DIR__) . '/app/Models/Requetes/model.php';



    