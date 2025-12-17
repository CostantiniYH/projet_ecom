<?php
// require_once __DIR__ . '/../test_db.php';
// print_r(dirname(__DIR__));


require_once __DIR__ . '/../app/routes/web.php';
require_once __DIR__ . '/../app/routes/auth.php';
require_once __DIR__ . '/../app/routes/user.php';
require_once __DIR__ . '/../app/routes/admin.php';

require_once __DIR__ . '/coreTemp/session.php';
require_once __DIR__ . '/Models/Requetes/model.php';
require_once __DIR__ . '/Models/Requetes/ProduitModel.php';
require_once __DIR__ . '/Views/partials/navbarBuilder.php'; 



$configFile = __DIR__ . '/config/config.php';
if (file_exists($configFile)) {
    require_once $configFile;
}
