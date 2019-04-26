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

    public function sql()
    {
        return 'WHERE ' . array_reduce($this->conditions, function ($t, $i) {
            if (!$t) return $i;
            return "{$t} AND {$i}";
        });
    }

    public function params()
    {
        return $this->params;
    }

}