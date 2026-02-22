<?php
declare (strict_types=1);
use Core\Routing\Route;

Route::get('/', 'HomeController@index');
Route::get('/panier', 'PanierController@index');


Route::get("/categorie/liste", "CategorieController@index");
Route::get("/categorie/formulaire", "CategorieController@create");
Route::post("/categorie/traitement", "CategorieController@store");
Route::get("/categorie/edition", "CategorieController@edit");
Route::put("/categorie/maj", "CategorieController@update");
Route::delete("/categorie/suppression", "CategorieController@delete");
Route::get("/categorie/{id}", "CategorieController@show");


Route::get("/produit/liste", "ProduitController@index");
Route::get("/produit/formulaire", "ProduitController@create");
Route::post("/produit/traitement", "ProduitController@store");
Route::get("/produit/edition", "ProduitController@edit");
Route::put("/produit/maj", "ProduitController@update");
Route::delete("/produit/suppression", "ProduitController@delete");
Route::get("/produit/{id}", "ProduitController@show");

Route::get("/image/liste", "ImageController@index");
Route::get("/image/formulaire", "ImageController@create");
Route::post("/image/traitement", "ImageController@store");
Route::get("/image/edition", "ImageController@edit");
Route::put("/image/maj", "ImageController@update");
Route::delete("/image/suppression", "ImageController@delete");
Route::get("/image/{id}", "ImageController@show");