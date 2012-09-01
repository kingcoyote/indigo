<?php

namespace Crimson;

use Indigo\Db;

class Init
{
    public static function init()
    {
        Db::registerEngine('mysql', 'Crimson\\Mysql\\Engine');
    }
}


