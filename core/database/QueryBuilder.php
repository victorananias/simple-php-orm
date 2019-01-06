<?php

namespace App\Core\Database;

use \PDO;

class QueryBuilder {
	protected $pdo;

	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function selectAll($tabela, $classe) {
		$statement = $this->pdo->prepare("SELECT * FROM {$tabela}");
		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_CLASS, $classe);
	}

	public function select($tabela, $classe, $where = null) {
		$coluna = array_keys($where)[0];

		$sql = sprintf("SELECT * FROM %s where %s=%s",$tabela,$coluna,$where[$coluna]);

		try {
			$statement = $this->pdo->prepare($sql);
			$statement->execute();
			$statement->setFetchMode(PDO::FETCH_CLASS, $classe);
			$item = $statement->fetch(PDO::FETCH_CLASS);

		} catch(PDOException $e) {
			die($e->getMessage());
		}

		return $item; 
	}

	public function insert($tabela, $dados) {
		$sql = sprintf(
			"INSERT INTO %s(%s) values(%s)",
			$tabela,
			implode(', ', array_keys($dados)),
			':' . implode(', :', array_keys($dados))
		);

		try {
			$statement = $this->pdo->prepare($sql);
			$statement->execute($dados);

		} catch(PDOException $e) {
			die($e->getMessage());
		}
	}

	public function update($tabela, $where = [], $dados) {
		$coluna = array_keys($where)[0];

		$colunas = substr(array_reduce(array_keys($dados), function($total, $value) {
			return $total .= "$value = :$value, ";
		}, ''), 0, -2);

		$sql = sprintf("UPDATE %s SET %s where %s=%s", $tabela, $colunas, $coluna, $where[$coluna]);

		try {
			$statement = $this->pdo->prepare($sql);
			$statement->execute($dados);

		} catch(PDOException $e) {
			die($e->getMessage());
		}
	}

	public function delete($table, $where) {
		$coluna = array_keys($where)[0];
		$sql = "DELETE FROM $table WHERE {$coluna}=:{$coluna}";
		
		try {
			$statement = $this->pdo->prepare($sql);
			$statement->execute($where);

		} catch(PDOException $e) {
			die($e->getMessage());
		}
	}
}
