<?php

namespace App\Core\Database;

use \PDO;

class QueryBuilder {

    protected $pdo;

    protected $table;
    protected $sql = '';

    protected $where;
    
    protected $limit;
    protected $joins = [];
    protected $columns = [];
    protected $group = [];
    protected $insert = [];
    protected $order = [];
    protected $params = [];

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->where = new Where();
    }

    /**
     * set table name
     *
     * @param string $name
     * @return void
     */
    public function from($name = null) {
        return $this->table($name);
    }

    /**
     * 
     * set table name
     * 
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

    public function limit($limit= 10) {
        $this->limit = $limit;
        return $this;
    }

    /**
     * add where conditions
     *
     * @param mixed ...$data
     * @return \App\Core\Database\QueryBuilder
     */
    public function where(...$data)
    {
        // Multiple Where
        if (count($data) == 1 && is_array($data[0])) {
            $this->where->addMultiple($data);
            return $this;
        }

        $this->where->add(...$data);

        return $this;
    }

    /**
     * add where like condition
     *
     * @param string $column
     * @param string $value
     * @return \App\Core\Database\QueryBuilder
     */
    public function whereLike($column, $value) {
        $this->where->add($column, 'like' , $value);
        return $this;
    }

    /**
     * add where null condition
     *
     * @param string $column
     * @return \App\Core\Database\QueryBuilder
     */
    public function whereNull($column)
    {
        $this->where->add("{$column} is null");
        return $this;
    }

    /**
     * add where not null condition
     *
     * @param string $column
     * @param string $value
     * @return \App\Core\Database\QueryBuilder
     */
    public function whereNotNull($column)
    {
        $this->where->add("{$column} is not null");
        return $this;
    }

    public function all() {
        $this->sql = "select * from {$this->table}";
        return $this->fetchAll();
    }

    public function groupBy(...$columns) {
        $this->group = $columns;
        return $this;
    }

    /**
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

    public function pluck($column)
    {
        $this->prepareSelect();

        $result = $this->fetchAll();

        if (count($result) == 0) {
            return [];
        }

        return array_map(function($i) use ($column){
            return $i->$column;
        }, $result);
    }

    /**
     *
     */
    public function get()
    {
        if (!$this->sql) {
            $this->prepareSelect();
        }

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

    public function create($data = []) {
        $sql = sprintf(
            "INSERT INTO %s(%s) values(%s)",
            $this->table,
            implode(', ', array_keys($data)),
            substr(str_repeat('?, ', count($data)), 0, -2)
        );

        $this->insert = array_values($data);

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($this->insert);

        } catch(\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function orderBy($column, $type = 'ASC')
    {
        $this->order = compact(['column', 'type']);
        return $this;
    }

    public function update($data)
    {
        $columns = implode( ' = ?, ', array_keys($data)). ' = ? ';
        
        $where = $this->where->sql();

        $sql = sprintf("UPDATE %s SET %s %s", $this->table, $columns, $where);

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute(array_values($data));

        } catch(\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function raw($sql) {
        $this->sql = $sql;
        return $this;
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

        $where = '';
        $joins = '';
        $columns = ' *';
        $limit = '';
        $order = '';
        $groupBy = '';

        if ($this->columns) {
            $columns = ' ' . implode(', ', $this->columns);
        }

        if ($this->joins) {
            $joins = implode(' ', $this->joins);
        }

        if ($this->where->sql()) {
            $where = ' ' . $this->where->sql();
            $this->params += $this->where->params();
        } 

        if ($this->limit) {
            $limit = " top {$this->limit}";
        }

        if ($this->order) {
            $order = " by {$this->order['column']} {$this->order['type']}";
        }

        if ($this->group) {
            $groupBy = ' group by' . implode(', ', $this->group);
        }

        $this->sql = "select{$limit}{$columns} from {$this->table}{$joins}{$where}{$groupBy}{$order}";

        return $this;
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
            $statement->execute($this->params);

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
