<?php

namespace Indigo;

class ViewEngine
{
    public static function init(Indigo\Config $config, $name='default')
    {
        self::$cache[$name] = new ViewEngine($config);
        return self::$cache[$name];
    }

    public static function factory($name)
    {
        if (array_key_exists($name, self::$cache) {
            return self::$cache[$name];
        } else {
            throw new Exception/View(
                sprintf('View engine "%s" has not been initialized', $name);
            );
        }
    }

    public function __construct(Indigo\Config $config)
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

