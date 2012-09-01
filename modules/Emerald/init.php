<?php

Indigo\Template::registerEngine('emerald', 'Emerald\\Engine');

$emeraldConfig = new Indigo\Config();
$emeraldConfig->set('template', 'emerald');
Indigo\Template::init($emeraldConfig, 'emerald');

Indigo\File::registerType('emerald_view', function($file, $dirs){
    foreach ($dirs as $dir) {
        if (file_exists($dir . 'templates/' . $file . '.emerald.php')) {
            return $dir . 'templates/' . $file . '.emerald.php';
        }
    }

    return false;
});

