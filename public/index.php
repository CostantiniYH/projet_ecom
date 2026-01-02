<?php
declare (strict_types=1);
ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/../app/init.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
if ($base !== '' && strpos($uri, $base) === 0) {
    $uri = substr($uri, strlen($base));
}
$uri = $uri ?? '/';

require_once __DIR__ . '/../app/routes/web.php';
require_once __DIR__ . '/../app/routes/auth.php';
require_once __DIR__ . '/../app/routes/user.php';
require_once __DIR__ . '/../app/routes/admin.php';

use App\Core\Router;
use App\Config\Database;

$router = new Router();
$router->run();

?>