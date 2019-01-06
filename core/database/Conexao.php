<?php

namespace App\Core\Database;

use \PDO;
use \PDOException;

class Conexao {

    public static function iniciar($config) {
        try {
            return new PDO(
                $config['connection'].";Database=".$config['Database'],
                $config['username'],
                $config['password']
            );
        } catch(PDOException $exception) {
            die($exception->getMessage());
        }
    }
}
