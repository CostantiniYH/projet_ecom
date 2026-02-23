<?php
namespace App\Config;
use PDO;
use Exception;

class Database {
    public static function connect () {
        $host   =   $_ENV['DB_HOST'];
        $type   =   $_ENV['DB_TYPE'];
        $user   =   $_ENV['DB_USER'];
        $pass   =   $_ENV['DB_PASS'];
        $db     =   $_ENV['DB_NAME'];
        $option = [
            PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES      => false,      
        ];
        $dsn = "$type:host=$host;dbname=$db";

        try {
            $pdo = new PDO($dsn, $user, $pass, $option);

            return $pdo;
        } catch(Exception $e) {
            echo "Erreur: " .$e->getMessage();   
            return null;
        }
    }
}

