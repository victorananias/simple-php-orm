<?php

return [
    'database' => [
        'connection' => "mysql:host=127.0.0.1",
        'dbname' => "meubanco",
        'charset' => "utf8",
        'username' => "user1",
        'password' => "user1",
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ],
    ]
];
