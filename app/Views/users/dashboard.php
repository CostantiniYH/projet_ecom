<div class="container mt-2">
    <p class="mt-2 border border-2 border-success p-3 rounded mb-3">Vous êtes connecté en tant que <?= $user['email']; ?></p>
    <h1 class="shadow rounded p-4">Dashboard <?= $user['nom']; ?> <?= $user['prenom']; ?></h1>

    <img class="bandeau rounded-4 shadow" src="<?= BASE_URL . $user['photo']; ?>">
    <div class="row mt-5">
        <div class="col-md">
            <div class="p-3 h-100 shadow rounded border border-1 border-success mb-3 table-responsive">
                <table class="table mt-2">
                    <h3>Mes informations</h3>
                    <tr class="">
                        <th>Nom</th>
                        <td> <?= $user['nom']?> </td>
                    </tr>
                    <tr>
                        <th>Prénom</th>
                        <td> <?= $user['prenom']?> </td>
                    </tr>
                    <tr>
                        <th class="">Email</th>
                        <td> <?= $user['email']; ?> </td>
                    </tr>
                    <tr>    
                        <th class="">Téléphone</t>
                        <td> <?= $user['telephone']; ?> </td>
                    </th>
                    <tr>
                        <th class="">Société</th>  
                        <td> <?= $user['societe']; ?> </td>
                    </tr>
                    <tr>
                        <th>Photo profil</th>              
                        <td> <img width="100" class="rounded" src="<?= BASE_URL . $user['photo']; ?>"> </td>
                    </tr>
                </table>
            </div>   
        </div>         
        <div class="col-md">
            <div class="p-3 h-100 shadow rounded border border-1 border-success mb-3 table-responsive">
                <h3>Mes images</h3>
                 <div class="row g-3">
                     <?php foreach ($myImages as $image): ?>
                     <div class="col-md">
                        <div class="card h-100">
                            <div class="card-img-top">
                                <img class="img-fluid w-100" style="height: 8rem;" src="<?= BASE_URL.$image['image'] ?>" alt="">
                            </div>
                            <div class="card-body">
                                <h5><?= $image['nom'] ?></h5>
                                <p><?= $image['nom_categorie'] ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
              
            </div>      
        </div>
    </div>
    <div class="row mt-5">
        <div>
            <div class="p-2 shadow rounded border border-1 border-success">
                <h3>Mes produits en cartes</h3>
                <div class="row">
                    <?php 
                    if (!empty($myProduits) && isset($myProduits)) {
                        foreach ($myProduits as $value) { ?>
                            <div class="col-md mb-2">
                                <div class="card border-0 shadow hvr-shadow-radial position-relative"  style="width: 15rem; height: 12rem;">
                                    <?php if ($value['quantite'] > 0) { ?>
                                        <small class="badge bg-success position-absolute checked" data-bs-dismiss="3000" 
                                        role="alert"><?= $value['quantite']; ?>
                                        </small>
                                    <?php } else { ?>
                                        <small  class="alert alert-danger alert-dismissible fade show" data-bs-dismiss="3000" 
                                        role="alert">0
                                        </small>
                                    <?php
                                    }
                                    ?>
                                    <img src="<?= BASE_URL . $value['image']; ?>" class="card-img-top card-img" 
                                    alt="<?= $value['nom']; ?>" style="height: 5rem; object-fit: cover;" usemap="#map<?= $value['id']; ?>">
                                    <map name="map<?= $value['id']; ?>">
                                        <area shape="rect" coords="0,0,300,200" href="<?= BASE_URL ?>produit_one?id=<?= $value['id']; ?>"
                                        <?= $value['status'] == "0" ? 'aria-disabled="true" onclick="return false;"' : "" ?>>
                                    </map>
                                    <div class="card-body">
                                        <p class="card-title"><?= $value['nom']; ?></p>
                                        <small class="card-text"><?= $value['nom_categorie']; ?> </small>
                                        <p class="card-text"><?= $value['prix']; ?><?= $value ['devise']; ?></p>
                                    </div>
                                </div>
                            </div>
                    <?php 
                        }
                    } else { ?>
                        <div class="alert alert-warning alert-dismissible fade show" data-bs-dismiss="3000" role="alert">Vous n'avez pas encore ajouté de produit</div>                        
                    <?php 
                    } ?>                
                </div>
            </div>
        </div>
    </div>
</div>



            <!-- <div class="p-3 shadow rounded border border-1 border-success mb-3 table-responsive">
                <table class="table">
                    <h3>Mes produits en tableau</h3>
                    <?php
                    if (!empty($myProduits) && isset($myProduits)) {
                        $fields = array_keys($myProduits[0]);
                        foreach ($fields as $field) {
                            $label = preg_replace('/[^a-zA-Z0-9]/', ' ', $field);
                    ?>                
                    <tr>
                        <th><?= ucfirst($label)?></th>
                        <?php foreach ($myProduits as $mP) { ?>
                        <td>
                            <?php if ($field === 'image') { ?>
                                <img width="100" src="<?= BASE_URL . $mP[$field] ?>">
                            <?php } else { ?>
                                <?= $mP[$field]; ?>
                            <?php } ?>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php }
                    } else { ?>
                        <tr>
                            <td>
                            <div class="alert alert-warning alert-dismissible fade show" data-bs-dismiss="3000" role="alert">Vous n'avez pas encore ajouté de produit</div>
                            </td>
                        </tr>
                        <?php } ?>
                </table>
            </div>      -->

              <!-- <table class="table mt-2">
                    <?php 
                    if (!empty($myImages[0])) {
                        $fields = array_keys($myImages[0]);
                        foreach ($fields as $field) {
                            $label = preg_replace('/[^a-zA-Z0-9]/', ' ', $field);
                    ?>                
                    <tr>
                        <th><?= ucfirst($label)?></th>
                        <?php foreach ($myImages as $mI) { ?>
                        <td>
                            <?php if ($field === 'image') { ?>
                                <img width="100" src="<?= BASE_URL . $mI[$field] ?>">
                            <?php } else { ?>
                                <?= $mI[$field]; ?>
                            <?php } ?>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php } 
                } else { ?>
                <tr>
                    <td><div class="alert alert-warning alert-dismissible fade show" data-bs-dismiss="3000" role="alert">Vous n'avez pas encore ajouté d'image</div></td>
                </tr>
                <?php } ?>
                </table> -->