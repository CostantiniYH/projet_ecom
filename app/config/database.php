<?php
namespace App\Config;
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

