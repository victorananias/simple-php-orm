<?php

$tarefas = $qb->selectAll("tarefas");

require "views/index.view.php";
