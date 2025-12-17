<?php
use App\Core\Route;

Route::get('/login', 'AuthController@login');
Route::post('/login', 'AuthController@login');

Route::get('/register', 'AuthController@register');
Route::post('/register', 'AuthController@register');

Route::get('/logout', 'AuthController@logout');