<?php

namespace Indigo;

class Config
{
    private static $cache = [];

    private $config = array();

    public static function factory($site)
    {
        if (array_key_exists($site, self::$cache)) {
            return self::$cache[$site];
        }

        $config = new Config();

        $files = Site::getConfigFiles($site);

        foreach ($files as $file) {
            $new_config = require($file);
            foreach ($new_config as $name=>$value) {
                $config->set($name, $value);
            }
        }

        self::$cache[$site] = $config;
        return $config;
    }

    public function set($name, $value) 
    {
        $this->config[$name] = $value;
    }

    public function get($name, $default = false)
    {
        if (array_key_exists($name, $this->config)) {
            return $this->config['name'];
        } else {
            return $default;
        }
    }
}

