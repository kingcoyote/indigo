<?php

namespace Nightlife\Controller;
use Indigo;
use Indigo\Template;

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
        $view = Template::factory()->factory('test');
        $view->foo = 'bar';
        return $view->render();
    }

    public function main($request)
    {
        var_dump($request['args']);
    }
}

