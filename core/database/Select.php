<?php

namespace App\Core\Database;

class Select
{
    protected $columns = [];
    protected $query = '';
    protected $params = [];

    public function setColumns($columns)
    {
        $this->columns = $columns;
    }

    /**
     *  Prepare select query
     */
    public function prepare($table, Where $where)
    {
        $this->addParams($where);

        $this->query = "select {$this->getColumns()} from {$table}{$where}";

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
    protected function getColumns()
    {
        return $this->columns != [] ? ' ' . implode(', ', $this->columns) : '*';
    }

    public function __toString()
    {
        return $this->query;
    }
}
