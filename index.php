<?php

require "vendor/autoload.php";
require "core/bootstrap.php";

Router::carregar('routes.php')->direcionar(
    Request::uri(), 
    Request::method()
);
