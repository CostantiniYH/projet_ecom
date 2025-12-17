<?php
namespace App\Config;

if (!defined('BASE_URL')) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];

       if ($host === 'localhost' || $host === '127.0.0.1') {
        define('BASE_URL', $protocol . '://' . $host . '/projet_ecom/public/');
        } else {
            define('BASE_URL', $protocol . '://' . $host . '/');
        }
}

use PDO;
use Exception;

// Singleton : Classe => connexion base de données

class Database {
    public static function connect () {
        try {
            $dsn = "mysql:host=localhost;dbname=db_ecom";
            $user = "root";
            $passwd = '';

            $pdo = new PDO($dsn, $user, $passwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;

        } catch(Exception $e) {
            echo "Erreur: " .$e->getMessage();   
            return null;
        }
    }
}

