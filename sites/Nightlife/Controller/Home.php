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
        ],
    ];

    public function index($request, $response)
    {
        $view = Template::factory()->createView('home');
        $view->foo = 'foo & stuff';
        $view->faz = 'bar & stuff';
        
        $response['content'] = $view->render();

        return $response;
    }

    public function main($request)
    {
        var_dump($request['args']);
    }
}

