<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'TenantsController@index')->name('tenants.index');
Route::get('/create', 'TenantsController@create')->name('tenants.create');
Route::get('/{tenant}/edit', 'TenantsController@edit')->name('tenants.edit');
Route::post('/', 'TenantsController@store')->name('tenants.store');
Route::put('/{tenant}', 'TenantsController@update')->name('tenants.update');
Route::delete('/{tenant}', 'TenantsController@destroy')->name('tenants.destroy');
