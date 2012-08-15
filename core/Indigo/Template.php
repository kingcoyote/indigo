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
        } elseif (!in_array('Indigo\\Template\\EngineInterface', class_implements($class))) {
            throw new Exception\Db(
                sprintf('Engine type "%s" does not implment \\Indigo\\Template\\EngineInterface', $class)
            );
        } else {
            self::$registered_engines[$name] = $class;
        }
    }   

    public static function init(Config $config, $name='default')
    {
        if (array_key_exists($config->get('template'), self::$registered_engines)) {
            $templateEngine = self::$registered_engines[$config->get('template')];
            self::$cache[$name] = new $templateEngine($config);
        } else {
            throw new Exception\Template(
                sprintf('Template engine "%s" has not been registered', $config->get('template'))
            );
        }
    }

    public static function factory($name='default')
    {
        if (array_key_exists($name, self::$cache)) {
            return self::$cache[$name];
        } else {
            throw new Exception\Template(
                sprintf('Template "%s" has not been initialized', $name)
            );
        }
    }
}

