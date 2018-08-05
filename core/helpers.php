<?php


function view($pagina, $dados = []) {
    /*
    |
    | extract()
    |
    | transforma cada key do array em uma variável
    |
    */
    extract($dados);
    return require "app/views/{$pagina}.view.php";
}

function redirecionar($path) {
    header("Location: /{$path}");
}

function dd($dados) {
    echo "<pre>";
    var_dump($dados);
    echo "</pre>";
    die();
}