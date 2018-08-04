<?php

$usuarios = $app['db']->selectAll("usuarios");

require "views/index.view.php";
