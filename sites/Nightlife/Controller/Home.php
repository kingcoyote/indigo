<?php

namespace Nightlife\Controller;
use Indigo;
use Indigo\Template;

class Home extends Indigo\Controller
{
    public static $routes = [
        '/' => [
            'page' => 'index',
            'alias' => ['/home']
        ],
        '/home/{id}' => [
            'page' => 'main'
        ]
    ];

    public function index($request)
    {
        $view = Template::factory()->factory('twig.html');
        $view->foo = 'foo & stuff';
        $view->faz = 'bar & stuff';
        
        return $view->render();
    }

    public function main($request)
    {
        var_dump($request['args']);
    }
}

