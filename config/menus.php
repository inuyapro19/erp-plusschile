<?php
// config/menus.php

return [
    'admin' => [
        ['name' => 'Dashboard', 'route' => 'admin.dashboard'],
        // otros elementos del menú para admin
    ],
    'user' => [
        ['name' => 'Profile', 'route' => 'user.profile'],
        // otros elementos del menú para usuarios
    ],
    // más definiciones de menú para otros roles
];
