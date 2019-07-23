<?php

use App\App;
use App\Connection;
use App\QueryBuilder;

if (!file_exists(__DIR__ . '/config.php')) {
    die('"config.php\" was not found. Please, create it and try again.');
}

$config = require __DIR__.'/config.php';

if (App::get('config')['debug']) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

function db()
{
    return new QueryBuilder(
        Connection::start($config['database'])
    );
}
