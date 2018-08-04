<?php

require "core/bootstrap.php";

require Router::carregar('routes.php')->direcionar(
    Request::uri(), 
    Request::method()
);
