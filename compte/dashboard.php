<?php
require_once __DIR__ . '/../controllers/session.php';
require_once __DIR__ . '/../components/header.php';
require_once __DIR__ . '/../class/navbar.php';

require_login();

$pdo = connect();

if (!isset($_SESSION['user'])) {
    die("Erreur : utilisateur non connecté.");
} 

$user = $_SESSION['user'];
$id = $_SESSION['user']['id'];
$myProduits = findBy($pdo, 't_produits', 'id_user', $id);
$myImage = findBy($pdo, 't_images', 'id_user', $id);

$navbar = new Navbar();
    $navbar->AddItem('|| YHC ||','index.php', 'left', '', '');
    $navbar->AddItem('','index.php','center', '', 'bi bi-house-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Accueil');
    $navbar->AddItem('Catégories liste', 'categories.php', 'dropdown', '', '');   
    $navbar->AddItem('Produits liste', 'produits.php', 'dropdown', '', '');
    $navbar->AddItem('Galerie','image.php','dropdown', '', '');
        if (isAdmin()) {
            $navbar->AddItem('', 'admin/dashboard.php', 'center', '', 'bi bi-motherboard" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau admin');
        }
    $navbar->AddItem('', 'compte/dashboard.php', 'center', true, 'bi bi-kanban" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau de bord');
    $navbar->AddItem('', 'Form/Crud/categorie.php', 'center', '', 'bi bi-grid-3x3-gap-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Gestion des catégories');   
    $navbar->AddItem('', 'Form/Crud/produit.php','center', '', 'bi bi-box-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter un produit');
    $navbar->AddItem('', 'Form/Crud/image.php', 'center', '', 'bi bi-image" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter une image');
    $navbar->AddItem('', 'compte/panier.php', 'right', '', 'bi bi-cart3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Panier');
    $navbar->AddItem('', 'javascript:location.replace(BASE_URL + "logout.php")','right', '', 'bi bi-door-open-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-red" title="Déconnexion');
$navbar->render();
?>

<div class="container mt-2">
    <?php require_once __DIR__ . '/../components/alerts.php'; ?>

    <p class="mt-2 border border-2 border-success p-3 rounded mb-3">Vous êtes connecté en tant que <?= $user['email']; ?></p>
    <h1 class="shadow rounded p-4">Dashboard <?= $user['nom']; ?> <?= $user['prenom']; ?></h1>

    <img class="bandeau rounded-4 shadow" src="<?= BASE_URL . $user['photo']; ?>">
    <div class="row mt-5 gap-5">
        <div class="col-md table-responsive">
            <div class="p-3 shadow rounded border border-1 border-success mb-5">
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
             <div class="p-3 shadow rounded border border-1 border-success mt-5">
            <table class="table mt-2">
                <h3>Mes images</h3>
                <?php 
                if (!empty($myImage[0]) && isset($image[0])) {
                    $fields = array_keys($myImage[0]);
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
                <td><div class="alert alert-warning alert-dismissible fade show" data-bs-dismiss="3000" role="alert">Vous n'avez pas encore ajouté d'image</div></td>
            </tr>
            <?php } ?>
            </table>
            </div>
        </div>
        <div class="p-3 col-md flex-end shadow rounded border border-1 border-success table-responsive">
            <table class="table">
                <h3>Mes produits</h3>
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
        </div>
    </div>
</div>
<?php 
require_once __DIR__ . '/../components/footer.php'
?>