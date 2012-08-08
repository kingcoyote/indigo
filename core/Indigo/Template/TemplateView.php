<?php

namespace Indigo\Template;
use Indigo\File;

class TemplateView implements TemplateViewInterface
{
    static private $globalVariables = [];
    private $file;

    public function __construct($name)
    {
        $this->file = File::find('template', $name);
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

