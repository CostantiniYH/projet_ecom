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

class BD {
    static protected $pdo = null;
    public static function co/*nnect*/ () {
        if (self::$pdo == null) {
            try {
                $dsn = "mysql:host=localhost;dbname=db_ecom";
                $user = "root";
                $passwd = '';
                $pdo = new PDO($dsn, $user, $passwd);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo = $pdo;
            } catch(Exception $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

