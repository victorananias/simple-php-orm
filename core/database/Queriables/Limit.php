<?php

namespace App\Core\Database\Queriable;

class Limit
{
    protected $limit;

    public function __construct($limit)
    {
        $this->limit = $limit;
    }

    public function __get($value)
    {
        return $this->$value;
    }

    public function exec($select)
    {
        return substr_replace($select, " top {$this->limit} ", 6, 1);
    }
}
