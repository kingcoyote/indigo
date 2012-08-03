<?php

namespace Indigo;

class View
{
    public static function factory($name)
    {
        return new View($name);
    }

    public function __construct($name)
    {

    }

    public function render()
    {
        return 'Indigo';
    }

    public function __set($name, $value)
    {

    }
}

