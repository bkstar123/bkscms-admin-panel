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
        'prefix' => 'cms',
        'namespace' => 'Bkstar123\BksCMS\AdminPanel\Http\Controllers\Auth',
        'middleware' => [
            'web',
        ],
    ],
    function () {
        Route::get('/admins/login', 'LoginController@showLoginForm')
            ->name('admins.login');
        Route::post('/admins/login', 'LoginController@login');
        Route::post('/admins/logout', 'LoginController@logout')
            ->name('admins.logout');
        Route::get('/admins/password/reset', 'ForgotPasswordController@showLinkRequestForm')
            ->name('admins.password.request');
        Route::post('/admins/password/email', 'ForgotPasswordController@sendResetLinkEmail')
            ->name('admins.password.email')
            ->middleware('bkscms-disabled');
        Route::get('/admins/password/reset/{token}', 'ResetPasswordController@showResetForm')
            ->name('admins.password.reset');
        Route::post('/admins/password/reset', 'ResetPasswordController@reset')
            ->name('admins.password.update');
    }
);

/**
 * Admin management resource routes
 *
 */
Route::group(
    [
        'prefix' => 'cms',
        'namespace' => 'Bkstar123\BksCMS\AdminPanel\Http\Controllers',
        'middleware' => [
            'web', 'bkscms-auth:admins',
        ],
    ],
    function () {
        Route::get('/admins', 'AdminController@index')->name('admins.index');
        Route::post('/admins', 'AdminController@store')->name('admins.store');
        Route::get('/admins/create', 'AdminController@create')->name('admins.create');
        Route::get('/admins/{admin}', 'AdminController@show')->name('admins.show');
        Route::patch('/admins/{admin}', 'AdminProfileController@update')
            ->name('admins.profile.update');
        Route::delete('/admins/{admin}', 'AdminController@destroy')->name('admins.destroy');
        Route::patch('/admins/{admin}/disabling', 'AdminController@offStatus')
            ->name('admins.disabling');
        Route::patch('/admins/{admin}/activating', 'AdminController@onStatus')
            ->name('admins.activating');
        Route::delete('/admins', 'AdminController@massiveDestroy')
            ->name('admins.massiveDestroy');
        Route::patch('/admins/{admin}/change-password', 'AdminController@changePassword')
            ->name('admins.password.change');
        Route::post('/admins/upload-avatar', 'AdminProfileController@uploadAvatar')
            ->name('admins.avatar.upload');
    }
);

/**
 * Role management resource routes
 *
 */
Route::group(
    [
        'prefix' => 'cms',
        'namespace' => 'Bkstar123\BksCMS\AdminPanel\Http\Controllers',
        'middleware' => [
            'web', 'bkscms-auth:admins',
        ],
    ],
    function () {
        Route::get('/roles', 'RoleController@index')->name('roles.index');
        Route::post('/roles', 'RoleController@store')->name('roles.store');
        Route::get('/roles/create', 'RoleController@create')->name('roles.create');
        Route::get('/roles/{role}', 'RoleController@show')->name('roles.show');
        Route::patch('/roles/{role}', 'RoleController@update')
            ->name('roles.update');
        Route::delete('/roles/{role}', 'RoleController@destroy')->name('roles.destroy');
        Route::patch('/roles/{role}/disabling', 'RoleController@offStatus')
            ->name('roles.disabling');
        Route::patch('/roles/{role}/activating', 'RoleController@onStatus')
            ->name('roles.activating');
        Route::delete('/roles', 'RoleController@massiveDestroy')
            ->name('roles.massiveDestroy');
    }
);

/**
 * Role assignment/revoke routes
 *
 */
Route::group(
    [
        'prefix' => 'cms',
        'namespace' => 'Bkstar123\BksCMS\AdminPanel\Http\Controllers',
        'middleware' => [
            'web', 'bkscms-auth:admins',
        ],
    ],
    function () {
        Route::post('/admins/{admin}/roles', 'AdminRoleController@assignRoles')
            ->name('admins.roles.assign');
        Route::post('roles/revoke/{role}', 'AdminRoleController@revoke')
            ->name('roles.revoke');
    }
);

/**
 * Permission management resource routes
 *
 */
Route::group(
    [
        'prefix' => 'cms',
        'namespace' => 'Bkstar123\BksCMS\AdminPanel\Http\Controllers',
        'middleware' => [
            'web', 'bkscms-auth:admins',
        ],
    ],
    function () {
        Route::get('/permissions', 'PermissionController@index')->name('permissions.index');
        Route::post('/permissions', 'PermissionController@store')->name('permissions.store');
        Route::get('/permissions/create', 'PermissionController@create')->name('permissions.create');
        Route::get('/permissions/{permission}', 'PermissionController@show')->name('permissions.show');
        Route::patch('/permissions/{permission}', 'PermissionController@update')
            ->name('permissions.update');
        Route::delete('/permissions/{permission}', 'PermissionController@destroy')->name('permissions.destroy');
        Route::patch('/permissions/{permission}/disabling', 'PermissionController@offStatus')
            ->name('permissions.disabling');
        Route::patch('/permissions/{permission}/activating', 'PermissionController@onStatus')
            ->name('permissions.activating');
        Route::delete('/permissions', 'PermissionController@massiveDestroy')
            ->name('permissions.massiveDestroy');
    }
);

/**
 * Permission assignment/revoke routes
 *
 */
Route::group(
    [
        'prefix' => 'cms',
        'namespace' => 'Bkstar123\BksCMS\AdminPanel\Http\Controllers',
        'middleware' => [
            'web', 'bkscms-auth:admins',
        ],
    ],
    function () {
        Route::post('/roles/{role}/permissions', 'PermissionRoleController@assignPermissions')
            ->name('roles.permissions.assign');
        Route::post('permissions/revoke/{permission}', 'PermissionRoleController@revoke')
            ->name('permissions.revoke');
    }
);
