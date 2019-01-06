<?php
/*
|
| Ligando a exibição de erros
|
*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Core\App;
use App\Core\Database\Conexao;
use App\Core\Database\QueryBuilder;

if(!file_exists('./config.php')) {
    die("\"config.php\" was not found. Please, create it and try again.");
}

App::bind('config', require 'config.php');

App::bind('db', new QueryBuilder(
    Conexao::iniciar(App::get('config')['database'])
));