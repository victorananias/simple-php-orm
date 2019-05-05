<?php

namespace App\Core\Database\Queriable;

class Select
{
    public $columns = ['*'];
    public $params = [];
    public $table;

    protected $where;
    protected $orderBy;
    protected $groupBy;
    protected $limit;
    protected $joins = [];

    public function columns(...$columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * sets the table for the select
     *
     * @param string $table
     * @return void
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

    public function groupBy(GroupBy $groupBy)
    {
        $this->groupBy = $groupBy;
    }

    public function join(Join $join)
    {
        $this->joins[] = $join;
    }

    /**
     * receives the OrderBy class
     *
     * @param OrderBy $orderBy
     * @return void
     */
    public function orderby(OrderBy $orderBy)
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * returns the select params
     *
     * @return void
     */
    public function params()
    {
        return $this->params;
    }

    /**
     * add model params to the params array
     *
     * @param [type] $class
     * @return void
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

    public function limit($limit)
    {
        $this->limit = $limit;
    }

    public function __toString()
    {
        $query = "select {$this->getColumnsString()} from {$this->table}";

        if ($this->joins != []) {

            foreach ($this->joins as $j) {
                $this->addParams($j);
            }

            $query .= ' ' . implode(' ', $this->joins);
        }

        if ("$this->where") {
            $query .= ' ' . $this->where;
            $this->addParams($this->where);
        }

        if ("$this->groupBy") {
            $query .= ' ' . $this->groupBy;
            $this->addParams($this->groupBy);
        }

        if ("$this->orderBy") {
            $query .= ' ' . $this->orderBy;
        }

        if ($this->limit) {
            return $this->limit->exec($query);
        }

        return $query;
    }
}
