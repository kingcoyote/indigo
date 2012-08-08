<?php

namespace Indigo\Template;

interface TemplateViewInterface
{
    public function __construct($name);
    public function __set($name, $value);
    public function render();
    public static function setGlobal($name, $value);
}

