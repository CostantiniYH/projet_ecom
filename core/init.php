<?php
declare (strict_types=1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

$configFile = __DIR__ . '/app/config/database.php';
if (file_exists($configFile)) {
    require_once $configFile;
}

require dirname(__DIR__) . '/app/config/config.php';
require dirname(__DIR__) . '/app/Views/partials/navbarBuilder.php'; 
require dirname(__DIR__) . '/app/coreTemp/session.php';
require dirname(__DIR__) . '/app/Models/Requetes/ProduitModel.php';

require_once dirname(__DIR__) . '/routes/web.php';
require_once dirname(__DIR__) . '/routes/auth.php';
require_once dirname(__DIR__) . '/routes/user.php';
require_once dirname(__DIR__) . '/routes/admin.php';

use App\config\Database;
$pdo = Database::connect();

use Core\Routing\Router;
$router = new Router($pdo);
$router->run();



