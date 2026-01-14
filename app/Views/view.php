<?php

function afficher($navbarType, $titre, $template, $data = [])
{
    $navbar = buildNavbar($navbarType);
    extract($data);
    ob_start();
    require_once "{$template}.php";
    $content = ob_get_clean();
    require_once "partials/layout.php";
}
?>