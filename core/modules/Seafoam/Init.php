<?php

namespace Seafoam;

use Indigo\Model;

class Init
{
    public static function Init()
    {
        Model::registerEngine('seafoam', 'Seafoam\\Engine');
    }
}

