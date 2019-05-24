<?php

return [
    'debug' => true,
    'database' => [
        'connection' => 'sqlsrv',
        'host' => 'HOST',
        'port' => '1433',
        'database' => 'DATABASE',
        'charset' => 'UTF-8',
        'username' => 'DBUSER',
        'password' => 'DBPASS',
        'options' => [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
    ]
];
