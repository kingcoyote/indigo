<?php

namespace Indigo;

class Site
{
    public static function fetch()
    {
        return 'indigo';
    }

    public static function getConfigFiles($name) {
        return [
            INDIGO_DIR . 'core/config.php',
            INDIGO_DIR . 'sites/all/config.php',
            INDIGO_DIR . 'sites/indigo/config.php',
        ];
    }
}

