<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'WelcomeController')->name('welcome');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/mail', 'HomeController@mail')->name('mail');
