<?php

use App\Helpers\Route;

Route::get('/', 'HomeController@index');
Route::get('/index.php', 'HomeController@index');
Route::get('/test', 'HomeController@test');
Route::get('/user/{id}', 'HomeController@get_user');
// Route::post('/user/update', 'HomeController@update_user');
