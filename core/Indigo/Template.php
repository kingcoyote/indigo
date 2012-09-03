<?php

namespace Indigo;

class Template
{
    use AbstractFactory;
    private static $engineInterface = 'Indigo\\Template\\EngineInterface';
    private static $objectInterface = 'Indigo\\Template\\ViewInterface';
    private static $exception = 'Indigo\\Exception\\Template';

}

