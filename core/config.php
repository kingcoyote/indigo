<?php

return [
    'charset' => 'utf8',
    'template' => 'twig',
    'model' => 'seafoam',
    'database' => 'crimson_mysql',
    'modules' => [
        'Twig',
        'Crimson',
        'Seafoam',
        'Emerald',
        'Domi'
    ],
    'crimson' => [
        'engine'   => 'mysql',
        'host'     => 'localhost',
        'port'     => '3306',
        'name'     => 'indigo',
        'user'     => 'indigo',
        'pass'     => 'indigo',
    ],
    'default_controller' => 'home',
];

