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
