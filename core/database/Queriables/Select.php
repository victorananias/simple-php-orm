<?php

namespace App\Core\Database\Queriable;

class Select
{
    public $columns;
    public $params = [];
    public $table;

    protected $where;
    protected $orderBy;

    public function __construct($columns = ['*'])
    {
        if (!$columns) {
            return $this;
        }

        $this->columns = $columns;

        return $this;
    }

    /**
     * sets the table for the select
     *
     * @param string $table
     * @return void
     */
    public function from($table)
    {
        $this->table = $table;
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

    public function __toString()
    {
        $query = "select {$this->getColumnsString()} from {$this->table}";

        if ("$this->where") {
            $query .= ' ' . $this->where;
            $this->addParams($this->where);
        } 
        
        if ("$this->orderBy") {
            $query .= ' ' . $this->orderBy;
        } 

        return $query;
    }
}
