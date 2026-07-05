<?php

return [
    'url' => '/',
    'panel' =>[
        'install' => true
    ],
    'markdown' => [
        'breaks' => true
    ],
    'cache' => [
        'pages' => [
        'active' => false
        ]
    ],
    'jr.static_site_generator' => [
        'output_folder' => './static-export',
        'base_url'      => '/',
        'preserve'      => ['.git'],
        'skip_media'    => false,
    ],
];