<?php 
/**
 * @author: tuanha
 * @last-mod: 02-Sept-2019
*/

return [
    // default page to redirect an authenticated admin user
    'default_authenticated_page' => '/cms/dashboard',

    // default page to redirect an unauthenticated admin user
    'default_unauthenticated_page' => '/cms/admins/login',

    // The maximum number of login failures
    'maxLoginAttempts' => 3,

    // The time before being able to re-try login (in minutes)
    'retryAfter' => 1,

    // The number of items per page
    'pageSize' => 10,

    // Avatar max size (in bytes)
    'avatarMaxSize' => 5242880, // 5MB

    // Avatar allowed extensions
    'avatarAllowedExtensions' => ['jpg', 'jpeg', 'png'],

    // Use queue for mailing/notification. If so, use the default connection and default queue
    'useQueue' => env('BKSTAR123_BKSCMS_USE_QUEUE', false),

    'permissions' => [
        // admins resource
        [
            'permission' => 'Listing all admins',
            'alias' => 'admins.index',
            'description' => 'This permission allows for seeing the list of admins'
        ],

        [
            'permission' => 'View another admin',
            'alias' => 'admins.view',
            'description' => 'This permission allows for viewing the profile of another admin'
        ],

        [
            'permission' => 'Create new admin',
            'alias' => 'admins.create',
            'description' => 'This permission allows for creating a new admin'
        ],

        [
            'permission' => 'Update profile of another admin',
            'alias' => 'admins.update',
            'description' => 'This permission allows for updating an admin, for example: update profile data and update the list of assigned roles'
        ],

        [
            'permission' => 'Change password of another admin',
            'alias' => 'admins.changePassword',
            'description' => 'This permission allows for changing password of another admin'
        ],

        [
            'permission' => 'Delete another admin account',
            'alias' => 'admins.delete',
            'description' => 'This permission allows for deleting an admin account'
        ],

        [
            'permission' => 'Enable another admin',
            'alias' => 'admins.activate',
            'description' => 'This permission allows for enabling an admin'
        ],

        [
            'permission' => 'Disable another admin',
            'alias' => 'admins.deactivate',
            'description' => 'This permission allows for disabling an admin'
        ],
    ]
];
