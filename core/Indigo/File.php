<?php

namespace Indigo;

class File
{
    public static function init()
    {

    }

    public static function find($type, $name)
    {
        switch (strtolower($type)) {
            case 'controller':
                return '\\Nightlife\\Controller\\Home';
                break;
            case 'template':
                return 'sites/Nightlife/template/' . $name . '.tpl.php';
                break;
        }
    }
}

