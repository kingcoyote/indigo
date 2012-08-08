<?php

namespace Indigo\Template;
use Indigo\Config;

interface TemplateEngineInterface
{
    public function __construct(Config $config);
    public function factory($name);
    public function setGlobal($name, $value);
}

