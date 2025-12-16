<?php

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';
    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        return ;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

require_once __DIR__ . '/coreTemp/session.php';
require_once __DIR__ . '/Models/Requetes/model.php';
require_once __DIR__ . '/Models/Requetes/ProduitModel.php';
require_once __DIR__ . '/Views/partials/navbarBuilder.php'; 


$configFile = __DIR__ . '/config/database.php';
if (file_exists($configFile)) {
    require_once $configFile;
}
