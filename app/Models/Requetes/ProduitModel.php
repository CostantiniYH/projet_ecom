<?php

// Séléctionner tous les éléments d'une table :
function getAll ($pdo, $table) {
    try {
        $sql = "SELECT * FROM $table";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " .$e->getMessage();
    }
}

// Séléctionner tous les éléments d'une table avec une jointure :
function getAll2 ($pdo, $table) {
    try {
        $sql = "SELECT $table.*, c.nom AS nom_categorie FROM $table
        INNER JOIN t_categories c ON $table.id_categorie = c.id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " .$e->getMessage();
    }
}

function getAllWhere ($pdo, $table, $condition, $param = []) {
    try {
        $sql = "SELECT $table.*, c.nom AS nom_categorie FROM $table
        INNER JOIN t_categories c ON $table.id_categorie = c.id WHERE $condition";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$param]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " .$e->getMessage();
    }
}

// Sélectionner une ligne par un ID :
function findBy1 ($pdo, $table, $champ, $id) {
    try {
        $sql = "SELECT * FROM $table WHERE $champ = ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "Erreur : " .$e->getMessage();
    }
}

// Sélectionner un élément par son ID avec jointure :
function findBy ($pdo, $table, $champ, $id) {
    try {
        $sql = "SELECT $table.*, c.nom AS nom_categorie FROM $table
        INNER JOIN t_categories c ON $table.id_categorie = c.id WHERE $table.$champ = ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "Erreur : " .$e->getMessage();
    }
}

function findBy2 ($pdo, $element, $table, $champ, $id) {
    try {
        $sql = "SELECT $element FROM $table WHERE $champ = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    } catch (PDOException $e) {
        echo "Erreur : " .$e->getMessage();
    }
}

function insert ($pdo, $table, $data) {
    try {
        $column = implode(',', array_keys($data));
        $value = implode(',', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($column) VALUES ($value)";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute(array_values($data))) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        echo "SQL : " . $sql . "\n";
        return false;
    }
}
// Modifier une data : 
function update ($pdo, $table, $data, $champ, $id) {
    try {
        $set = implode(', ', array_map(function($key) {
            return "$key = ?";
        }, array_keys($data)));

        $sql = "UPDATE $table SET $set WHERE $champ = ?";
        $stmt = $pdo->prepare($sql);

        // On ajoute la valeur du WHERE à la fin des données
        $values = array_values($data);
        $values[] = $id;

        if ($stmt->execute($values)) {
            return $stmt->rowCount(); // nombre de lignes modifiées
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        echo "SQL : " . $sql . "\n";
        return false;
    }
}


// Supprimer une data
function delete ($pdo, $table, $id, $softDelete = false) {
    try {
        if ($softDelete) {
            $query = "UPDATE $table SET deleted_at = NOW() WHERE id = ?";
        } else {
            $query = "DELETE FROM $table WHERE id = ?";
        }
        $stmt = $pdo->prepare($query);
        if ($stmt->execute([$id])) {
            return $stmt->rowCount(); // nombre de lignes supprimées
            } else {
            return false;
        }
        } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        echo "SQL : " . $query . "\n";
        return false;
        }
}
function deleteOld ($pdo, $id) {
    $query = "DELETE FROM t_produits WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}


?>