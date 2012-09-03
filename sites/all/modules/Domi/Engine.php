<?php

namespace Domi;

use Indigo\Template\EngineInterface;
use Indigo\Config;
use Indigo\File;

class Engine implements EngineInterface
{
    public function __construct(Config $config)
    {
        return true;
    }

    public function createView($name)
    {
        $view = new View($name);
        return $view;
    }

    public function setGlobal($name, $value)
    {

    }
}

