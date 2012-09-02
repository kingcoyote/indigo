<?php

namespace Indigo;

class Router
{
    public static function parseRequest(Config $config)
    {
        $request = Request::fromServer();
        return $request;
    }

    private static function parseMask($mask) {
        $args = [];
        $mask = preg_replace_callback(
            '/\{[a-zA-Z0-9]+\}/', 
            function($match) use (&$args) {
                $args[] = substr($match[0], 1, strlen($match[0] - 2));
                return '([a-zA-Z0-9-_]+)';
            }, 
            $mask
        );
        return [
            'regex' => '/^' . str_replace('/', '\\/', $mask) . '$/',
            'args' => $args
        ];
    }

    public static function dispatch($request, $response, $config)
    {
        $controller = substr(
            $request->get('query'), 
            0, 
            strstr($request->get('query'), '/') !== false ? strpos($request->get('query'), '/') : strlen($request->get('query'))
        );
        if ($controller == '') {
            $controller = $config->get('default_controller');
        }
         
        $class = File::factory()->find('controller', $controller);
        $controller = $class;

        $routes = $class::$routes;
        $args = [];

        foreach ($routes as $mask => $route) {
            if (isset($route['alias'])) {
                foreach ($route['alias'] as $alias) {
                    $new_route = $route;
                    unset($route['alias']);
                    $routes[$alias] = $new_route;
                }
            }
        }

        foreach ($routes as $mask => $route) {
            $mask_regex = self::parseMask($mask); 
            if (preg_match($mask_regex['regex'], $request->get('query'), $matches)) {
                $args = array_combine($mask_regex['args'], array_splice($matches, 1));
                break;
            }
        }
        $controller = Controller::factory($controller);
        $page = $route['page'];

        $request->set('args', $args);
        $request->set('controller', $controller);
        $request->set('page', $page);

        if (method_exists($controller, $page)) {
            $response = $controller->$page($request, $response);
            
            if (! ($response instanceof Indigo\Response)) {
                throw new Exception\Router();
            }

            return $response;
        } else {
            throw new Exception\Router();
        }
    }
}

