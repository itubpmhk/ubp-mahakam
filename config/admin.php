<?php

// First admin account, created by "php artisan db:seed".
// Read through config() so it still works when the config is cached on the server.
return [
    'name' => env('ADMIN_NAME', 'Administrator'),
    'email' => env('ADMIN_EMAIL', 'admin@ubpmahakam.local'),
    'password' => env('ADMIN_PASSWORD', 'GantiPassword123!'),
];
