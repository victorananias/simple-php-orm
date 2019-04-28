<?php

namespace App\Core\Database\Queriable;

class Insert
{
    protected $table;
    protected $query = '';
    protected $params = [];

    public function __construct($table, $data = null)
    {
        $this->table = $table;

        if ($data) {
            $this->add($data);
        }
    }

    public function __toString()
    {
        return $this->query;
    }

    public function params()
    {
        return $this->params;
    }

    protected function add($data)
    {
        if ($this->query != '') {
            $this->query .= '; ';
        }

        $this->query .= sprintf(
            'insert into %s(%s) values(%s)',
            $this->table,
            implode(', ', array_keys($data)),
            substr(str_repeat('?, ', count($data)), 0, -2)
        );

        $this->params = array_merge($this->params, array_values($data));
    }

    public function addMultiple($data)
    {
        foreach ($data as $insert) {
            $this->add($insert);
        }
    }
}
