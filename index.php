<?php

require "vendor/autoload.php";
require "core/helpers.php";
require "core/bootstrap.php";

use App\Core\{Router, Request};

Router::carregar('app/routes.php')->direcionar(
    Request::uri(), 
    Request::method()
);
