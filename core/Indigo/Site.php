<?php

namespace Indigo;

class Site
{
    public static function fetch()
    {
        return 'indigofp';
    }

    public static function getConfigFiles($name) {
        return [
            INDIGO_DIR . 'sites/indigofp/config.php',
            INDIGO_DIR . 'sites/all/config.php',
            INDIGO_DIR . 'core/config.php'
        ];
    }
}

