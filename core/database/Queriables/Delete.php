<?php

namespace App\Core\Database\Queriable;

class Delete
{
    protected $table;
    protected $where;

    public function from($table)
    {
        $this->table = $table;
    }

    public function where($where)
    {
        $this->where = $where;
    }

    public function __toString()
    {
        $query = "delete from {$this->table}";

        if ("$this->where") {
            $query .= ' ' . $this->where;
        }

        return $query;
    }

    public function params()
    {
        return $this->where ? $this->where->params() : []; 
    }
}
