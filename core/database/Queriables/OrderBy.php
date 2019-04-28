<?php

namespace App\Core\Database\Queriable;

class OrderBy
{
    protected $conditions = [];

    public function __construct($column = null, $type = null)
    {
        if ($column) {
            $this->add($column, $type);
        }
    }

    public function add($column, $type = null)
    {
        $order =  "{$column}";
        
        if ($type) {
            $order .= ' '. $type;
        }

        $this->conditions[] =$order;
    }

    public function __toString()
    {
        if ($this->conditions == []) {
            return '';
        }
        
        return 'order by ' . implode(', ', $this->conditions);
    }
}
