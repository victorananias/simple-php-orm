<?php

namespace App\Core\Database\Queriable;

class Limit
{
    protected $select;
    protected $value;

    public function __construct($select, $value)
    {
        $this->select = $select;
    }
}
