<?php

if (!defined('BASE_URL')) {
    // Détecter le protocole via le header X-Forwarded-Proto (envoyé par le proxy)
    $protocol = (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) 
        ? $_SERVER['HTTP_X_FORWARDED_PROTO'] 
        : ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http");

    $host = $_SERVER['HTTP_HOST'];

    // Détecter le préfixe via X-Forwarded-Prefix (envoyé par le proxy)
    $prefix = (!empty($_SERVER['HTTP_X_FORWARDED_PREFIX'])) 
        ? rtrim($_SERVER['HTTP_X_FORWARDED_PREFIX'], '/') 
        : '';
    
    if ($host === 'localhost' || $host === '127.0.0.1') {
        define('BASE_URL', $protocol . '://' . $host . '/projet_ecom/');
    } else {
        define('BASE_URL', $protocol . '://' . $host . $prefix . '/');
    }
}