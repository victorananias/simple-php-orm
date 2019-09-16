<?php

namespace SimpleORM\Queriables;

class Select implements Queriable
{
    public $columns = ['*'];
    public $params = [];
    public $table;

    protected $where;
    protected $orderBy;
    protected $groupBy;
    protected $limit;
    protected $joins = [];

    /**
     * @param mixed ...$columns
     * @return $this
     */
    public function columns(...$columns)
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * sets the table for the select
     *
     * @param string $table
     * @return Select
     */
    public function from($table, $alias = null)
    {
        $this->table = $table . ($alias ? " as {$alias}" : '');
        return $this;
    }

    /**
     * receives the Where class
     *
     * @param Where $where
     * @return Select
     */
    public function where(Where $where)
    {
        $this->where = $where;
        return $this;
    }

    /**
     * receives group by
     *
     * @param GroupBy $groupBy
     */
    public function groupBy(GroupBy $groupBy)
    {
        $this->groupBy = $groupBy;
    }

    /**
     * receives joins
     *
     * @param Join $join
     */
    public function join(Join $join)
    {
        $this->joins[] = $join;
    }

    /**
     * receives the OrderBy class
     *
     * @param OrderBy $orderBy
     * @return Select
     */
    public function orderby(OrderBy $orderBy)
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * returns the select params
     *
     * @return array
     */
    public function params()
    {
        return $this->params;
    }

    /**
     * add model params to the params array
     *
     * @param $class
     */
    protected function addParams($class)
    {
        $this->params = array_merge($this->params, $class->params());
    }

    /**
     * array columns to string
     *
     * @return string
     */
    protected function getColumnsString()
    {
        return implode(', ', $this->columns);
    }

    /**
     * receives limit
     *
     * @param $limit
     */
    public function limit($limit)
    {
        $this->limit = $limit;
    }

    public function __toString()
    {
        $query = "select {$this->getColumnsString()} from {$this->table}";

        foreach ($this->joins as $join) {
            $this->addParams($join);
            $query .= ' ' . $join->__toString();
        }

        if ($this->where && $this->where->__toString()) {
            $query .= ' ' . $this->where;
            $this->addParams($this->where);
        }

        if ($this->groupBy && $this->groupBy->__toString()) {
            $query .= ' ' . $this->groupBy;
            $this->addParams($this->groupBy);
        }

        if ($this->orderBy && $this->orderBy->__toString()) {
            $query .= ' ' . $this->orderBy;
        }

        if ($this->limit) {
            return $this->limit->exec($query);
        }

        return $query;
    }
}
