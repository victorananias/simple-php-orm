<?php

require 'functions.php';
require 'Tarefa.php';

$pdo = getPDO();

$statement = $pdo->prepare("select * from tarefas;");
$statement->execute();

$tarefas = $statement->fetchAll(PDO::FETCH_CLASS, "Tarefa");

require "index.view.php";
