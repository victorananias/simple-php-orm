<?php
/*
|
| Ligando a exibição de erros
|
*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Core\App;
use App\Core\Database\{Conexao, QueryBuilder};


App::bind('config', require 'config.php');

App::bind('db', new QueryBuilder(
    Conexao::iniciar(App::get('config')['database'])
));