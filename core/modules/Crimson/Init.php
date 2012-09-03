<?php

namespace Crimson;

use Indigo\Db;

class Init
{
    public static function init()
    {
        Db::registerEngine('crimson_mysql', 'Crimson\\Mysql\\Engine');
    }
}


