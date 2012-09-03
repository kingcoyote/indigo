<?php

namespace Indigo;

class Model
{
    use AbstractFactory;

    private static $engineInterface = 'Indigo\\Model\\EngineInterface';
    private static $objectInterface = 'Indigo\\Model\\ModelInterface';
    private static $exception = 'Indigo\\Exception\\Model';
}

