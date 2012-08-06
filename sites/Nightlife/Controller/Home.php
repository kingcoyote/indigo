<?php

namespace Nightlife\Controller;
use Indigo;

class Home extends Indigo\Controller
{
    public static $routes = [
        '/' => [
            'page' => 'index'
        ],
        '/home' => [
            'alias' => '/'
        ]
    ];

    public function index($request)
    {
        return 'Nightlife';
    }
}

