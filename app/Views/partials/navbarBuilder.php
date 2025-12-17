<?php
use App\Views\Components\Navbar;

function buildNavbar($currentPage = '') {

    $navbar = new Navbar();
    $navbar->AddItem('e-com', '', 'left', '', '');

    if (isLoggedIn()) {
        $navbar->AddItem('','', 'center', $currentPage === 'home', 'bi bi-house-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Accueil');
        $navbar->AddItem('Catégories liste', 'categories', 'dropdown', '', '');   
        $navbar->AddItem('Produits liste', 'produits', 'dropdown', '', '');
        $navbar->AddItem('Galerie', 'images', 'dropdown', '', '');
        if (isAdmin()) {
            $navbar->AddItem('', 'dashboard_admin', 'center', '', 'bi bi-motherboard" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau admin');
        }
        $navbar->AddItem('', 'dashboard', 'center', '', 'bi bi-kanban" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Tableau de bord');
        $navbar->AddItem('', 'admin/categorie', 'center', '', 'bi bi-grid-3x3-gap-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Gestion des catégories');   
        $navbar->AddItem('', 'admin/produit', 'center', '', 'bi bi-box-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter un produit');
        $navbar->AddItem('', 'admin/image', 'center', '', 'bi bi-image" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Ajouter une image');
        $navbar->AddItem('', 'panier', 'right', '', 'bi bi-cart3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Panier');

        $navbar->AddItem('', 'javascript:location.replace("/logout")', 'right', '', 'bi bi-door-open-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-red" title="Déconnexion');
    } else {
        $navbar->AddItem('','', 'center', $currentPage === 'home', 'bi bi-house-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Accueil');
        $navbar->AddItem('Catégories', 'categories', 'center', $currentPage === 'categories', '');   
        $navbar->AddItem('Produits', 'produits', 'center', $currentPage === 'produits', '');
        $navbar->AddItem('Galerie', 'images', 'center', $currentPage === 'images', '');
        $navbar->AddItem('', 'addCategorie', 'dropdown', '', 'bi bi-grid-3x3-gap-fill');   
        $navbar->AddItem('', 'addProduit', 'dropdown', '', 'bi bi-box-fill');
        $navbar->AddItem('', 'addImage', 'dropdown', '', 'bi bi-image');
        $navbar->AddItem('', 'panier', 'right', '', 'bi bi-cart3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Panier');

        $navbar->AddItem('', 'login', 'right', '', 'bi bi-person-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Connexion');
        $navbar->AddItem('Inscription', 'register', 'right', '', '');
    }
    return $navbar;
}

function authNavbar($currentPage = '') {
    $navbar = new Navbar();
    $navbar->AddItem('e-com','', 'left', '', '');
    $navbar->AddItem('','', 'center', $currentPage === 'home', 'bi bi-house-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip" title="Accueil');
    if ($currentPage === 'register') {
        $navbar->AddItem('','login','right', $currentPage === 'login', 'bi bi-person-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="super-tooltip-right" title="Connexion');
    } else {
    $navbar->AddItem('Inscription','register','right', $currentPage === 'register', '');
    }
    return $navbar;
}