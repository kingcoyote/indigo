<?php

namespace Nightlife\Controller;
use Indigo;
use Indigo\Template;

class Home extends Indigo\Controller
{
    public static $routes = [
        '' => [
            'page' => 'index',
            'alias' => ['/home']
        ],
        'home/domi' => [
            'page' => 'domi',
        ],
        'home/{id}' => [
            'page' => 'main'
        ],
    ];

    public function index($request, $response)
    {
        $view = Template::factory()->createView('home');
        $view->foo = 'foo & stuff';
        $view->faz = 'bar & stuff';
        
        $response->set('content', $view->render());

        return $response;
    }

    public function main($request, $response)
    {
        var_dump($request->get('args'));

        return $response;
    }

    public function domi($request, $response)
    {
        $domiConfig = new Indigo\Config();
        $domiConfig->set('template', 'domi');
        Indigo\Template::init($domiConfig, 'domi');

        $view = Indigo\Template::factory('domi')->createView('domi');
        $view->foo = 'bar';

        $response->set('content', $view->render());

        return $response;
    }
}

