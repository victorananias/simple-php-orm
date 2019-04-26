<?php

namespace App\Core\Database;


class Where
{
    protected $conditions = [];
    protected $params = [];

    public function add(...$data)
    {
        if (count($data) == 2) {
            $this->conditions[] = "{$data[0]} = ?";
            $this->params[] = $data[1];
        }

        if (count($data) == 3) {
            $this->conditions[] = "{$data[0]} {$data[1]} ?";
            $this->params[] = $data[2];
        }
    }

    public function addMultiple($where = [])
    {

        foreach ($where as $column => $value) {
            if (is_numeric($column)) {
                $this->conditions[] = "{$data[0]} = ?";
            }

            $this->add($column, $value);
        }
    }

    public function sql()
    {
        return 'where ' . array_reduce($this->conditions, function ($t, $i) {
            if (!$t) return $i;
            return "{$t} and {$i}";
        });
    }

    public function params()
    {
        return $this->params;
    }

}