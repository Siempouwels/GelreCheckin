<?php

namespace App\Helpers;

class Params
{
    private static $params = array();

    public static function get($key)
    {
        if (array_key_exists($key, self::$params)) {
            return self::$params[$key];
        } else {
            return null;
        }
    }

    public static function set($key, $value)
    {
        self::$params[$key] = $value;
    }

    public static function all()
    {
        return self::$params;
    }
}
