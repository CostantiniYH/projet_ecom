<div class="container mb-5 mt-5">
    <section class="row mb-4 gap-4">
        <div class="col-md">
            <form action="<?= BASE_URL ?>categorie/traitement" method="post" class="h-100 mb-5 p-2 shadow-lg
            rounded-4 border border-1 border-success" data-aos="zoom-in" enctype="multipart/form-data">

                <?php if ($id) { ?>
                    <h2 class="text-center">Modifier la catégorie</h2>
                <?php } else { ?>
                    <h2 class="text-center">Ajouter une catégorie</h2>
                <?php } ?>

                <div class="form-group m-4">
                    <input value="<?= $categorie['id'] ?? '' ?>" type="hidden" name="id">
                    <label for="nom" class="mb-2">Nom de la catégorie</label>
                    <input value="<?= htmlspecialchars($categorie['nom'] ?? '' ) ?>" type="text" 
                    class="form-control" id="nom" name="nom" required>
                </div>
                <div class="form-group m-4">
                    <label for="image" class="mb-2">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <div class="form-group m-4">
                    <input type="submit" class="btn btn-primary" value="<?= $id ? 'Modifier' : 'Ajouter' ?>">
                </div>
            </form>
        </div>


        <div class="col-md">
            <div class="shadow rounded-4 p-3 border border-1 border-primary h-100">
                <h3 class="text-center">Catégories existantes</h3>
                <div class="row">
                    <?php foreach ($categories as $categorie) { ?>
                    <div class="col-md-4 mb-5">
                        <?php require dirname(__DIR__) . '/components/mini_categorie.php'; ?>
                    </div>
                    <?php } ?>
                </div>
            </div>                    
        </div>
    </section>
</div>
