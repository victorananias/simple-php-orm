<?php

namespace App\Core;

class App
{
    protected static $data;

    public static function bind($key, $value)
    {
        self::$data[$key] = $value;
    }

    public static function get($key)
    {
        if (!array_key_exists($key, self::$data)) {
            throw new Exception("App não contém {$key}.");
        }

        return self::$data[$key];
    }
}
