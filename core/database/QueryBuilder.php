<?php

namespace App\Core\Database;

use \PDO;

class QueryBuilder
{
    protected $table;
    protected $sql = '';

    protected $stmt;
    protected $where;
    protected $select;

    protected $limit = null;
    protected $joins = [];
    protected $groupBy = [];
    protected $order = [];
    protected $params = [];

    public function __construct(PDO $pdo)
    {
        $this->stmt = new Statement($pdo);

        $this->select = new Select();
        $this->where = new Where();
    }

    public function testing()
    {
        $this->stmt->setTesting();
        return $this;
    }

    /**
     * set table name
     *
     * @param string $name
     * @return void
     */
    public function from($name = null)
    {
        return $this->table($name);
    }

    /**
     *
     * set table name
     *
     * @param string $name
     * @return $this
     */
    public function table($name = null)
    {
        if (!$name) {
            die('Table name not specified.');
        }

        $this->table = $name;

        return $this;
    }

    public function limit($limit = 10)
    {
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
    public function whereLike($column, $value)
    {
        $this->where->add($column, 'like', $value);
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

    public function all()
    {
        return $this->stmt("select * from {$this->table}")->fetchAll();
    }

    public function groupBy(...$columns)
    {
        $this->groupBy = $columns;
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
        $this->select->setColumns($columns);
        return $this;
    }

    public function pluck($column)
    {
        $this->sql = $this->select->prepare($this->table, $this->where);

        $result = $this->stmt->setQuery($this->sql)->fetchAll($this->select->params());

        if (count($result) == 0) {
            return [];
        }

        return array_map(function ($i) use ($column) {
            return $i->$column;
        }, $result);
    }

    /**
     *
     */
    public function get()
    {
        $this->sql = $this->select->prepare($this->table, $this->where);

        return $this->stmt->setQuery($this->sql)->fetchAll($this->select->params());
    }

    public function first()
    {
        $this->limit = 1;

        $this->sql = $this
            ->select
            ->prepare($this->table, $this->where, $this->joins, 1, $this->order, $this->groupBy);

        return $this->stmt->setQuery($this->sql)->fetch();
    }

    /**
     * @param $table
     * @param $column1
     * @param $condition
     * @param $column2
     * @param string $type
     * @return $this
     */
    public function join($table, $column1, $condition, $column2, $type = 'inner')
    {
        $this->joins[] = "{$type} join {$table} on {$column1} {$condition} {$column2}";
        return $this;
    }

    public function create($data = [])
    {
        $insert = new Insert($this->table, $data);
        return $this->stmt->setQuery($insert)->execute($insert->params());
    }

    public function orderBy($column, $type = 'asc')
    {
        $this->order = compact(['column', 'type']);
        return $this;
    }

    public function update($data)
    {
        $columns = implode(' = ?, ', array_keys($data)) . ' = ? ';

        $where = $this->where->sql();

        $sql = sprintf('UPDATE %s SET %s %s', $this->table, $columns, $where);

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute(array_values($data));
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function raw($sql)
    {
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

    public function toSql()
    {
        $this->sql = $this->select->prepare($this->table, $this->where);

        return $this->sql;
    }

    public function count()
    {
        $this->select->setColumns(['count(*)'])->prepare($this->table, $this->where);

        return $this->stmt->setQuery($this->select)->fetchColumn($this->select->params());
    }
}
