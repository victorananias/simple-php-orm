<?php

namespace SimpleORM\Queriables;

class Join implements Queriable
{
    protected $table;
    protected $conditions = [];
    protected $where;

    public function __construct($table)
    {
        $this->table = $table;
        $this->where = new Where;
    }

    public function on(...$params)
    {
        $condition = [];

        $condition['column1'] = $params[0];

        if (count($params) == 2) {
            $condition['operator'] = '=';
            $condition['column2'] = $params[1];
        }

        if (count($params) == 3) {
            $condition['operator'] = $params[1];
            $condition['column2'] = $params[2];
        }

        $this->conditions[] = $condition;
    }

    /**
     * add where conditions
     *
     * @param mixed ...$data
     * @return \App\Core\Database\QueryBuilder
     */
    public function where(...$data)
    {
        // Multiple Where
        if (count($data) == 1 && is_array($data[0])) {
            $this->where->addMultiple($data);
            return $this;
        }

        $this->where->add(...$data);

        return $this;
    }

    public function params()
    {
        return $this->where->params();
    }

    public function __toString()
    {
        $query =  "join {$this->table} on ". array_reduce($this->conditions, function ($t, $c) {

            $c = "{$c['column1']} {$c['operator']} {$c['column2']}";

            if (!$t) return $c;
            
            return "{$t} and {$c}";
        });

        if ($this->where->conditions()) {
            $query .= ' and ' . $this->where->conditions();
        }

        return $query;
    }

}
