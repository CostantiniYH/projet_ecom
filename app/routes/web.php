<?php
declare (strict_types=1);
use App\Core\Route;

Route::get('/', 'HomeController@index');
Route::get('/categories', 'CategorieController@index');
Route::get('/produits', 'ProduitController@liste_produits');
Route::get('/produit_one', 'ProduitController@detail_produit');
Route::get('/images', 'ImageController@index');
Route::get('/panier', 'PanierController@index');
