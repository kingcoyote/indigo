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

    const HTTP_301 = '301 Moved Permanently';
    const HTTP_302 = '302 Found';
    const HTTP_307 = '307 Moved Temporarily';

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

    public function redirect($url, $http_code = self::HTTP_302)
    {
        $this->set('http_code', $http_code);
        $this->setHeader('Location', $url);
    }
}

