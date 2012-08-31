<?php

namespace Indigo\Template;
use Indigo\Config;

interface EngineInterface
{
    public function __construct(Config $config);
    public function createView($name);
    public function setGlobal($name, $value);
}

