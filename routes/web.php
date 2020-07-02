<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'WelcomeController')->name('welcome');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/mail', 'HomeController@mail')->name('mail');
Route::get('/job', 'HomeController@job')->name('job');
Route::get('/cache', 'HomeController@cache')->name('cache');
Route::get('/settings', 'SettingsController@current')->name('settings');
Route::post('/settings', 'SettingsController@set');
