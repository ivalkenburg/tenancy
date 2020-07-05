<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tenants');

Route::group(['prefix' => 'tenants'], function () {
    Route::get('/', 'TenantsController@index')->name('landlord.tenants.index');
    Route::get('/create', 'TenantsController@create')->name('landlord.tenants.create');
    Route::get('/{tenant}/edit', 'TenantsController@edit')->name('landlord.tenants.edit');
    Route::post('/', 'TenantsController@store')->name('landlord.tenants.store');
    Route::put('/{tenant}', 'TenantsController@update')->name('landlord.tenants.update');
    Route::delete('/{tenant}', 'TenantsController@destroy')->name('landlord.tenants.destroy');
});
