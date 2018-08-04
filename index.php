<?php

require "core/bootstrap.php";

$router = new Router();

require 'routes.php';

require $router->direcionar(Request::uri());
