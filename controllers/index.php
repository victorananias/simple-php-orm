<?php

$tarefas = $app['db']->selectAll("tarefas");

require "views/index.view.php";
