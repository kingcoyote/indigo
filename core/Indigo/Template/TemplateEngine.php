<?php

namespace Indigo\Template;
use Indigo\Config;

class TemplateEngine implements TemplateEngineInterface
{
    public function __construct(Config $config)
    {
    }

    public function factory($name)
    {
        return new TemplateView($name); 
    }

    public function setGlobal($name, $value)
    {

    }
}
