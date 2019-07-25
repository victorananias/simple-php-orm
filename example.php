<?php

require_once __DIR__ . "/index.php";

$config = require __DIR__.'/config.php';

if (!empty($config['debug'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

function db()
{
    $config = require __DIR__.'/config.php';

    return \SimpleORM\SimpleORM::create($config['database']);
}
