<?php

namespace App\Core\Database;

use \PDO;

class QueryBuilder {
    protected $pdo;

    protected $table;
    protected $sql = '';
    protected $joins = [];
    protected $where = [];
    protected $columns = [];

	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}

    /**
     * @param string $name
     * @return $this
     */
	public function table($name = null) {
	    if (!$name) {
	        die('Table name not specified.');
        }

	    $this->table = $name;

	    return $this;
    }

    public function where(...$data)
    {
        // Simple where
        if (count($data) == 2) {
            $this->where[] = implode(' = ', $data);
        }

        // where condition specified
        if (count($data) == 3) {
            $this->where[] = implode(' ', $data);
        }

        return $this;
    }

	public function all() {
	    $this->sql = "SELECT * FROM {$this->table}";
	    return $this->fetchAll();
	}

    /**
     *
     *
     *
     * @param mixed ...$columns
     * @return $this
     */
	public function select(...$columns)
    {
	    $this->columns = $columns;
	    return $this;
	}

    /**
     *
     */
	public function get()
    {
        $this->prepareSelect();
        return $this->fetchAll();
    }

    public function join($table, $column1, $condition, $column2, $type = 'INNER')
    {
        $this->joins[] = "{$type} JOIN {$table} ON {$column1} {$condition} {$column2}";
        return $this;
    }

//	public function insert($tabela, $dados) {
//		$sql = sprintf(
//			"INSERT INTO %s(%s) values(%s)",
//			$tabela,
//			implode(', ', array_keys($dados)),
//			':' . implode(', :', array_keys($dados))
//		);
//
//		try {
//			$statement = $this->pdo->prepare($sql);
//			$statement->execute($dados);
//
//		} catch(\PDOException $e) {
//			die($e->getMessage());
//		}
//	}

//	public function update($tabela, $where = [], $dados) {
//		$column = array_keys($where)[0];
//
//		$colunas = substr(array_reduce(array_keys($dados), function($total, $value) {
//			return $total .= "$value = :$value, ";
//		}, ''), 0, -2);
//
//		$sql = sprintf("UPDATE %s SET %s where %s=%s", $tabela, $colunas, $column, $where[$column]);
//
//		try {
//			$statement = $this->pdo->prepare($sql);
//			$statement->execute($dados);
//
//		} catch(\PDOException $e) {
//			die($e->getMessage());
//		}
//	}

//	public function delete($table, $where) {
//		$coluna = array_keys($where)[0];
//		$sql = "DELETE FROM $table WHERE {$coluna}=:{$coluna}";
//
//		try {
//			$statement = $this->pdo->prepare($sql);
//			$statement->execute($where);
//
//		} catch(\PDOException $e) {
//			die($e->getMessage());
//		}
//	}

	public function toSql() {
	    $this->prepareSelect();
	    return $this->sql;
    }

    /**
     *  Prepare select query
     */
	protected function prepareSelect() {
	    $this->sql = '';
        $joins = '';
        $where = '';
        $columns = '*';

        if ($this->columns) {
            $columns = implode(', ', $this->columns);
        }

        if ($this->joins) {
            $joins = implode(' ', $this->joins);
        }

        if ($this->where) {
            $where = 'WHERE '. implode(' AND', $this->where);
        }

        $this->sql = "SELECT {$columns} FROM {$this->table} {$joins} {$where}";
    }

    /**
     *
     * Execute PDO->statement->fetchAll
     *
     * @return array
     */
	protected function fetchAll()
    {
        try {
            $statement = $this->pdo->prepare($this->sql);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_OBJ);

        } catch(\Exception $e) {
            die($e->getMessage());
        }
    }

}
