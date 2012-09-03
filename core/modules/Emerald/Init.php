<?php

namespace Emerald;
use Indigo\Template;
use Indigo\File;
use Indigo\Config;

class Init
{
    public static function Init()
    {
        Template::registerEngine('emerald', 'Emerald\\Engine');

        $emeraldConfig = new Config();
        $emeraldConfig->set('template', 'emerald');
        Template::init('emerald', $emeraldConfig, 'emerald');

        File::registerType('emerald_view', function($file, $dirs){
            foreach ($dirs as $dir) {
                if (file_exists($dir . 'templates/' . $file . '.emerald.php')) {
                    return $dir . 'templates/' . $file . '.emerald.php';
                }
            }

            return false;
        });
    }
}
