<?php

namespace Indigo;

class Controller
{
    public static function factory($name)
    {
        return new Controller();
    }

    public function index($request)
    {
        return 'Indigo';
    }
}

