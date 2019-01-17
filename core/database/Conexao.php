<?php

namespace App\Core\Database;

use \PDO;
use \PDOException;

class Conexao
{
    public static function iniciar($config)
    {
        try {
            return new PDO(
                $config['connection'].";dbname=".$config['dbname'].";charset=".$config['charset'],
                $config['username'],
                $config['password']
            );
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }
}
