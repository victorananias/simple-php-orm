<?php

require('functions.php');

class Tarefa {
	public $completa = false;

	public function __construct($descricao) {
		$this->descricao = $descricao;
	}

	public function completar() {
		$this->completa = true;
	}

	public function foiCompleta() {
		return $this->completa;
	}
}

$tarefas = [
	new Tarefa("Estudar Angular 2"),
	new Tarefa("Estudar PHP"),
	new Tarefa("Estudar Laravel")
];

$tarefas[0]->completar();
$tarefas[1]->completar();


require "index.view.php";