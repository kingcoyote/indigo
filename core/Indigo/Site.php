<?php

namespace Indigo;

class Site
{
    public static function fetch()
    {
        $sites = require(INDIGO_DIR . 'sites/sites.php');

        foreach ($sites as $host => $name) {
            if ($host == $_SERVER['SERVER_NAME']) {
                return $name;
            }
        }

        throw new Exception\Router(
            sprintf('Site "%s" has not been defined.', $_SERVER['HTTP_HOST'])
        );
    }

    public static function getConfigFiles($name) {
        return [
            INDIGO_DIR . 'core/config.php',
            INDIGO_DIR . 'sites/all/config.php',
            INDIGO_DIR . 'sites/' . $name . '/config.php',
        ];
    }
}

