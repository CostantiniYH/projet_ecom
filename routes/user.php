<?php
use Core\Routing\Route;

Route::get('/user/dashboard', 'UserController@dashboard');
Route::get('/user/modifier{id}', 'UserControlle@edit');
Route::get('/user/update', 'UserController@update');
Route::delete('/user/supression{id}', 'UserController@delete');