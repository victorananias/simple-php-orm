<?php

$qb = require "bootstrap.php";
require 'Tarefa.php';

$tarefas = $qb->selectAll("tarefas");

$tarefas = array_map(function($tarefa) {
  $t = new Tarefa();
  $t->descricao = $tarefa->descricao;
  $t->completa = $tarefa->completa;
  return $t;
}, $tarefas);

require "index.view.php";
