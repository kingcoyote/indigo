<?php

namespace Indigo\Template;
use Indigo\Config;

class Engine implements EngineInterface
{
    public function __construct(Config $config)
    {
    }

    public function createView($name)
    {
        return new View($name); 
    }

    public function setGlobal($name, $value)
    {
        // this is not good because it means there can only be one instance
        // of this particular engine
        View::setGlobal($name, $value);
    }
}

