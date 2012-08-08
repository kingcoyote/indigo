<?php

namespace Indigo;

class Template
{
    static private $cache = [];
    static private $registered_engines = [];

    public static function registerEngine($name, $class)
    {
        if (!class_exists($class)) {
            throw new Exception\Template(
                sprintf('Engine type "%s" does not exist', $class)
            );
        } elseif (!in_array('Indigo\\Template\\TemplateEngineInterface', class_implements($class))) {
            throw new Exception\Db(
                sprintf('Engine type "%s" does not implment \\Indigo\\Template\\TemplateEngineInterface', $class)
            );
        } else {
            self::$registered_engines[$name] = $class;
        }
    }   

    public static function init(Config $config, $name='default')
    {
        self::$cache[$name] = new Template($config);
        return self::$cache[$name];
    }

    public static function factory($name)
    {
        if (array_key_exists($name, self::$cache)) {
            return self::$cache[$name];
        } else {
            throw new Exception/View(
                sprintf('Template "%s" has not been initialized', $name)
            );
        }
    }
}

