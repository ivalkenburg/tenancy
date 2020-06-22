<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['domain' => 'landlord.localhost'], function () {
    Route::get('/', 'TenantsController@index')->name('tenants.index');
    Route::get('/create', 'TenantsController@create')->name('tenants.create');
    Route::get('/{tenant}/edit', 'TenantsController@edit')->name('tenants.edit');
    Route::post('/', 'TenantsController@store')->name('tenants.store');
    Route::put('/{tenant}', 'TenantsController@update')->name('tenants.update');
    Route::delete('/{tenant}', 'TenantsController@destroy')->name('tenants.destroy');
});

Route::group(['middleware' => 'tenant.aware'], function () {
    Auth::routes();

    Route::get('/', 'WelcomeController')->name('welcome');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/mail', 'HomeController@mail')->name('mail');
});
