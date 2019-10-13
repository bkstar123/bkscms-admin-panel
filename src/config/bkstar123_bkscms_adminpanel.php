<?php 
/**
 * @author: tuanha
 * @last-mod: 02-Sept-2019
*/

return [
    // default page to redirect an authenticated admin user
    'default_authenticated_page' => '/dashboard/index',

    // default page to redirect an unauthenticated admin user
    'default_unauthenticated_page' => '/admins/login',

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
];
