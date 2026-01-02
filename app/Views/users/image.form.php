<?php
require_login();

if (isLoggedIn()) {
    echo "Vous êtes connecté";
}

use App\Config\Database;
$categories = getAll('t_categories');
$images = getAll('t_images');

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

$image = null;
if ($id) {
    $image = findBy ('t_images', 'id', $id);
    $image = $image[0] ?? null;
}

ob_start();
?>
<div class="container mb-5 mt-5">
    <h1 class="mb-5 shadow rounded-4 border-start border-end border-2 border-success">Gestion de la galerie</h1>

    <div class="row mb-4 gap-4">
        <form action="<?= BASE_URL ?>controllers/Create-Update/image.php" method="post" class="col-md-5 mb-5 p-2 shadow-lg
         rounded-4 border border-1 border-success" data-aos="zoom-in" enctype="multipart/form-data">
            <?php if ($id) { ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($image['id']) ?>">
                <h2 class="text-center">Modifier l'image</h2>
            <?php } else { ?>
                <h2 class="text-center">Ajouter une image</h2>
            <?php } ?>
            <div class="form-group m-4">
                <label for="nom" class="mb-2">Nom de l'image</label>
                <input value="<?= htmlspecialchars($image['nom'] ?? '') ?>" type="text" class="form-control" id="nom" name="nom"
                placeholder="Entrez le nom" required>
            </div>
            <div class="form-group m-4">
                <label for="categorie" class="mb-2">Catégorie</label>
                <select class="form-select" id="categorie" name="categorie">
                    <option value="<?= htmlspecialchars($image['id_categorie'] ?? '') ?>"><?= htmlspecialchars($image['nom_categorie'] ?? '') ?> </option>
                    <?php                    
                    foreach ($categories as $categorie) : ?>
                    <option value="<?= $categorie['id']; ?>"><?php echo $categorie['nom'] ?? ''; ?></option>
                    <?php endforeach; ?>                        
                </select>
            </div>
            <div class="form-group m-4">
                <label for="image" class="mb-2">Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="form-group m-4">
                <input type="submit" class="btn btn-primary" value="Ajouter">
            </div>
        </form>
        <div class="col-md shadow rounded-4 p-3 border border-1 border-primary">
            <h3 class="text-center">Images existantes</h3>
            <div class="row">
            <?php foreach ($images as $image => $value) { ?>
                <div class="col-md-3 mb-2">
                    <?php require __DIR__ . '/../../components/image.php'; ?>
                </div>
            <?php } ?>
            </div>
        </div>                    
    </div>
</div>
<?php 
$content = ob_get_clean(); 
$titre = "Ajouter/Modifier une image";
require_once __DIR__ . '/../partials/layout.php';
?>      
