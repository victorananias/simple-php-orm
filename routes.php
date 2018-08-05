<?php

$router->get("", "PagesController@index");
$router->get("contato", "PagesController@contato");
$router->get("sobre", "PagesController@sobre");
$router->get("usuarios", "UsuariosController@index");
$router->post("usuarios", "UsuariosController@store");
