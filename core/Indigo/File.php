<?php

namespace Indigo;

class File
{
    private static $sites = [];
    private static $types = [];
    
    public static function init($site, $name='default')
    {
        self::$sites[$name] = new File($site);
    }

    public static function registerType($type, callable $callback)
    {
        self::$types[$type] = $callback;
    }

    public static function factory($name='default')
    {
        if (array_key_exists($name, self::$sites)) {
            return self::$sites[$name];
        } else {
            throw new Exception\File(
                sprintf('site "%s" has not been initialized', $name)
            );
        }
    }

    private $site;

    public function __construct($site)
    {
        $this->site = $site;

        $this->dirs = [
            INDIGO_DIR . 'sites/' . $site . '/',
            INDIGO_DIR . 'sites/all/',
            INDIGO_DIR . 'core/',
        ];
    }

    public function find($type, $name)
    {
        if (array_key_exists($type, self::$types)) {
            return call_user_func_array(
                self::$types[$type],
                [$name, $this->dirs]
            );
        }
        
        switch (strtolower($type)) {
            case 'controller':
                $namespaces = [
                    $this->site . '\\Controller'
                ];
                $name = ucfirst($name);
                foreach ($namespaces as $namespace) {
                    if (class_exists($namespace . '\\' . $name)) {
                        return $namespace . '\\' . $name;
                    }
                }
                throw new Exception\Router(
                    sprintf('controller "%s" does not exist', $name)
                );
                break;
            
            case 'template':
                foreach ($this->dirs as $dir) {
                    if (is_dir($dir . 'templates/' . $name . '.tpl.php')) {
                        return $dir . 'templates/' . $name . '.tpl.php';
                    }
                }
                break;

            case 'module':
                foreach ($this->dirs as $dir) {
                    if (is_dir($dir . 'modules/' . $name)) {
                        return $dir . 'modules/';
                    }
                }
                break;
        }

        throw new Exception\File(
            sprintf('File type "%s" has not been initialized', $type)
        );
    }

    public function getDirs($append)
    {
        return array_map(
            function($a) use ($append) {
                return $a .= $append;
            },
            $this->dirs
        );
    }
}

