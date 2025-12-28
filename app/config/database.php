<?php
namespace App\Config;
use PDO;
use Exception;

// Singleton : Classe => connexion base de données

class Database {
     public static function connect()
    {

        // 2️⃣ Infos qui changent selon l’environnement
            $dbHost = $_ENV['DB_HOST'];
            $dbName = $_ENV['DB_NAME'];
            $dbUser = $_ENV['DB_USER'];
            $dbPass = $_ENV['DB_PASS'];
        

        // 3️⃣ Connexion à la base de données
        try {
            $pdo = new \PDO(
                "mysql:host=$dbHost;dbname=$dbName;charset=utf8",
                $dbUser,
                $dbPass
            );

            // 4️⃣ Ce qu’on renvoie
            return $pdo;

        } catch (\PDOException $e) {
            die('Erreur BDD : ' . $e->getMessage());
        }
    }
}

