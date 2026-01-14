<?php
require_login();

$categories = getAll( 't_categories');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID invalide.");
}

$id = intval($_GET['id']); // Sécurisation

$up_produit = findBy( 't_produits', 'id', $id);

if (!$up_produit || empty($up_produit)) {
    die("Produit introuvable.");
}

$up_produit = $up_produit[0] ?? null; // Vérifier si le produit existe

?>

<div class="container">
    <?php require_once __DIR__ . '/../../components/alerts.php'; ?>

            
    <div class="row gap-4">
        <form action="<?= BASE_URL ?>controllers/Create-Update/up_produit.php" method="post" enctype="multipart/form-data" 
        class="col-md-5 rounded-4 shadow p-5 border border-2 border-warning" 
        data-aos="fade-in-zoom" data-aos-duration="1500">
        
            <h2 class="text-center">Modifiez votre produit</h2>
            <div class="form-group">
                <input type="hidden" name="id" value="<?= $up_produit['id'] ?>">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= $up_produit['nom'] ?>">
            </div><br>
            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="number" class="form-control" id="prix" name="prix" value="<?= $up_produit['prix'] ?>">
            </div><br>
            <div class="form-group">
                <label for="devise">Devise</label>
                <select class="form-control" id="devise" name="devise">
                    <option value="€" <?= $up_produit['devise'] == '€' ? ' selected' : '' ?>>€</option>
                    <option value="$" <?= $up_produit['devise'] == '$' ? 'selected' : '' ?>>$</option>
                    <option value="£" <?= $up_produit['devise'] == '£' ? ' selected' : '' ?>>£</option>
                </select>
            </div><br>
            <div class="form-group">
                <label for="quantite">Quantité</label>
                <input type="number" class="form-control" id="quantite" name="quantite" value="<?= $up_produit['quantite'] ?>">
            </div>
            <br><br>
            <div class="form-group">
                <label for="id_categorie">Catégorie</label>
                <select class="form-select" id="id_categorie" name="id_categorie">
                <option value="<?= $up_produit['id_categorie'];?>" selected><?= $up_produit['nom_categorie']; ?></option>
                    <?php                    
                    foreach ($categories as $categorie) : ?>
                        <option value="<?= $categorie['id']; ?>">
                            <?php echo $categorie['nom']; ?>
                        </option>
                    <?php endforeach; ?>    
                </select>
            </div><br>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" id="image" name="image" value="<?= $up_produit['image'] ?>">
            </div><br>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" value="<?= 
                $up_produit ['description']?>"><?= $up_produit ['description']?></textarea> 
            </div><br>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
        <div class="col shadow rounded-4 p-3 border border-1 border-warning">
            <h2>Produit à modifier</h2>            
            <?php 
                $value = $up_produit;
                require_once __DIR__ . '/../../components/card_modifie.php';       
            
            ?>
        </div>
    </div>
</div>



<?php
require_once __DIR__ . '/../../components/footer.php';
?>