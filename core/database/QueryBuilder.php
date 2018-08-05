<?php

namespace App\Core\Database;

use \PDO;

class QueryBuilder {
	protected $pdo;

	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function selectAll($tabela, $classe) {
		$statement = $this->pdo->prepare("select * from {$tabela}");
		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_CLASS, $classe);
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
}
