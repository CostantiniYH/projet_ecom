<?php
declare (strict_types=1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

require dirname(__DIR__) . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

require dirname(__DIR__) . '/core/init.php';

use App\Config\Database;

$pdo = Database::connect();

$router = new App\Core\Router($pdo);
$router->run();

?>