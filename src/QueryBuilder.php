<?php

namespace SimpleORM;

use \PDO;
use SimpleORM\Queriables\Select;
use SimpleORM\Queriables\Where;
use SimpleORM\Queriables\Update;
use SimpleORM\Queriables\Insert;
use SimpleORM\Queriables\OrderBy;
use SimpleORM\Queriables\Join;
use SimpleORM\Queriables\LeftJoin;
use SimpleORM\Queriables\GroupBy;
use SimpleORM\Queriables\Delete;
use SimpleORM\Queriables\Limit;

class QueryBuilder
{
    protected $pdo;

    protected $table;
    protected $tableAlias;
    protected $sql = '';

    protected $stmt;
    protected $where;
    protected $select;
    protected $orderBy;
    protected $joins = [];

    protected $limit = null;
    protected $params = [];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->stmt = new Statement($pdo);

        $this->select = new Select();
        $this->where = new Where();
        $this->orderBy = new OrderBy();
    }

    public function toSql()
    {
        $this->stmt->setToSql();
        return $this;
    }

    /**
     * set table name
     *
     * @param string $name
     * @return void
     */
    public function from($table = null, $alias = null)
    {
        return $this->table($table, $alias);
    }

    /**
     *
     * set table name
     *
     * @param string $name
     * @return $this
     */
    public function table($table = 'table', $alias = null)
    {
        $this->table = $alias ? $table . ' as ' . $alias : $table;

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
            $this->where->addMultiple($data[0]);
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

    public function count()
    {
        $this->select
            ->from($this->table)
            ->columns('count(*)')
            ->where($this->where)
            ->orderBy($this->orderBy)
            ->limit(new Limit(1));

        foreach ($this->joins as $join) {
            $this->select->join($join);
        }

        return $this->stmt->setQuery("$this->select")->fetchColumn(0, $this->select->params());
    }

    /**
     * fetch all the rows on the given table
     *
     * @return void
     */
    public function all()
    {
        $this->select->from($this->table);
        return $this->stmt->setQuery("$this->select")->fetchAll();
    }

    public function groupBy(...$columns)
    {
        $this->select->groupBy(new GroupBy(...$columns));
        return $this;
    }

    /**
     * adds the columns to the select query
     *
     * @param mixed ...$columns
     * @return $this
     */
    public function select(...$columns)
    {
        $this->select->columns(...$columns);
        return $this;
    }

    public function pluck($column)
    {
        // $this->sql = $this->select->prepare($this->table, $this->where);

        // $result = $this->stmt->setQuery($this->sql)->fetchAll($this->select->params());

        // if (count($result) == 0) {
        //     return [];
        // }

        // return array_map(function ($i) use ($column) {
        //     return $i->$column;
        // }, $result);
    }

    /**
     *
     */
    public function get()
    {
        if ($this->sql) {
            return $this->stmt->setQuery($this->sql)->fetchAll($this->params);
        }

        $this->select
            ->from($this->table)
            ->where($this->where)
            ->orderBy($this->orderBy);

        foreach ($this->joins as $join) {
            $this->select->join($join);
        }

        return $this->stmt->setQuery("$this->select")->fetchAll($this->select->params());
    }

    public function first()
    {
        $result = $this->limit(1)->get();
        return isset($result[0]) ? $result[0] : $result;
    }

    public function limit($limit)
    {
        $this->select->limit(new Limit($limit));

        return $this;
    }

    /**
     * join
     *
     * @param string ...$params
     * @return QueryBuilder
     */
    public function join(...$params)
    {
        $join = new Join($params[0]);

        $join = $this->checkJoinParams($join, $params);

        $this->joins[] = $join;

        return $this;
    }

    /**
     * leftJoin
     *
     * @param string ...$params
     * @return QueryBuilder
     */
    public function leftJoin(...$params)
    {
        $join = new LeftJoin($params[0]);

        $join = $this->checkJoinParams($join, $params);

        $this->joins[] = $join;

        return $this;
    }

    private function checkJoinParams($join, $params)
    {
        if (count($params) == 2) {
            $params[1]($join);
        }

        if (count($params) == 3) {
            $join->on($params[1], $params[2]);
        }

        if (count($params) == 4) {
            $join->on($params[1], $params[2], $params[3]);
        }

        return $join;
    }

    /**
     * records the given data on the given table
     *
     * @param array $data
     * @return void
     */
    public function create($data = [])
    {
        $insert = new Insert($this->table, $data);
        return $this->stmt->setQuery("$insert")->execute($insert->params());
    }

    public function orderBy($column, $type = null)
    {
        if (!$this->orderBy) {
            $this->orderBy = new OrderBy($column, $type);
            return $this;
        }

        $this->orderBy->add($column, $type);

        return $this;
    }

    public function update($data = [])
    {
        $update = new Update();

        $update->table($this->table);
        $update->where($this->where);
        $update->set($data);

        return $this->stmt->setQuery("$update")->execute($update->params());
    }

    public function raw($sql, $params = [])
    {
        $this->sql = $sql;
        $this->params = $params;

        return $this;
    }

    public function delete()
    {
        $delete = new Delete();
        $delete->from($this->table)->where($this->where);
        return $this->stmt->setQuery("$delete")->execute($delete->params());
    }
}
