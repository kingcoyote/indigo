<?php

namespace Emerald;
use Indigo\File;
use Indigo\Exception;

class View implements ViewInterface
{
    static private $globalVariables = [];
    private $file;

    public function __construct($name)
    {
        $this->file = File::find('template', $name);

        if (!file_exists($this->file)) {
            throw new Exception\Template(
                sprintf('View file "%s" does not exist', $name)
            );
        }
    }

    public function __set($name, $value)
    {
        $this->variables[$name] = $value;
    }

    public function render()
    {
        ob_start();
        
        extract(self::$globalVariables);
        extract($this->variables);
        require($this->file);

        return ob_get_clean();
    }

    static public function setGlobal($name, $value)
    {
        self::$globalVariables[$name] = $value;
    }
}

