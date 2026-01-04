<?php
use App\Core\Route;

Route::get('/login', 'AuthController@loginGet');
Route::post('/login', 'AuthController@loginPost');

Route::get('/register', 'AuthController@registerGet');
Route::post('/register', 'AuthController@registerPost');

Route::get('/logout', 'AuthController@logout');