<?php

namespace Indigo\Template;

class TemplateView implements TemplateViewInterface
{
    static private $globalVariables = [];

    public function __construct($name)
    {
        // use the Indigo::File system to locate a template file of that name
        // initialize local variables
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

        return ob_end_clean();
    }

    static public function setGlobal($name, $value)
    {
        self::$globalVariables[$name] = $value;
    }
}

