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
        ],
        '/home/{id}' => [
            'page' => 'main'
        ]
    ];

    public function index($request)
    {
        return 'Nightlife';
    }

    public function main($request)
    {
        var_dump($request['args']);
    }
}

