<?php

require __DIR__."/vendor/autoload.php";
require __DIR__."/core/helpers.php";
require __DIR__."/core/bootstrap.php";

use App\Core\Router;
use App\Core\Request;

Router::carregar('app/routes.php')->direcionar(
    Request::uri(), 
    Request::method()
);
