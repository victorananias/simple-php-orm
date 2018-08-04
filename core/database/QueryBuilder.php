<?php

class QueryBuilder {
  protected $pdo;

  public function __construct(PDO $pdo) {
      $this->pdo = $pdo;
  }

  public function selectAll($tabela) {
    $statement = $this->pdo->prepare("select * from {$tabela}");
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_OBJ);
  }
}
