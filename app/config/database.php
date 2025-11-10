<?php
namespace App\Config;

if (!defined('BASE_URL')) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];

       if ($host === 'localhost' || $host === '127.0.0.1') {
        // Local classique (WAMP/XAMPP)
        define('BASE_URL', $protocol . '://' . $host . '/projet_yhc/public/');
    } elseif (preg_match('/localhost:\d+/', $host)) {
        // Local avec serveur intégré PHP (ex: localhost:3000)
        define('BASE_URL', $protocol . '://' . $host . '/');
    } else {
        // Serveur distant
        define('BASE_URL', $protocol . '://' . $host . '/');
    }
}

use PDO;
use Exception;

class Database {
    public static function connect () {
        try {
            $dsn = "mysql:host=localhost;dbname=yhc";
            $user = "YHC";
            $passwd = "";

            $pdo = new PDO($dsn, $user, $passwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;

        } catch(Exception $e) {
            echo "Erreur: " .$e->getMessage();   
            return null;
        }
    }
}

