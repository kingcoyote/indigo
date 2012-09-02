<?php

namespace Indigo;

class Request
{
    private $vars = [];

    public static function fromServer()
    {
        $request = new Request();
        $request->set('protocol', array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://');
        $request->set('domain', $_SERVER['HTTP_HOST']);
        $request->set('folder', (dirname($_SERVER['SCRIPT_NAME']) == '/' ? null : dirname($_SERVER['SCRIPT_NAME'])) . '/');
        $request->set('base_url', $request->get('protocol') . $request->get('domain') . $request->get('folder'));
        $request->set('query', '/' . substr($_SERVER['REQUEST_URI'], strlen($request->get('folder'))));

        $request->set('method', $_SERVER['REQUEST_METHOD']);
        $request->set('post', $_POST);
        $request->set('get', $_GET);

        return $request;
    }

    public function set($name, $value)
    {
        $this->vars[$name] = $value;
    }

    public function get($name)
    {
        return $this->vars[$name];
    }
}

