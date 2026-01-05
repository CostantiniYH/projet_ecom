<?php
require_once __DIR__ . '/../../controllers/session.php';


$id = $_GET['id'];

if ($id) {
    $image = findBy1('t_images', 'id', $id);
    $image = $image[0] ?? null;
    $imageNom = $image['nom'];
    
    if ($image) {
        delete('t_images', $id);
       // var_dump(delete( 't_images', $id, true));
       // exit();
        if (isAdmin()) {
            header('Location: ' . BASE_URL . 'admin/dashboard.php?success=' . urlencode("image $imageNom supprimé avec succès !"));
        } else {
            header('Location: ' . BASE_URL . 'compte/dashboard.php?success=' . urlencode("Votre image $imageNom a été supprimé avec succès !"));
        }
        exit();
    } else {
        header('Location: ' . BASE_URL . 'compte/dashboard.php?erreur=image introuvable.');
        exit();
    }
} else {
    header('Location: ' . BASE_URL . 'compte/dashboard.php?erreur=ID image manquant.');
    exit();
}
?>