<?php
use App\Config\Database;
use Core\Routing\Router;

require dirname(__DIR__) . '/app/Config/config.php';
require dirname(__DIR__) . '/app/Views/partials/navbarBuilder.php'; 
require dirname(__DIR__) . '/app/coreTemp/session.php';
require dirname(__DIR__) . '/app/Models/Requetes/ProduitModel.php';
require dirname(__DIR__) . '/app/Models/Requetes/ImageModel.php';

require_once dirname(__DIR__) . '/routes/web.php';
require_once dirname(__DIR__) . '/routes/auth.php';
require_once dirname(__DIR__) . '/routes/user.php';
require_once dirname(__DIR__) . '/routes/admin.php';

$pdo = Database::connect();

$router = new Router($pdo);
$router->run();



