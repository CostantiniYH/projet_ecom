<?php
require_once __DIR__ . '/../../controllers/session.php';

$id = $_GET['id'];

if ($id) {
    $categorie = findBy1('t_categories', 'id', $id);
    $categorie = $categorie[0] ?? null;
    $categorieNom = $categorie['nom'];
    
    if ($categorie) {
        delete('t_categories', $id);
        if (isAdmin()) {
            header('Location: ' . BASE_URL . 'admin/dashboard.php?success=' . urlencode("categorie $categorieNom supprimé avec succès !"));
        } else {
            header('Location: ' . BASE_URL . 'compte/dashboard.php?success=' . urlencode("Votre categorie $categorieNom a été supprimé avec succès !"));
        }
        exit();
    } else {
        header('Location: ' . BASE_URL . 'compte/dashboard.php?erreur=categorie introuvable.');
        exit();
    }
} else {
    header('Location: ' . BASE_URL . 'compte/dashboard.php?erreur=ID categorie manquant.');
    exit();
}
?>