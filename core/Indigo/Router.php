<?php

namespace Indigo;

class Router
{
    public static function parseRequest(Config $config)
    {
        $request = array();
        $request['protocol'] = array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';
        $request['domain']   = $_SERVER['HTTP_HOST'];
        $request['folder']   = (dirname($_SERVER['SCRIPT_NAME']) == '/' ? null : dirname($_SERVER['SCRIPT_NAME'])) . '/';
        $request['base_url'] = $request['protocol'] . $request['domain'] . $request['folder'];
        $request['query']    = substr($_SERVER['REQUEST_URI'], strlen($request['folder']));

        $request['method'] = $_SERVER['REQUEST_METHOD'];
        $request['post'] = $_POST;
        $request['get']  = $_GET;

        $request['controller'] = substr(
            $request['query'], 
            0, 
            strstr($request['query'], '/') !== false ? strpos($request['query'], '/') : strlen($request['query'])
        );

        if ($request['controller'] == '') {
            $request['controller'] = $config->get('default_controller');
        }

        $request['query'] = '/' . $request['query'];
        
        $class = File::factory()->find('controller', $request['controller']);
        $request['controller'] = $class;

        $routes = $class::$routes;
        
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
            if (preg_match($mask_regex['regex'], $request['query'], $matches)) {
                $request['route'] = $route;
                $request['args'] = array_combine($mask_regex['args'], array_splice($matches, 1));
            }
        }

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

    public static function dispatch($request)
    {
        $controller = Controller::factory($request['controller']);
        $page = $request['route']['page'];

        if (method_exists($controller, $page)) {
            return $controller->$page($request);
        } else {
            throw new Exception\Router();
        }
    }
}

