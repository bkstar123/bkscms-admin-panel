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
        'namespace' => 'Bkstar123\BksCMS\AdminPanel\Http\Auth',
        'middleware' => [
            'web',
        ],
    ],
    function () {
        Route::get('admins/login', 'LoginController@showLoginForm')
            ->name('admins.login');
        Route::post('admins/login', 'LoginController@login');
        Route::post('admins/logout', 'LoginController@logout')
            ->name('admins.logout');
    }
);
