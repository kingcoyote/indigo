<?php

namespace Domi;

use Indigo\Template\ViewInterface;
use Indigo\File;
use Indigo\Exception;

class View implements ViewInterface
{
    private $stylesheet;
    private $vars;

    public function __construct($name)
    {
        $this->stylesheet = File::factory()->find('domi', $name);
        if ($this->stylesheet === null) {
            throw new Exception\Template(
                sprintf('DOMi template error: stylesheet "%s" cannot be found', $name)
            );
        }
        $this->vars = [];
    }

    public function __set($name, $value)
    {
        $this->vars[$name] = $value;
    }

    public function render()
    {

        $domi = new Domi('root');

        foreach ($this->vars as $name => $value) {
            $domi->attachToXml($value, $name);
        }

        return $domi->render([$this->stylesheet]);
    }

    static public function setGlobal($name, $value)
    {

    }
}

