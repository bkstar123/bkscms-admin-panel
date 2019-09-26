<?php
/**
 * @author: tuanha
 * @last-mod: 02-Sept-2019
 */

/**
 * Authentication routes
 */
Route::group(
    [
        'prefix' => 'admins',
        'namespace' => 'Bkstar123\BksCMS\AdminPanel\Http\Controllers\Auth',
        'middleware' => [
            'web',
        ],
    ],
    function () {
        Route::get('/login', 'LoginController@showLoginForm')
            ->name('admins.login');

        Route::post('/login', 'LoginController@login');

        Route::post('/logout', 'LoginController@logout')
            ->name('admins.logout');

        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')
            ->name('admins.password.request');

        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')
            ->name('admins.password.email')
            ->middleware('bkscms-disabled');

        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')
            ->name('admins.password.reset');

        Route::post('/password/reset', 'ResetPasswordController@reset')
            ->name('admins.password.update');
    }
);

/**
 * Admin management resource routes
 *
 */
Route::group(
    [
        'prefix' => 'admins',
        'namespace' => 'Bkstar123\BksCMS\AdminPanel\Http\Controllers',
        'middleware' => [
            'web', 'bkscms-auth:admins',
        ],
    ],
    function () {
        Route::match(['get', 'head'], '/', 'AdminController@index')->name('admins.index');
        Route::post('/', 'AdminController@store')->name('admins.store');
        Route::match(['get', 'head'], '/create', 'AdminController@create')->name('admins.create');
        Route::match(['get', 'head'], '/{admin}', 'AdminController@show')->name('admins.show');
        Route::match(['put', 'patch'], '/{admin}', 'AdminController@update')->name('admins.update');
        Route::delete('/{admin}', 'AdminController@destroy')->name('admins.destroy');
        Route::match(['get', 'head'], '/{admin}/edit', 'AdminController@edit')->name('admins.edit');


        Route::patch('/{admin}/disabling', 'AdminController@offStatus')
            ->name('admins.disabling');
        Route::patch('/{admin}/activating', 'AdminController@onStatus')
            ->name('admins.activating');
    }
);
