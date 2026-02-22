<?php
use Core\Routing\Route;

Route::get('/auth/login', 'AuthController@formLogin');
Route::post('/auth/login', 'AuthController@login');

Route::get('/auth/register', 'AuthController@formRegister');
Route::post('/auth/register', 'AuthController@register');

Route::get('/auth/logout', 'AuthController@logout');