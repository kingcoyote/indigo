<?php

namespace Indigo;

class Response
{
    public $vars = [
        'http_code' => self::HTTP_200,
        'content' => '',
    ];
    public $headers = [];

    const HTTP_200 = '200 OK';
    const HTTP_403 = '403 Forbidden';
    const HTTP_404 = '404 Not Found';
    const HTTP_418 = '418 I\'m a teapot';

    public function get($name)
    {
        return $this->vars[$name];
    }

    public function set($name, $value)
    {
        $this->vars[$name] = $value;
    }   

    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}

