<?php

if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    exit('Accès direct interdit.');
}

session_start();

function isLoggedIn() {
    return isset($_SESSION['user']);
}
function getUserSession() {
    return isLoggedIn() ? $_SESSION['user'] : null;
}

function isAdmin() {
    return isLoggedIn() && ($_SESSION['user']['role'] ?? '') === 'admin';
}

function loginUser($user) {
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => $user['id'],
        'nom' => $user['nom'],
        'prenom' => $user['prenom'],
        'email' => $user['email'],
        'telephone' => $user['telephone'],
        'societe' => $user['societe'],
        'photo' => $user['photo'],
        'role' => $user['role'],
    ];
}

function require_login() {
    if (!isLoggedIn()) {
        header('Location: /login?=message=Veuillez vous connecter.');
        exit();
    }
}
function logoutUser() {
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');
    header('Location: /?succes=Vous vous êtes déconnecté avec succès.');
    exit();
}
?>
