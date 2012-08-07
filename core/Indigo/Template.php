<?php

namespace Indigo;

class Template
{
    static private $cache = [];
    static private $registered_engines = [];

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

    public static function register_engine($name, $class)
    {
        if (!class_exists($class)) {
            throw new Exception\Template(
                sprintf('Engine type "%s" does not exist', $class)
            );
        } elseif (!in_array('Indigo\\Template\\TemplateInterface', class_implements($class))) {
            throw new Exception\Db(
                sprintf('Engine type "%s" does not implment \\Indigo\\Template\\TemplateInterface', $class)
            );
        } else {
            self::$registered_engines[$name] = $class;
        }
    }   

    public function __construct(Config $config)
    {
        $this->template = $config->get('template');
    }

    public static function create($name)
    {
        if (isset($this)) {
            return new $this->engine($name);
        } else {
            return self::$cache['default']->create($name);
        }
    }
}

