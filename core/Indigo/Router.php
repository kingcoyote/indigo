<?php

namespace Indigo;

class Router
{
    public static function ParseRequest()
    {
        $request = array();
        $request['protocol'] = array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';
        $request['domain']   = $_SERVER['HTTP_HOST'];
        $request['folder']   = dirname($_SERVER['SCRIPT_NAME']) == '/' ? null : dirname($_SERVER['SCRIPT_NAME'])) . '/';
        $request['base_url'] = $request['protocol'] . $request['domain'] . $request['folder'];

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

    public static function Dispatch($request)
    {
        return Indigo\Controller::factory($request['controller'])->{$request['page']}($request);
    }
}

