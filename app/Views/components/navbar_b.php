<nav class="navbar navbar-expand-lg">
    <div class="container-fluid gap-3">
        <a class="navbar-brand text-white p-2 rounded-4" href="<?= BASE_URL ?>">Marketplace YHC</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">      
            <span class="navbar-toggler-icon text-white"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center center" id="navbarSupportedContent">
            <ul class="navbar-nav gap-3">
                <li class="nav-item">
                    <a class="nav-link bi bi-house-fill fs-5 p-2" data-bs-toggle="tooltip" data-bs-placement="bottom" 
                    data-bs-custom-class="super-tooltip" title="Accueil" aria-current="page" href="<?= BASE_URL ?>"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>categorie/liste">Catégories liste</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>produit/liste">Produits liste</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>image/liste">Galerie</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Admin
                    </a>
                    <ul class="dropdown-menu">
                        <?php
                            if (isAdmin()):
                        ?>
                        <li>
                            <a class="dropdown-item bi bi-motherboard" data-bs-toggle="tooltip" data-bs-placement="bottom" 
                            data-bs-custom-class="super-tooltip-warning" title="Tableau admin" href="<?= BASE_URL ?>admin/dashboard"></a>
                        </li>
                        <li>
                            <a class="dropdown-item bi bi-kanban" data-bs-toggle="tooltip" data-bs-placement="bottom" 
                            data-bs-custom-class="super-tooltip-warning" title="Tableau de bord" href="<?= BASE_URL ?>user/dashboard"></a>
                        </li>
                        <li>
                            <a class="dropdown-item bi bi-grid-3x3-gap-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" 
                            data-bs-custom-class="super-tooltip-warning" title="Gestion des catégories" href="<?= BASE_URL ?>categorie/formulaire"></a>
                        </li>
                        <li>
                            <a class="dropdown-item bi bi-box-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" 
                            data-bs-custom-class="super-tooltip-warning" title="Ajouter un produit" href="<?= BASE_URL ?>produit/formulaire"></a>
                        </li>
                        <li>
                            <a class="dropdown-item bi bi-image" data-bs-toggle="tooltip" data-bs-placement="bottom" 
                            data-bs-custom-class="super-tooltip-warning" title="Ajouter une image" href="<?= BASE_URL ?>image/formulaire"></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="collapse navbar-collapse justify-content-end right" id="navbarSupportedContent">
            <ul class="navbar-nav gap-2">
                <?php
                    if (isLoggedIn()){
                ?>
                    <li class="nav-item">
                        <a class="nav-link bi bi-door-open-fill fs-5 p-2" data-bs-toggle="tooltip" data-bs-placement="bottom" 
                        data-bs-custom-class="super-tooltip-red" title="Deconnexion" href="<?= BASE_URL ?>auth/logout"></a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link bi bi-cart3 fs-5 p-2" data-bs-toggle="tooltip" data-bs-placement="bottom" 
                        data-bs-custom-class="super-tooltip-right" title="Panier" href="<?= BASE_URL ?>panier"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link bi bi-person-circle fs-5 p-2" data-bs-toggle="tooltip" data-bs-placement="bottom" 
                        data-bs-custom-class="super-tooltip-right" title="Connexion" href="<?= BASE_URL ?>auth/login"></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>