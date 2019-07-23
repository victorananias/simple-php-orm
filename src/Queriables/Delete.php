<?php

namespace SimpleORM\Queriables;

class Delete implements Queriable
{
    protected $table;
    protected $where;

    public function from($table)
    {
        $this->table = $table;
        return $this;
    }

    public function where($where)
    {
        $this->where = $where;
        return $this;
    }

    public function params()
    {
        return $this->where ? $this->where->params() : []; 
    }

    public function __toString()
    {
        $query = "delete from {$this->table}";

        if ("$this->where") {
            $query .= ' ' . $this->where;
        }

        return $query;
    }
}
