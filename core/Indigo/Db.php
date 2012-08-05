<?php

namespace Indigo;

class Db
{
    static private $cache = [];
    static private $registered_engines = [];
    
    static public function init(Config $config, $name='default')
    {
        self::$cache[$name] = new Db($config);
        return self::$cache[$name];
    }

    static public function register_engine($name, $class)
    {
        if (!class_exists($class)) {
            throw new Exception\Db(
                sprintf('Engine type "%s" does not exist', $class)
            );
        } elseif (!in_array('Indigo\\Db\\EngineInterface', class_implements($class))) {
            var_dump($class, class_implements($class));
            throw new Exception\Db(
                sprintf('Engine type "%s" does not implment \\Indigo\\Db\\EngineInterface', $class)
            );
        } else {
            self::$registered_engines[$name] = $class;
        }
    }

    static public function factory($name='default')
    {
        if (array_key_exists($name, self::$cache)) {
            return self::$cache[$name];
        } else {
            $e =  new Exception\Db(
                sprintf('Database "%s" has not been initialized', $name)
            );
            throw $e;
        }
    }

    public function __construct(Config $config)
    {
        $engine = strtolower($config->get('db')['engine']);

        if (array_key_exists($engine, self::$registered_engines)) {
            $engine = self::$registered_engines[$engine];
            $this->engine = new $engine($config);
        } else {
            throw new Exception\Db(
                sprintf('Unknown database engine "%s"', $engine)
            );
        }
    }
}

