<?php

namespace SimpleORM\Queriables;

class Insert implements Queriable
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

    public function params()
    {
        return $this->params;
    }

    /**
     * @param $data
     */
    protected function add($data)
    {
        $this->query .= sprintf(
            'insert into %s(%s) values(%s)',
            $this->table,
            implode(', ', array_keys($data)),
            substr(str_repeat('?, ', count($data)), 0, -2)
        );

        $this->params = array_merge($this->params, array_values($data));
    }

    /**
     * @param array $data
     */
    public function addMultiple($data = [])
    {
        $countInserts = count($data);
        $countFields = count($data[0]);
        $fields = array_keys($data[0]);

        $query = sprintf('insert into %s(%s) values', $this->table, implode(', ', $fields));
        $parenthesis = '('.substr(str_repeat('?, ', $countFields), 0, -2).'), ';
        $inserts = substr(str_repeat($parenthesis, $countInserts), 0, -2);

        $query .= $inserts;

        foreach ($data as $insert) {
            $this->params = array_merge($this->params, array_values($insert));
        }

        $this->query = $query;
    }

    public function __toString()
    {
        return $this->query;
    }
}
