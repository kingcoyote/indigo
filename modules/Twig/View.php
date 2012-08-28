<?php

namespace Indigo\Module\Twig;

use Indigo\Template\ViewInterface;

class View implements ViewInterface
{
    private $file;
    private $vars;
    private $environment;

    public function __construct($name)
    {
        $this->file = $name;
        $this->vars = [];
    }

    public function setEnvironment(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function __set($name, $value)
    {
        $this->vars[$name] = $value;
    }

    public function render()
    {
        $twig = $this->environment->loadTemplate($this->file);
        return $twig->render($this->vars);
    }

    static public function setGlobal($name, $value)
    {

    }
}

