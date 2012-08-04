<?php

namespace Indigo;

class Config
{
    public static function factory($file)
    {
       return new Config($file);
    }

    public static function get($name)
    {
        return 'Indigo';
    }
}

