<div class="container mb-5 mt-5">       
    <h1 class="mb-5 shadow rounded-4 border-start border-end border-2 border-success"> 
        <?php
            $categorie = findBy2 ('nom, id', 't_categories', 'id',$id);
            
            if (!empty($_GET['id'])) {
                    echo 'Produits ' . htmlspecialchars($categorie['nom']);
                   // echo ' (ID: ' . htmlspecialchars($categorie['id']) . ')';
            } else {
                echo 'Tous les produits';
            }
        ?>
    </h1>     
    <div class="row gy-5 text-center">
        <?php 
            if (!empty($_GET['id'])) {

                foreach ($produitID as $row => $value) {
                ?>
                    <div class="col-md-4" data-aos="fade-up" data-aos-duration="2000">
                        <?php require __DIR__ . '/components/card.php'; ?> </br>
                    </div>
                <?php 
                }
            } else {                
                foreach ($produits as $row => $value) {
                ?>
                    <div class="col-md-4" data-aos="fade-up" data-aos-duration="2000" data-bs-toggle="
                    tooltip" data-bs-placement="top" title="<?= $value['nom'] ?>">
                        <?php require __DIR__ . '/components/card.php'; ?> 
                        </br>
                    </div>
                <?php 
                }
            }
        ?>
    </div>   
</div>  