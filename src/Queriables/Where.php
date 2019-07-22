<?php

namespace App\Queriables;

class Where
{
    protected $conditions = [];
    protected $params = [];

    public function add(...$data)
    {
        if (count($data) == 1) {
            $this->conditions[] = $data[0];
        }

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
                $this->conditions[] = $value;
                continue;
            }

            if (preg_match('/\b(like)\b/', $column) || preg_match('/[<>=]/', $column)) {
                $this->conditions[] = $column . ' ?';
                $this->params[] = $value;
                continue;
            }

            $this->add($column, $value);
        }
    }

    public function params()
    {
        return $this->params;
    }

    public function conditions()
    {
        return array_reduce($this->conditions, function ($t, $i) {
            if (!$t) {
                return $i;
            }

            return "{$t} and {$i}";
        });
    }

    public function __toString()
    {
        return ($this->conditions() ? 'where ' . $this->conditions() : '');
    }
}
