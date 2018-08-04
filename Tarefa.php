<?php

class Tarefa {
	public $id;
	public $descricao;
	public $completa;

	public function __construct() {}

	public function completar() {
		$this->completa = true;
	}

	public function foiCompleta() {
		return $this->completa;
	}
}