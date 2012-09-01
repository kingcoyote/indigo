<?php

Indigo\Template::registerEngine('emerald', 'Emerald\\Engine');
Indigo\File::registerType('emerald_view', function($file, $dirs) {
    foreach ($this->dirs as $dir) {
        if (file_exists($dir . $file . '.emerald.php')) {
            return $dir . $file . '.emerald.php';
        }
    }

    return false;
});

