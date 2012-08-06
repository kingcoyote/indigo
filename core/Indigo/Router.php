<?php

namespace Indigo;

class Router
{
    public static function parseRequest()
    {
        $request = array();
        $request['protocol'] = array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';
        $request['domain']   = $_SERVER['HTTP_HOST'];
        $request['folder']   = (dirname($_SERVER['SCRIPT_NAME']) == '/' ? null : dirname($_SERVER['SCRIPT_NAME'])) . '/';
        $request['base_url'] = $request['protocol'] . $request['domain'] . $request['folder'];
        $request['query']    = substr($_SERVER['REQUEST_URI'], strlen($request['folder']));

        $request['controller'] = substr(
            $request['query'], 
            0, 
            strstr($request['query'], '/') !== false ? strpos($request['query'], '/') : strlen($request['query'])
        );

        $request['query'] = '/' . $request['query'];
        
        $class = File::find('Controller', $request['controller']);
        $request['controller'] = $class;

        $routes = $class::$routes;
        
        foreach ($routes as $mask => $route) {
            $mask_regex = self::parseMask($mask); 
            if (preg_match($mask_regex['regex'], $request['query'], $matches)) {
                $request['route'] = $route;
                $request['args'] = array_combine($mask_regex['args'], array_splice($matches, 1));
            }
        }

        // parse get / post
        //    loop through each one and make sure the character set matches the configured character set for the site
        //    can these possibly be exploitable?
        // parse session / cookies
        //    security. google it.
        // parse files
        //    security. google that again.

        // find controller from query string
        //     should be the first chunk. if there are no chunks, check config for default
        // load controller's routes

        // foreach controller route
        //   if the query string matches the route mask
        //     specify the request's controller and page
        //     parse query into matchDict type thingie

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
        return Controller::factory($request['controller'])->{$request['route']['page']}($request);
    }
}

