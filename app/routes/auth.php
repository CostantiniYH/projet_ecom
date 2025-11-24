<?php
use App\Core\Route;

Route::get('/login', 'AuthController@login');
Route::post('/login', 'AuthController@login');

Route::get('/register', 'AuthController@regiter');
Route::post('/register', 'AuthController@regiter');

Route::get('/logout', 'AuthController@logout');