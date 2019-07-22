<?php

namespace App;

use \PDO;
use \PDOException;

class Connection
{
    public static function start($config)
    {
        try {
            return new PDO(
                "{$config['connection']}:Server={$config['host']},{$config['port']};Database={$config['database']}",
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }
}
