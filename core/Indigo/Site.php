<?php

namespace Indigo;

class Site
{
    public static function fetch()
    {
        return 'Nightlife';
    }

    public static function getConfigFiles($name) {
        return [
            INDIGO_DIR . 'core/config.php',
            INDIGO_DIR . 'sites/all/config.php',
            INDIGO_DIR . 'sites/' . $name . '/config.php',
        ];
    }
}

