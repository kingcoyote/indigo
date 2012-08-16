<?php

namespace Twigdigo;
use Indigo\Template\EngineInterface;
use Indigo\Config;

class Engine implements EngineInterface
{
    public function __construct(Config $config)
    {
        $this->loader = new \Twig_Loader_Filesystem('sites/Nightlife/template');
    }

    public function factory($name)
    {
        $view = new View($name);
        $view->setLoader($this->loader);
        return $view;
    }

    public function setGlobal($name, $value)
    {

    }
}

