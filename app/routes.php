<?php

$router->get("produtos", "ProdutosController@index");
$router->post("produtos", "ProdutosController@store");
$router->delete("produtos", "ProdutosController@destroy");
$router->get("produtos/create", "ProdutosController@create");
$router->post("produtos/edit", "ProdutosController@update");
$router->get("produtos/edit", "ProdutosController@edit");
