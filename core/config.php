<?php

return [
    'charset' => 'utf8',
    'template' => 'twig',
    'model' => 'seafoam',
    'modules' => [
        'Twig',
        'Crimson',
        'Seafoam',
        'Emerald',
        'Domi'
    ],
    'db' => [
        'engine'   => 'mysql',
        'host'     => 'localhost',
        'port'     => '3306',
        'name'     => 'indigo',
        'user'     => 'indigo',
        'pass'     => 'indigo',
    ],
    'theme' => 'indigo',
    'default_controller' => 'home',
];

