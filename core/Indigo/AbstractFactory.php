<?php

namespace Indigo;

trait AbstractFactory
{
    static private $cache = [];
    static private $registered_engines = [];

    public static function registerEngine($name, $class)
    {
        if (!class_exists($class)) {
            throw new self::$exception(
                sprintf('Engine type "%s" does not exist', $class)
            );
        } elseif (!in_array(self::$engineInterface, class_implements($class))) {
            throw new Exception(
                sprintf('Engine type "%s" does not implement %s', $class, self::$engineInterface)
            );
        } else {
            self::$registered_engines[$name] = $class;
        }
    }   

    public static function init($engine, Config $config, $name='default')
    {
        if (array_key_exists($engine, self::$registered_engines)) {
            $templateEngine = self::$registered_engines[$engine];
            self::$cache[$name] = new $templateEngine($config);
        } else {
            throw new self::$exception(
                sprintf('Engine "%s" has not been registered', $engine)
            );
        }
    }

    public static function factory($name='default')
    {
        if (array_key_exists($name, self::$cache)) {
            return self::$cache[$name];
        } else {
            throw new self::$exception(
                sprintf('Engine "%s" has not been initialized', $name)
            );
        }
    }
}

