<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/login/{token}', 'Auth\LoginController@extLogin')->name('login.ext');
Route::get('/confirm/{token}', 'Auth\ConfirmController@show')->name('confirm.show');
Route::post('/confirm', 'Auth\ConfirmController@confirm')->name('confirm.post');

Route::totp('auth');

Route::get('/', 'HomeController@home')->name('home');
Route::get('/mail', 'HomeController@mail')->name('mail');
Route::get('/job', 'HomeController@job')->name('job');
Route::get('/cache', 'HomeController@cache')->name('cache');
Route::get('/notification', 'HomeController@notification')->name('notification');
Route::get('/settings', 'SettingsController@current')->name('settings');
Route::post('/settings', 'SettingsController@update');

Route::get('/posts', 'PostsController@index')->name('posts.index');
Route::get('/posts/create', 'PostsController@create')->name('posts.create');
Route::post('/posts', 'PostsController@store')->name('posts.store');
Route::get('/posts/{post}', 'PostsController@show')->name('posts.show');
Route::get('/posts/{post}/edit', 'PostsController@edit')->name('posts.edit');
Route::put('/posts/{post}', 'PostsController@update')->name('posts.update');
Route::delete('/posts/{post}', 'PostsController@destroy')->name('posts.destroy');

Route::get('/totp-required', 'HomeController@totpRequired')->name('totp_required');
