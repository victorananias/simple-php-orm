<?php

namespace SimpleORM\Queriables;

class Update implements Queriable
{
    protected $columns = [];
    protected $table;
    protected $where;

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function where($where)
    {
        $this->where = $where;
        return $this;
    }

    public function set($columns)
    {
        $this->columns = $columns;
        return $this;
    }

    public function params()
    {
        return $this->params;
    }

    public function __toString()
    {
        $columns = implode(' = ?, ', array_keys($this->columns)) . ' = ?';

        $query = sprintf('update %s set %s', $this->table, $columns);

        $this->params = array_values($this->columns);

        if ($this->where) {
            $query .= ' ' . $this->where;
            $this->params = array_merge($this->params, $this->where->params());
        }

        return $query;
    }


}
