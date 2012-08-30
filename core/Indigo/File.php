<?php

namespace Indigo;

class File
{
    private static $sites = [];
    
    public static function init($site, $name='default')
    {
        self::$sites[$name] = new File($site);
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
    }

    public function find($type, $name)
    {
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
                return 'sites/Nightlife/template/' . $name . '.tpl.php';
                break;
        }
    }
}

