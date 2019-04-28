<?php

namespace App\Core\Database\Queriable;

class Update
{
    protected $columns = [];

    public function __construct(...$columns)
    {
        $this->columns = $columns;
    }
}
