<?php
/*
|
| Ligando a exibição de erros
|
*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

App::bind('config', require 'config.php');

App::bind('db', new QueryBuilder(
    Conexao::iniciar(App::get('config')['database'])
));

function view($pagina, $dados = []) {
    /*
    |
    | extract()
    |
    | transforma cada key do array em uma variável
    |
    */
    extract($dados);
    return require("views/{$pagina}.view.php");
}

function redirecionar($path) {
    header("Location: /{$path}");
}