<?php
use Core\Routing\Route;

Route::get('/login', 'AuthController@login');
Route::post('/login', 'AuthController@login');

Route::get('/register', 'AuthController@regiter');
Route::post('/register', 'AuthController@regiter');

Route::get('/logout', 'AuthController@logout');