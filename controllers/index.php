<?php

$usuarios = App::get('db')->selectAll("usuarios");

require "views/index.view.php";
