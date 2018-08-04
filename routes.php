<?php

$router->get("", "controllers/index.php");
$router->get("contato", "controllers/contato.php");
$router->get("sobre", "controllers/sobre.php");
$router->get("sobre/cultura", "controllers/sobre-cultura.php");
$router->post("nomes", "controllers/add-nome.php");
