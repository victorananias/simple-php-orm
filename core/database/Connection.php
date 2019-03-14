<?php

namespace App\Core\Database;

use \PDO;
use \PDOException;

class Connection
{
    public static function start($config)
    {
        try {
            return new PDO(
                "{$config['connection']};Database={$config['Database']}",
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }
}
