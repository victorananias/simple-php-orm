<?php

namespace App\Core\Database;

use \PDO;

class QueryBuilder {
    protected $pdo;

    protected $table;
    protected $sql = '';

    protected $limit;
    protected $joins = [];
    protected $where = [];
    protected $columns = [];

	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function from($name = null) {
	    return $this->table($name);
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
        // Multiple Where
        if (count($data) == 1 && is_array($data[0])) {
            foreach ($data[0] as $column => $value) {
                $this->where[] = "$column = $value";
            }
        }

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

    public function whereNull($column)
    {
        $this->where[] = "{$column} IS NULL";

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

    public function first()
    {
        $this->limit = 1;
        $this->prepareSelect();
        return $this->fetch();
    }

    /**
     * @param $table
     * @param $column1
     * @param $condition
     * @param $column2
     * @param string $type
     * @return $this
     */
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

	public function update($data)
    {
		$colunas = substr(array_reduce(array_keys($data), function($total, $value) {
			return $total .= "$value = :$value, ";
		}, ''), 0, -2);

		$where = '';
        if ($this->where) {
            $where = 'WHERE '. implode(' AND ', $this->where);
        }

		$sql = sprintf("UPDATE %s SET %s %s", $this->table, $colunas, $where);

		try {
			$statement = $this->pdo->prepare($sql);
			$statement->execute($data);

		} catch(\PDOException $e) {
			die($e->getMessage());
		}
	}

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
        $limit = '';

        if ($this->columns) {
            $columns = implode(', ', $this->columns);
        }

        if ($this->joins) {
            $joins = implode(' ', $this->joins);
        }

        if ($this->where) {
            $where = 'WHERE '. implode(' AND ', $this->where);
        }

        if ($this->limit) {
            $limit = "TOP {$this->limit} ";
        }

        $this->sql = "SELECT {$limit}{$columns} FROM {$this->table} {$joins} {$where}";
    }

    public function count() {
	    $this->columns = ['count(*)'];

	    $this->prepareSelect();

	    return $this->fetchColumn();
    }

    /**
     *
     * Fetch all data for the sql query
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

    /**
     *
     * Fetch all data for the sql query
     *
     * @return array
     */
	protected function fetch()
    {
        try {
            $statement = $this->pdo->prepare($this->sql);
            $statement->execute();

            return $statement->fetch(PDO::FETCH_OBJ);

        } catch(\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     *
     * Fetch specified Column
     *
     * @return array
     */
	protected function fetchColumn($columnNumber = 0)
    {
        try {
            $statement = $this->pdo->prepare($this->sql);
            $statement->execute();

            return $statement->fetchColumn($columnNumber);

        } catch(\Exception $e) {
            die($e->getMessage());
        }
    }
}
