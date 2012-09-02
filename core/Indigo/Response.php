<?php

namespace Indigo;

class Response
{
    public $vars = [
        'http_code' => '200 OK',
        'content' => '',
    ];
    public $headers = [];

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

