<?php

namespace Twigdigo;
use Indigo\Template\ViewInterface;

class View implements ViewInterface
{
    public function __construct($name)
    {
        $this->file = $name;
        $this->vars = [];
    }

    public function setLoader(\Twig_Loader_Filesystem $loader)
    {
        $this->loader = $loader;
    }

    public function __set($name, $value)
    {
        $this->vars[$name] = $value;
    }

    public function render()
    {
        $twig = new \Twig_Environment(
            $this->loader
        );

        return $twig->render(
            $this->file,
            $this->vars
        );
    }

    static public function setGlobal($name, $value)
    {

    }
}

