<?php

$configFile = __DIR__ . '/config/database.php';
if (file_exists($configFile)) {
    require_once $configFile;
}

require_once dirname(__DIR__) . '/routes/web.php';
require_once dirname(__DIR__) . '/routes/auth.php';
require_once dirname(__DIR__) . '/routes/user.php';
require_once dirname(__DIR__) . '/routes/admin.php';

use App\Config\Database;
$pdo = Database::connect();

use Core\Router;
$router = new Router($pdo);
$router->run();

require_once __DIR__ . '/coreTemp/session.php';
require_once __DIR__ . '/Models/Requetes/model.php';
require_once __DIR__ . '/Views/partials/navbarBuilder.php'; 


