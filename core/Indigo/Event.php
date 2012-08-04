<?php

namespace Indigo;

class Event
{
    private static $events = array();

    public static function init()
    {

    }

    public static function trigger($name, $args = false)
    {
        if (!array_key_exists($name, self::$events)) {
            return $args;
        }

        foreach (self::$events[$name] as $handler) {
            $args = call_user_func($handler, $args);
        }

        return $args;
    }
}

