<?php

namespace Indigo;

class Db
{
    static private $cache = array();

    static public function init(Config $config, $name='default')
    {
        self::$cache[$name] = new Db($config);
    }

    static public function factory(Config $config, $name='default')
    {
        if (array_key_exists($name, self::$cache)) {
            return self::$cache[$name];
        } else {
            $e =  new Exception\Db(
                sprintf('Unknown database "%s"', $name)
            );
            throw $e;
        }
    }

    public function __construct(Config $config)
    {
        
    }
}

