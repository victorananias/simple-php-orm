<?php

class App {
    
    protected static $dados;

    public static function bind($key, $value) {
        self::$dados[$key] = $value;
    }

    public static function get($key) {
        if(!array_key_exists($key, self::$dados)) {
            throw new Exception("App não contém {$key}.");
        }
        
        return self::$dados[$key];
    }
}