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
        Route::get('/', 'AdminController@index')->name('admins.index');
        Route::post('/', 'AdminController@store')->name('admins.store');
        Route::get('/create', 'AdminController@create')->name('admins.create');
        Route::get('/{admin}', 'AdminController@show')->name('admins.show');
        Route::patch('/{admin}', 'AdminProfileController@update')
            ->name('admins.profile.update');
        Route::delete('/{admin}', 'AdminController@destroy')->name('admins.destroy');

        Route::patch('/{admin}/disabling', 'AdminController@offStatus')
            ->name('admins.disabling');
        Route::patch('/{admin}/activating', 'AdminController@onStatus')
            ->name('admins.activating');
        Route::delete('/', 'AdminController@massiveDestroy')
            ->name('admins.massiveDestroy');
        Route::patch('/{admin}/change-password', 'AdminController@changePassword')
            ->name('admins.password.change');
        Route::post('/upload-avatar', 'AdminProfileController@uploadAvatar')
            ->name('admins.avatar.upload');
    }
);
