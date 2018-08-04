<?php

$qb = require "bootstrap.php";

$tarefas = $qb->selectAll("tarefas");

require "index.view.php";
