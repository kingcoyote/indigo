<?php

namespace Indigo;

class Controller
{
    public static function factory($name)
    {
        return new $name();
    }

    public function index($request)
    {
        return 'Indigo';
    }
}

