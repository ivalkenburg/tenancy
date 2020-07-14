<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Auth'], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('landlord.login');
    Route::post('/login', 'LoginController@login');
    Route::post('/logout', 'LoginController@logout')->name('landlord.logout');
    Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('landlord.password.request');
    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('landlord.password.email');
    Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('landlord.password.reset');
    Route::post('/password/reset', 'ResetPasswordController@reset')->name('landlord.password.update');
});

Route::middleware('auth:landlord')->group(function () {
    Route::get('/', 'HomeController@home')->name('landlord.home');
    Route::get('/notification', 'HomeController@notification')->name('landlord.notification');
    Route::get('/mail', 'HomeController@mail')->name('landlord.mail');
    Route::get('/event', 'HomeController@event')->name('landlord.event');

    Route::group(['prefix' => 'tenants'], function () {
        Route::get('/', 'TenantsController@index')->name('landlord.tenants.index');
        Route::get('/create', 'TenantsController@create')->name('landlord.tenants.create');
        Route::get('/{tenant}/edit', 'TenantsController@edit')->name('landlord.tenants.edit');
        Route::get('/{tenant}/login/{user}', 'TenantsController@login')->name('landlord.tenants.login');
        Route::post('/', 'TenantsController@store')->name('landlord.tenants.store');
        Route::put('/{tenant}', 'TenantsController@update')->name('landlord.tenants.update');
        Route::delete('/{tenant}', 'TenantsController@destroy')->name('landlord.tenants.destroy');
    });
});

