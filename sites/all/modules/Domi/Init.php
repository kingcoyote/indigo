<?php

namespace Domi;

use Indigo\Template;
use Indigo\File;

class Init
{
    public static function init()
    {
        Template::registerEngine('domi', 'Domi\\Engine');
        File::registerType('domi', function($name){
            foreach (File::factory()->getDirs('templates') as $dir) {
                $xsl = $dir . '/' . $name . '.domi.xsl';
                if (file_exists($xsl)) {
                    return $xsl;
                }
            }
        });
    }
}

