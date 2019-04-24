<?php

return [
    'database' => [
        'connection' => "sqlsrv:Server=SERVERIP,1433",
        'Database' => "DATABASE",
        'charset' => "UTF-8",
        'username' => "DBUSER",
        'password' => "DBPASS",
        'options' => [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
    ]
];
