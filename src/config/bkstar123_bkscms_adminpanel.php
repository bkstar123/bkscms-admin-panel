<?php 
/**
 * @author: tuanha
 * @last-mod: 02-Sept-2019
*/

return [
    # default page to redirect an authenticated admin user
    'default_authenticated_page' => 'dashboard/index',

    # default page to redirect an unauthenticated admin user
    'default_unauthenticated_page' => 'admins/login',

    # The maximum number of login failures
    'maxLoginAttempts' => 3,

    # The time before being able to re-try login (in minutes)
    'retryAfter' => 2,
];
