<?php

namespace Indigo;

class Db
{
    use AbstractFactory;

    static private $engineInterface = 'Indigo\\Db\\EngineInterface';
    static private $objectInterface = 'Indigo\\Db\\QueryInterface';
    static private $exception = 'Indigo\\Exception\\Db';
    static private $event = 'indigo db';
}

