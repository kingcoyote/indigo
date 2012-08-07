<?php

namespace Indigo\View;

interface ViewInterface
{
    public function __set($name, $value);
    public function render();
    public static function setGlobal($name, $value);
}

