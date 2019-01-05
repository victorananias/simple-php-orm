<?php

$router->get("", "ProdutosController@index");
$router->get("cadastro", "ProdutosController@cadastro");
$router->post("edicao", "ProdutosController@update");
$router->get("edicao", "ProdutosController@edicao");
$router->post("cadastro", "ProdutosController@store");
$router->delete("deletar", "ProdutosController@deletar");
