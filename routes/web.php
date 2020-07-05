<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['confirm' => false, 'verify' => false]);

Route::get('/', 'HomeController@home')->name('home');
Route::get('/mail', 'HomeController@mail')->name('mail');
Route::get('/job', 'HomeController@job')->name('job');
Route::get('/cache', 'HomeController@cache')->name('cache');
Route::get('/settings', 'SettingsController@current')->name('settings');
Route::post('/settings', 'SettingsController@update');
