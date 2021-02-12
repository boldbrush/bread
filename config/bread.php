<?php

return [
    'theme' => env('BREAD.THEME', 'bread::tailwind'),
    'layout' => env('BREAD.LAYOUT', 'master'),
    'view' => [
        'browse' => env('BREAD.VIEW.BROWSE', 'browse'),
        'read' => env('BREAD.VIEW.READ', 'read'),
        'edit' => env('BREAD.VIEW.EDIT', 'edit'),
        'add' => env('BREAD.VIEW.ADD', 'add'),
    ],
];
